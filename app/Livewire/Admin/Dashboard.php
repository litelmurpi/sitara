<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Finance;
use App\Models\Attendance;
use App\Models\Achievement;
use App\Services\IslamicQuoteService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $totalSantri = Santri::count();
        $hadirHariIni = Attendance::where('date', $today)->where('status', 'hadir')->count();
        $totalPoin = Santri::sum('total_points');
        $saldoKas = Finance::getCurrentBalance();

        // Recent activities
        $recentActivities = collect();

        // Get recent attendances
        $recentAttendances = Attendance::with('santri')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'attendance',
                    'name' => $item->santri->name,
                    'description' => 'Absensi ' . ucfirst($item->status),
                    'time' => $item->created_at,
                    'status' => $item->status === 'hadir' ? 'Hadir' : ucfirst($item->status),
                    'status_color' => $item->status === 'hadir' ? 'green' : 'yellow',
                ];
            });

        // Get recent achievements
        $recentAchievements = Achievement::with('santri')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'achievement',
                    'name' => $item->santri->name,
                    'description' => ucfirst($item->type),
                    'time' => $item->created_at,
                    'status' => '+' . $item->points . ' Poin',
                    'status_color' => 'teal',
                ];
            });

        // Get recent finances
        $recentFinances = Finance::latest()
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'finance',
                    'name' => ucfirst($item->category),
                    'description' => $item->description ?? ucfirst($item->type),
                    'time' => $item->created_at,
                    'status' => ($item->type === 'income' ? '+' : '-') . 'Rp ' . number_format((float) $item->amount, 0, ',', '.'),
                    'status_color' => $item->type === 'income' ? 'green' : 'red',
                ];
            });

        $recentActivities = $recentAttendances
            ->concat($recentAchievements)
            ->concat($recentFinances)
            ->sortByDesc('time')
            ->take(5);

        $dailyQuote = IslamicQuoteService::getTodayQuote();

        return view('livewire.admin.dashboard', [
            'totalSantri' => $totalSantri,
            'hadirHariIni' => $hadirHariIni,
            'totalPoin' => $totalPoin,
            'saldoKas' => $saldoKas,
            'recentActivities' => $recentActivities,
            'dailyQuote' => $dailyQuote,
        ]);
    }
}
