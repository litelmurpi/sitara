<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Models\Achievement;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.admin')]
#[Title('Tambah Poin')]
class AchievementCreate extends Component
{
    #[Url(as: 'santri_id')]
    public ?int $initial_santri_id = null;

    public \Illuminate\Support\Collection $selectedSantris;
    public string $search = '';

    #[Validate('required')]
    public string $type = 'hafalan'; // hafalan, adab, partisipasi

    #[Validate('required|string|max:255')]
    public string $description = '';

    #[Validate('required|integer')]
    public int $points = 0;

    public array $pointPresets = [
        'hafalan' => [
            ['label' => 'Hafalan Surat Pendek', 'points' => 10],
            ['label' => 'Hafalan Surat Panjang', 'points' => 20],
            ['label' => 'Hafalan Doa Harian', 'points' => 5],
            ['label' => 'Hafalan Juz Amma', 'points' => 30],
        ],
        'adab' => [
            ['label' => 'Sopan & Tertib', 'points' => 5],
            ['label' => 'Membantu Teman', 'points' => 10],
            ['label' => 'Menjaga Kebersihan', 'points' => 5],
            ['label' => 'Gaduh saat Materi', 'points' => -5],
            ['label' => 'Mengganggu Teman', 'points' => -10],
        ],
        'partisipasi' => [
            ['label' => 'Aktif Bertanya', 'points' => 5],
            ['label' => 'Menjawab Pertanyaan', 'points' => 5],
            ['label' => 'Memimpin Doa', 'points' => 10],
            ['label' => 'Membaca dengan Baik', 'points' => 5],
        ],
    ];

    public function mount()
    {
        $this->selectedSantris = collect();
        if ($this->initial_santri_id) {
            $santri = Santri::find($this->initial_santri_id);
            if ($santri) {
                $this->selectedSantris->push($santri);
            }
        }
    }

    public function selectSantri(int $id)
    {
        // Don't add if already selected
        if (!$this->selectedSantris->contains('id', $id)) {
            $santri = Santri::find($id);
            if ($santri) {
                $this->selectedSantris->push($santri);
            }
        }
        $this->search = '';
    }

    public function removeSantri(int $id)
    {
        $this->selectedSantris = $this->selectedSantris->reject(function (Santri $santri) use ($id) {
            return $santri->id === $id;
        });
    }

    public function selectPreset(string $label, int $points)
    {
        $this->description = $label;
        $this->points = $points;
    }

    public function save()
    {
        $this->validate();

        if ($this->selectedSantris->isEmpty()) {
            session()->flash('error', 'Pilih minimal satu santri terlebih dahulu.');
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () {
            foreach ($this->selectedSantris as $santri) {
                Achievement::create([
                    'santri_id' => $santri->id,
                    'type' => $this->type,
                    'description' => $this->description,
                    'points' => $this->points,
                    'created_by' => auth()->id() ?? 1, // Fallback if no auth
                ]);

                // Trigger point recalculation
                $santri->recalculateTotalPoints();
            }
        });

        $count = $this->selectedSantris->count();
        $message = "Poin berhasil ditambahkan untuk {$count} santri.";
        session()->flash('message', $message);

        // Redirect back to single santri profile if only 1 was selected and initialized from URL
        if ($count === 1 && $this->initial_santri_id) {
            return $this->redirect(route('admin.santri.show', $this->selectedSantris->first()), navigate: true);
        }

        return $this->redirect(route('admin.santri.index'), navigate: true);
    }

    public function render()
    {
        $santris = collect();

        if ($this->search && strlen($this->search) >= 2) {
            $selectedIds = $this->selectedSantris->pluck('id')->toArray();
            $santris = Santri::where('name', 'like', '%' . $this->search . '%')
                ->whereNotIn('id', $selectedIds)
                ->take(5)
                ->get();
        }

        return view('livewire.admin.achievement-create', [
            'santris' => $santris,
            'presets' => $this->pointPresets[$this->type] ?? [],
        ]);
    }
}
