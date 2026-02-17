<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Finance;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportExportController extends Controller
{
    public function export(Request $request): StreamedResponse
    {
        $type = $request->get('type', 'attendance');
        $startDate = $request->get('start');
        $endDate = $request->get('end');

        $filename = "laporan_{$type}_{$startDate}_{$endDate}.csv";

        return response()->streamDownload(function () use ($type, $startDate, $endDate) {
            $handle = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            if ($type === 'attendance') {
                $this->exportAttendance($handle, $startDate, $endDate);
            } elseif ($type === 'points') {
                $this->exportPoints($handle, $startDate, $endDate);
            } elseif ($type === 'finance') {
                $this->exportFinance($handle, $startDate, $endDate);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function exportAttendance($handle, $startDate, $endDate): void
    {
        fputcsv($handle, ['No', 'Nama Santri', 'Hadir', 'Telat', 'Poin Kehadiran']);

        $santris = Santri::withCount([
            'attendances as total_hadir' => function ($query) use ($startDate, $endDate) {
                $query->where('status', 'present')
                    ->whereBetween('date', [$startDate, $endDate]);
            },
            'attendances as total_telat' => function ($query) use ($startDate, $endDate) {
                $query->where('status', 'late')
                    ->whereBetween('date', [$startDate, $endDate]);
            },
        ])
            ->withSum(['attendances as total_poin' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }], 'points_gained')
            ->orderByDesc('total_hadir')
            ->get();

        foreach ($santris as $index => $santri) {
            fputcsv($handle, [
                $index + 1,
                $santri->name,
                $santri->total_hadir ?? 0,
                $santri->total_telat ?? 0,
                $santri->total_poin ?? 0,
            ]);
        }
    }

    private function exportPoints($handle, $startDate, $endDate): void
    {
        fputcsv($handle, ['Rank', 'Nama Santri', 'Poin Kehadiran', 'Poin Achievement', 'Total Poin']);

        $santris = Santri::withSum(['attendances as poin_kehadiran' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }], 'points_gained')
            ->withSum(['achievements as poin_achievement' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate, $endDate]);
            }], 'points')
            ->get()
            ->map(function ($santri) {
                $santri->total_poin = ($santri->poin_kehadiran ?? 0) + ($santri->poin_achievement ?? 0);
                return $santri;
            })
            ->sortByDesc('total_poin')
            ->values();

        foreach ($santris as $index => $santri) {
            fputcsv($handle, [
                $index + 1,
                $santri->name,
                $santri->poin_kehadiran ?? 0,
                $santri->poin_achievement ?? 0,
                $santri->total_poin ?? 0,
            ]);
        }
    }

    private function exportFinance($handle, $startDate, $endDate): void
    {
        fputcsv($handle, ['Tanggal', 'Tipe', 'Kategori', 'Keterangan', 'Jumlah']);

        $transactions = Finance::whereBetween('date', [$startDate, $endDate])
            ->orderByDesc('date')
            ->get();

        foreach ($transactions as $tx) {
            fputcsv($handle, [
                $tx->date?->format('d/m/Y'),
                $tx->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                ucfirst($tx->category),
                $tx->description,
                $tx->amount,
            ]);
        }

        // Add summary
        $totalIncome = Finance::whereBetween('date', [$startDate, $endDate])->income()->sum('amount');
        $totalExpense = Finance::whereBetween('date', [$startDate, $endDate])->expense()->sum('amount');

        fputcsv($handle, []);
        fputcsv($handle, ['', '', '', 'Total Pemasukan', $totalIncome]);
        fputcsv($handle, ['', '', '', 'Total Pengeluaran', $totalExpense]);
        fputcsv($handle, ['', '', '', 'Saldo', $totalIncome - $totalExpense]);
    }
}
