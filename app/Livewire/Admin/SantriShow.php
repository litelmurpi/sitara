<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Achievement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.admin')]
#[Title('Detail Santri')]
class SantriShow extends Component
{
    use WithPagination;

    public Santri $santri;

    #[Url]
    public string $tab = 'semua'; // semua, hafalan, adab, kehadiran

    public function mount(Santri $santri)
    {
        $this->santri = $santri;
    }

    public function updatingTab()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = collect();

        // Get achievements based on tab filter
        if ($this->tab === 'semua' || $this->tab === 'hafalan' || $this->tab === 'adab' || $this->tab === 'partisipasi') {
            $achievementQuery = Achievement::where('santri_id', $this->santri->id);

            if ($this->tab !== 'semua' && $this->tab !== 'kehadiran') {
                $achievementQuery->where('type', $this->tab);
            }

            $achievements = $achievementQuery->latest()->get()->map(function ($item) {
                return [
                    'type' => $item->type,
                    'title' => $item->description ?? ucfirst($item->type),
                    'description' => null,
                    'date' => $item->created_at,
                    'points' => $item->points,
                    'is_positive' => $item->points >= 0,
                ];
            });

            $query = $query->concat($achievements);
        }

        // Get attendances if tab is semua or kehadiran
        if ($this->tab === 'semua' || $this->tab === 'kehadiran') {
            $attendances = $this->santri->attendances()->latest('date')->get()->map(function ($item) {
                return [
                    'type' => 'kehadiran',
                    'title' => 'Datang ' . ucfirst($item->status),
                    'description' => $item->notes,
                    'date' => $item->date,
                    'points' => $item->points_gained,
                    'is_positive' => true,
                ];
            });

            $query = $query->concat($attendances);
        }

        $activities = $query->sortByDesc('date')->values();

        // Stats
        $stats = [
            'total_hadir' => $this->santri->attendances()->where('status', 'hadir')->count(),
            'total_poin' => $this->santri->total_points,
            'rank' => Santri::where('total_points', '>', $this->santri->total_points)->count() + 1,
            'total_santri' => Santri::count(),
        ];

        return view('livewire.admin.santri-show', [
            'activities' => $activities,
            'stats' => $stats,
        ]);
    }
}
