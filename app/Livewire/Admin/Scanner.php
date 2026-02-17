<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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

    // Manual attendance properties
    public bool $showManualInput = false;
    public string $manualSearch = '';
    public array $searchResults = [];

    public function updatedManualSearch()
    {
        if (strlen($this->manualSearch) < 2) {
            $this->searchResults = [];
            return;
        }

        $today = Carbon::today();

        $this->searchResults = Santri::where('name', 'like', '%' . $this->manualSearch . '%')
            ->select('id', 'name', 'avatar')
            ->limit(8)
            ->get()
            ->map(function ($santri) use ($today) {
                $alreadyAttended = Attendance::where('santri_id', $santri->id)
                    ->where('date', $today)
                    ->exists();

                return [
                    'id' => $santri->id,
                    'name' => $santri->name,
                    'avatar' => $santri->avatar,
                    'already_attended' => $alreadyAttended,
                ];
            })
            ->toArray();
    }

    public function toggleManualInput()
    {
        $this->showManualInput = !$this->showManualInput;
        $this->manualSearch = '';
        $this->searchResults = [];
    }

    public function processManualAttendance(int $santriId)
    {
        $santri = Santri::find($santriId);

        if (!$santri) {
            $this->showError = true;
            $this->errorMessage = 'Santri tidak ditemukan.';
            $this->showManualInput = false;
            return;
        }

        $this->showManualInput = false;
        $this->manualSearch = '';
        $this->searchResults = [];

        $this->recordAttendance($santri);
    }

    public function processQrCode(string $token)
    {
        $this->reset(['showSuccess', 'showError', 'errorMessage', 'scannedSantri']);

        // Find santri by QR token
        $santri = Santri::where('qr_token', $token)->first();

        if (!$santri) {
            $this->showError = true;
            $this->errorMessage = 'QR Code tidak valid atau santri tidak ditemukan.';
            return;
        }

        $this->recordAttendance($santri);
    }

    /**
     * Shared logic: record attendance for a santri.
     * Used by both QR scan and manual attendance.
     */
    private function recordAttendance(Santri $santri): void
    {
        $this->reset(['showSuccess', 'showError', 'errorMessage', 'scannedSantri']);

        $today = Carbon::today();

        // Check if already attended today
        $existingAttendance = Attendance::where('santri_id', $santri->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance) {
            $this->showError = true;
            $this->errorMessage = $santri->name . ' sudah absen hari ini.';
            return;
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

        $this->scannedSantri = $santri->fresh();
        $this->showSuccess = true;
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

        return view('livewire.admin.scanner', [
            'todayAttendances' => $todayAttendances,
            'todayCount' => $todayCount,
        ]);
    }
}
