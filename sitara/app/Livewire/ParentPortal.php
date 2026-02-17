<?php

namespace App\Livewire;

use App\Models\Santri;
use App\Models\Attendance;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Layout('components.layouts.public')]
#[Title('Portal Orang Tua - SITARA')]
class ParentPortal extends Component
{
    public Santri $santri;
    public $attendances;
    public $achievements;
    public $rank;
    public $totalSantri;

    public function mount(string $token)
    {
        $this->santri = Santri::where('parent_access_token', $token)->firstOrFail();

        // Get last 14 days attendance
        $this->attendances = Attendance::where('santri_id', $this->santri->id)
            ->where('date', '>=', Carbon::now()->subDays(14))
            ->orderByDesc('date')
            ->get();

        // Get achievements
        $this->achievements = $this->santri->achievements()
            ->latest()
            ->take(10)
            ->get();

        // Calculate rank
        $this->totalSantri = Santri::count();
        $this->rank = Santri::where('total_points', '>', $this->santri->total_points)->count() + 1;
    }

    public function render()
    {
        return view('livewire.parent-portal');
    }
}
