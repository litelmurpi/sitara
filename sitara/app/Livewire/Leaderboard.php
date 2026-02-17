<?php

namespace App\Livewire;

use App\Models\Santri;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.public')]
#[Title('Leaderboard - SITARA')]
class Leaderboard extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Get top 3 for podium
        $topThree = Santri::orderByDesc('total_points')
            ->take(3)
            ->get();

        // Get leaderboard starting from rank 4
        $query = Santri::orderByDesc('total_points');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $leaderboard = $query->paginate(10);

        // Add rank to each item
        $offset = ($leaderboard->currentPage() - 1) * $leaderboard->perPage();
        $leaderboard->getCollection()->transform(function ($santri, $index) use ($offset) {
            $santri->rank = $offset + $index + 1;
            return $santri;
        });

        // Get total santri count
        $totalSantri = Santri::count();

        return view('livewire.leaderboard', [
            'topThree' => $topThree,
            'leaderboard' => $leaderboard,
            'totalSantri' => $totalSantri,
        ]);
    }
}
