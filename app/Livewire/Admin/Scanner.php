<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Scanner Kehadiran')]
class Scanner extends Component
{
    public ?Santri $scannedSantri = null;
    public bool $showSuccess = false;
    public bool $showError = false;
    public string $errorMessage = '';
    public int $pointsGained = 0;
    public string $attendanceStatus = '';

    // Batch attendance properties
    public bool $showBatchInput = false;
    public string $batchSearch = '';
    public array $selectedSantris = [];
    public int $batchSuccessCount = 0;

    public function toggleBatchInput()
    {
        $this->showBatchInput = !$this->showBatchInput;
        $this->batchSearch = '';
        $this->selectedSantris = [];
        $this->reset(['showSuccess', 'showError', 'errorMessage', 'scannedSantri', 'batchSuccessCount']);
    }

    public function processBatchAttendance()
    {
        // Filter out false values from un-checked boxes
        $selectedIds = array_filter($this->selectedSantris);

        if (empty($selectedIds)) {
            $this->showError = true;
            $this->errorMessage = 'Pilih minimal satu santri untuk diabsen.';
            return;
        }

        $processedCount = 0;
        foreach ($selectedIds as $santriId => $isSelected) {
            $santri = Santri::find($santriId);
            if ($santri) {
                $success = $this->recordSingleAttendance($santri);
                if ($success) {
                    $processedCount++;
                }
            }
        }

        $this->showBatchInput = false;
        $this->batchSearch = '';
        $this->selectedSantris = [];

        if ($processedCount > 0) {
            $this->batchSuccessCount = $processedCount;
            $this->showSuccess = true;
            $this->attendanceStatus = "Berhasil mengabsen {$processedCount} santri sekaligus.";
            $this->scannedSantri = null; // null indicates batch success UI instead of QR success UI
        } else {
            $this->showError = true;
            $this->errorMessage = 'Semua santri yang dicentang sudah absen hari ini.';
        }
    }

    public function processQrCode(string $token)
    {
        $this->reset(['showSuccess', 'showError', 'errorMessage', 'scannedSantri', 'batchSuccessCount']);

        // Find santri by QR token
        $santri = Santri::where('qr_token', $token)->first();

        if (!$santri) {
            $this->showError = true;
            $this->errorMessage = 'QR Code tidak valid atau santri tidak ditemukan.';
            return;
        }

        $success = $this->recordSingleAttendance($santri);
        if ($success) {
            $this->scannedSantri = $santri->fresh();
            $this->showSuccess = true;
        } else {
            $this->showError = true;
            $this->errorMessage = $santri->name . ' sudah absen hari ini.';
        }
    }

    /**
     * Shared logic: record attendance for a single santri.
     * Returns true if attendance was recorded, false if already attended.
     */
    private function recordSingleAttendance(Santri $santri): bool
    {
        $today = Carbon::today();

        // Check if already attended today
        $existingAttendance = Attendance::where('santri_id', $santri->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance) {
            return false;
        }

        // Determine points based on arrival time
        $now = Carbon::now();
        $onTimeLimit = Carbon::today()->setTime(15, 30, 0);

        if ($now->lte($onTimeLimit)) {
            $this->pointsGained = 10;
            $this->attendanceStatus = 'Hadir Tepat Waktu';
        } else {
            $this->pointsGained = 5;
            $this->attendanceStatus = 'Hadir Terlambat';
        }

        // Create attendance record
        Attendance::create([
            'santri_id' => $santri->id,
            'date' => $today,
            'status' => 'hadir',
            'check_in_time' => $now,
            'points_gained' => $this->pointsGained,
        ]);

        // Update santri total points
        $santri->recalculateTotalPoints();

        // Check for weekly bonus (7 consecutive days)
        $bonusAwarded = $santri->checkWeeklyBonus();
        if ($bonusAwarded) {
            $this->pointsGained += 25;
            $this->attendanceStatus .= ' + Bonus Mingguan! 🎉';
            $santri->recalculateTotalPoints();
        }

        return true;
    }

    public function closeModal()
    {
        $this->showSuccess = false;
        $this->showError = false;
        $this->dispatch('modal-closed');
    }

    public function render()
    {
        $todayAttendances = Attendance::with('santri')
            ->whereDate('date', Carbon::today())
            ->latest('check_in_time')
            ->take(10)
            ->get();

        $todayCount = Attendance::whereDate('date', Carbon::today())
            ->where('status', 'hadir')
            ->count();

        // Data for batch attendance
        $allSantris = [];
        if ($this->showBatchInput) {
            $query = Santri::query();

            // Apply search filter if any
            if (strlen($this->batchSearch) >= 2) {
                $query->where('name', 'like', '%' . $this->batchSearch . '%');
            }

            $today = Carbon::today();
            $allSantris = $query->orderBy('name')->get()->map(function ($santri) use ($today) {
                $alreadyAttended = Attendance::where('santri_id', $santri->id)
                    ->where('date', $today)
                    ->exists();

                return [
                    'id' => $santri->id,
                    'name' => $santri->name,
                    'avatar' => $santri->avatar,
                    'already_attended' => $alreadyAttended,
                ];
            })->toArray();
        }

        return view('livewire.admin.scanner', [
            'todayAttendances' => $todayAttendances,
            'todayCount' => $todayCount,
            'allSantris' => $allSantris,
        ]);
    }
}
