<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Carbon\Carbon;

#[Layout('components.layouts.public')]
#[Title('Jadwal & Materi - SITARA')]
class JadwalPublic extends Component
{
    #[Url]
    public string $selectedDate = '';

    public function mount()
    {
        if (empty($this->selectedDate)) {
            $this->selectedDate = Carbon::today()->format('Y-m-d');
        }
    }

    public function previousDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->subDay()->format('Y-m-d');
    }

    public function nextDay()
    {
        $this->selectedDate = Carbon::parse($this->selectedDate)->addDay()->format('Y-m-d');
    }

    public function render()
    {
        $selectedDateParsed = Carbon::parse($this->selectedDate);

        $materials = Material::whereDate('date', $this->selectedDate)
            ->orderBy('created_at')
            ->get();

        // Get dates that have materials for calendar dots
        $materialsThisMonth = Material::whereMonth('date', $selectedDateParsed->month)
            ->whereYear('date', $selectedDateParsed->year)
            ->pluck('date')
            ->map(fn($d) => $d->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        return view('livewire.jadwal-public', [
            'materials' => $materials,
            'selectedDateParsed' => $selectedDateParsed,
            'materialsThisMonth' => $materialsThisMonth,
        ]);
    }
}
