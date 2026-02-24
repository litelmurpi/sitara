<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Santri;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Table configuration for export/import.
     * Order matters for import (respects foreign key constraints).
     */
    private array $tables = [
        'users' => User::class,
        'settings' => Setting::class,
        'santris' => Santri::class,
        'attendances' => Attendance::class,
        'achievements' => Achievement::class,
        'finances' => Finance::class,
        'materials' => Material::class,
        'galleries' => Gallery::class,
        'quizzes' => Quiz::class,
        'quiz_questions' => QuizQuestion::class,
    ];

    /**
     * Table labels in Indonesian.
     */
    public static function getTableLabels(): array
    {
        return [
            'users' => 'Users',
            'settings' => 'Pengaturan',
            'santris' => 'Santri',
            'attendances' => 'Kehadiran',
            'achievements' => 'Prestasi',
            'finances' => 'Keuangan',
            'materials' => 'Materi',
            'galleries' => 'Galeri',
            'quizzes' => 'Kuis',
            'quiz_questions' => 'Soal Kuis',
        ];
    }

    /**
     * Export all data as a ZIP file containing CSV files.
     */
    public function export()
    {
        $timestamp = now()->format('Y-m-d_His');
        $zipFilename = "sitara_backup_{$timestamp}.zip";
        $zipPath = storage_path("app/{$zipFilename}");

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Gagal membuat file backup.');
        }

        // Temporary directory for CSV files before zipping
        $tempDir = storage_path('app/backup_export_' . uniqid());
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        foreach ($this->tables as $tableName => $modelClass) {
            $csvPath = "{$tempDir}/{$tableName}.csv";
            $this->streamTableToCsv($tableName, $csvPath);
            $zip->addFile($csvPath, "{$tableName}.csv");
        }

        // Add metadata file
        $metadata = json_encode([
            'app' => 'SITARA',
            'exported_at' => now()->toIso8601String(),
            'tables' => array_map(fn($model) => $model::count(), $this->tables),
        ], JSON_PRETTY_PRINT);

        $metadataPath = "{$tempDir}/_metadata.json";
        file_put_contents($metadataPath, $metadata);
        $zip->addFile($metadataPath, '_metadata.json');

        $zip->close();

        // Download and delete the temp dir/files automatically after sending the zip
        return response()->download($zipPath, $zipFilename)->deleteFileAfterSend();
    }

    /**
     * Import data from a CSV file into a specific table.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|max:51200', // max 50MB
            'table_name' => 'required|string|in:' . implode(',', array_keys($this->tables)),
        ]);

        $tableName = $request->input('table_name');
        $file = $request->file('csv_file');

        // Validate file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension !== 'csv') {
            return back()->with('error', 'File harus berformat CSV.');
        }

        try {
            $this->disableForeignKeyChecks();
            DB::beginTransaction();

            // Delete existing data in the table (except users to keep admin safe)
            if ($tableName !== 'users') {
                DB::table($tableName)->delete();
            }

            // Import CSV data with Spatie Simple Excel (Streaming)
            $imported = $this->streamCsvToTable($tableName, $file->getRealPath());

            // Recalculate total points if importing santri-related tables
            if (in_array($tableName, ['santris', 'attendances', 'achievements'])) {
                DB::table('santris')->update(['total_points' => 0]); // Reset first
                $santris = Santri::withTrashed()->get();
                foreach ($santris as $santri) {
                    $attendancePoints = $santri->attendances()->sum('points_gained');
                    $achievementPoints = $santri->achievements()->sum('points');
                    DB::table('santris')
                        ->where('id', $santri->id)
                        ->update(['total_points' => $attendancePoints + $achievementPoints]);
                }
            }

            DB::commit();
            $this->enableForeignKeyChecks();

            $label = self::getTableLabels()[$tableName] ?? $tableName;
            return back()->with('message', "Data {$label} berhasil diimport! ({$imported} record dipulihkan)");
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->enableForeignKeyChecks();

            Log::error('Backup import failed: ' . $e->getMessage(), [
                'table' => $tableName,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Disable foreign key checks.
     */
    private function disableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = replica');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        }
    }

    /**
     * Enable foreign key checks.
     */
    private function enableForeignKeyChecks(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('SET session_replication_role = DEFAULT');
        } elseif ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }
    }

    /**
     * Stream database records into a CSV file efficiently to prevent OOM.
     */
    private function streamTableToCsv(string $tableName, string $filePath): void
    {
        // Add UTF-8 BOM automatically to CSV via spout config if needed, using simple excel defaults
        $writer = SimpleExcelWriter::create($filePath)->addHeader(Schema::getColumnListing($tableName));

        // Use lazy() to process records one by one without loading all into RAM
        DB::table($tableName)->orderBy('id')->lazy(1000)->each(function ($record) use ($writer) {
            $writer->addRow((array) $record);
        });

        $writer->close();
    }

    /**
     * Stream CSV file into the database using chunks to prevent OOM.
     */
    private function streamCsvToTable(string $tableName, string $filePath): int
    {
        $reader = SimpleExcelReader::create($filePath, 'csv')->trimHeaderRow();
        $validColumns = Schema::getColumnListing($tableName);

        $imported = 0;
        $batchSize = 1000;
        $batch = [];

        $reader->getRows()->each(function (array $row) use (&$batch, &$imported, $tableName, $validColumns, $batchSize) {
            // Filter only valid columns
            $record = array_intersect_key($row, array_flip($validColumns));

            // Convert empty strings to null for nullable fields
            foreach ($record as $key => $value) {
                if ($value === '') {
                    $record[$key] = null;
                }
            }

            // Process users table specific logic
            if ($tableName === 'users') {
                $existingUser = DB::table('users')->where('email', $record['email'] ?? '')->first();
                if ($existingUser) {
                    $updateData = array_diff_key($record, array_flip(['id', 'password']));
                    DB::table('users')->where('id', $existingUser->id)->update($updateData);
                    $imported++;
                    return; // Skip adding to batch for inserts
                }
            }

            $batch[] = $record;

            // Insert in chunks of 1000
            if (count($batch) >= $batchSize) {
                DB::table($tableName)->insert($batch);
                $imported += count($batch);
                $batch = [];
            }
        });

        // Insert remaining records in the last batch
        if (!empty($batch)) {
            DB::table($tableName)->insert($batch);
            $imported += count($batch);
        }

        // Reset auto-increment for PostgreSQL
        if (DB::getDriverName() === 'pgsql') {
            $maxId = DB::table($tableName)->max('id');
            if ($maxId) {
                DB::statement("SELECT setval(pg_get_serial_sequence('{$tableName}', 'id'), {$maxId})");
            }
        }

        return $imported;
    }
}
