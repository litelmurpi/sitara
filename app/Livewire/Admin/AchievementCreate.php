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
    #[Url]
    public ?int $santri_id = null;

    public ?Santri $selectedSantri = null;
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
        if ($this->santri_id) {
            $this->selectedSantri = Santri::find($this->santri_id);
        }
    }

    public function selectSantri(int $id)
    {
        $this->selectedSantri = Santri::find($id);
        $this->search = '';
    }

    public function clearSantri()
    {
        $this->selectedSantri = null;
        $this->santri_id = null;
    }

    public function selectPreset(string $label, int $points)
    {
        $this->description = $label;
        $this->points = $points;
    }

    public function save()
    {
        $this->validate();

        if (!$this->selectedSantri) {
            session()->flash('error', 'Pilih santri terlebih dahulu.');
            return;
        }

        Achievement::create([
            'santri_id' => $this->selectedSantri->id,
            'type' => $this->type,
            'description' => $this->description,
            'points' => $this->points,
            'created_by' => auth()->id(),
        ]);

        // Recalculate total points (triggered automatically by model observer)

        session()->flash('message', 'Poin berhasil ditambahkan untuk ' . $this->selectedSantri->name);

        return $this->redirect(route('admin.santri.show', $this->selectedSantri), navigate: true);
    }

    public function render()
    {
        $santris = collect();

        if ($this->search && strlen($this->search) >= 2) {
            $santris = Santri::where('name', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get();
        }

        return view('livewire.admin.achievement-create', [
            'santris' => $santris,
            'presets' => $this->pointPresets[$this->type] ?? [],
        ]);
    }
}
