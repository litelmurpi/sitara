<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Attendance;
use App\Models\Achievement;
use App\Models\Finance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Laporan')]
class ReportIndex extends Component
{
    #[Url]
    public string $activeTab = 'attendance';

    #[Url]
    public string $startDate = '';

    #[Url]
    public string $endDate = '';

    public function mount()
    {
        if (empty($this->startDate)) {
            $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        }
        if (empty($this->endDate)) {
            $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
    }

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function getAttendanceReport()
    {
        return Santri::withCount([
            // Count all 'hadir' status (both on-time and late)
            'attendances as total_hadir' => function ($query) {
                $query->where('status', 'hadir')
                    ->whereBetween('date', [$this->startDate, $this->endDate]);
            },
            // Late = hadir but only got 5 points (instead of 10)
            'attendances as total_telat' => function ($query) {
                $query->where('status', 'hadir')
                    ->where('points_gained', '<', 10)
                    ->whereBetween('date', [$this->startDate, $this->endDate]);
            },
            // On-time = hadir with full 10 points
            'attendances as total_tepat_waktu' => function ($query) {
                $query->where('status', 'hadir')
                    ->where('points_gained', '>=', 10)
                    ->whereBetween('date', [$this->startDate, $this->endDate]);
            },
            // Izin
            'attendances as total_izin' => function ($query) {
                $query->whereIn('status', ['izin', 'sakit'])
                    ->whereBetween('date', [$this->startDate, $this->endDate]);
            },
            // Alpha
            'attendances as total_alpha' => function ($query) {
                $query->where('status', 'alpha')
                    ->whereBetween('date', [$this->startDate, $this->endDate]);
            },
        ])
            ->withSum(['attendances as total_poin_kehadiran' => function ($query) {
                $query->whereBetween('date', [$this->startDate, $this->endDate]);
            }], 'points_gained')
            ->orderByDesc('total_hadir')
            ->get();
    }

    public function getPointsReport()
    {
        return Santri::withSum(['attendances as poin_kehadiran' => function ($query) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }], 'points_gained')
            ->withSum(['achievements as poin_achievement' => function ($query) {
                // Achievement has no 'date' column, use 'created_at'
                $query->whereBetween('created_at', [$this->startDate, Carbon::parse($this->endDate)->endOfDay()]);
            }], 'points')
            ->get()
            ->map(function ($santri) {
                $santri->total_poin = ($santri->poin_kehadiran ?? 0) + ($santri->poin_achievement ?? 0);
                return $santri;
            })
            ->sortByDesc('total_poin')
            ->values();
    }

    public function getFinanceReport()
    {
        $transactions = Finance::whereBetween('date', [$this->startDate, $this->endDate])
            ->orderByDesc('date')
            ->get();

        $totalIncome = Finance::whereBetween('date', [$this->startDate, $this->endDate])
            ->income()->sum('amount');
        $totalExpense = Finance::whereBetween('date', [$this->startDate, $this->endDate])
            ->expense()->sum('amount');

        return [
            'transactions' => $transactions,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense,
        ];
    }

    public function render()
    {
        $data = [];

        if ($this->activeTab === 'attendance') {
            $data['report'] = $this->getAttendanceReport();
        } elseif ($this->activeTab === 'points') {
            $data['report'] = $this->getPointsReport();
        } elseif ($this->activeTab === 'finance') {
            $data['report'] = $this->getFinanceReport();
        }

        return view('livewire.admin.report-index', $data);
    }
}
