<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.layouts.admin')]
#[Title('Daftar Santri')]
class SantriIndex extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $filter = 'aktif'; // aktif, semua

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function deleteSantri(int $id)
    {
        $santri = Santri::findOrFail($id);
        $santri->delete();

        session()->flash('message', 'Santri berhasil dihapus.');
    }

    public function render()
    {
        $query = Santri::query();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('parent_name', 'like', '%' . $this->search . '%');
            });
        }

        // Filter
        if ($this->filter === 'aktif') {
            $query->whereNull('deleted_at');
        }

        $santris = $query->orderBy('name')->paginate(10);

        return view('livewire.admin.santri-index', [
            'santris' => $santris,
        ]);
    }
}
