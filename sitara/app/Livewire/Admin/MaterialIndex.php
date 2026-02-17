<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Materi & Jadwal')]
class MaterialIndex extends Component
{
    use WithPagination;

    // Modal state
    public bool $showModal = false;
    public ?int $editingId = null;

    // Form fields
    public string $title = '';
    public string $content = '';
    public string $video_url = '';
    public string $date = '';

    // Search
    public string $search = '';

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->reset(['editingId', 'title', 'content', 'video_url']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $material = Material::find($id);
        if ($material) {
            $this->editingId = $id;
            $this->title = $material->title;
            $this->content = $material->content ?? '';
            $this->video_url = $material->video_url ?? '';
            $this->date = $material->date ? $material->date->format('Y-m-d') : Carbon::today()->format('Y-m-d');
            $this->showModal = true;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'date' => 'required|date',
        ]);

        $data = [
            'title' => $this->title,
            'content' => $this->content,
            'video_url' => $this->video_url,
            'date' => $this->date,
        ];

        if ($this->editingId) {
            Material::find($this->editingId)->update($data);
            session()->flash('message', 'Materi berhasil diperbarui.');
        } else {
            $data['created_by'] = Auth::id();
            Material::create($data);
            session()->flash('message', 'Materi berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete(int $id)
    {
        Material::find($id)?->delete();
        session()->flash('message', 'Materi berhasil dihapus.');
    }

    public function render()
    {
        $query = Material::with('createdBy')->latest('date');

        if ($this->search) {
            $query->where('title', 'like', "%{$this->search}%");
        }

        $materials = $query->paginate(10);

        return view('livewire.admin.material-index', [
            'materials' => $materials,
        ]);
    }
}
