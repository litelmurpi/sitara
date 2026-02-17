<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout('components.layouts.admin')]
#[Title('Galeri')]
class GalleryIndex extends Component
{
    use WithFileUploads, WithPagination;

    // Modal state
    public bool $showModal = false;
    public ?int $editingId = null;

    // Form fields
    public $photo;
    public string $caption = '';
    public string $category = 'kegiatan';
    public string $date = '';

    public array $categories = [
        'kegiatan' => 'Kegiatan',
        'lomba' => 'Lomba',
        'takjil' => 'Berbagi Takjil',
        'lainnya' => 'Lainnya',
    ];

    public function mount()
    {
        $this->date = Carbon::today()->format('Y-m-d');
    }

    public function openModal()
    {
        $this->reset(['editingId', 'photo', 'caption', 'category']);
        $this->date = Carbon::today()->format('Y-m-d');
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'photo' => $this->editingId ? 'nullable|image|max:5120' : 'required|image|max:5120',
            'caption' => 'required|string|max:255',
            'category' => 'required|in:kegiatan,lomba,takjil,lainnya',
            'date' => 'required|date',
        ]);

        $imagePath = null;
        if ($this->photo) {
            $imagePath = FileUploadService::upload($this->photo, 'galleries');
        }

        if ($this->editingId) {
            $gallery = Gallery::find($this->editingId);

            // Delete old image if new one uploaded
            if ($imagePath && $gallery->image_path) {
                FileUploadService::delete($gallery->image_path);
            }

            $gallery->update([
                'caption' => $this->caption,
                'category' => $this->category,
                'date' => $this->date,
                'image_path' => $imagePath ?? $gallery->image_path,
            ]);

            session()->flash('message', 'Foto berhasil diperbarui.');
        } else {
            Gallery::create([
                'image_path' => $imagePath,
                'caption' => $this->caption,
                'category' => $this->category,
                'date' => $this->date,
                'created_by' => Auth::id(),
            ]);

            session()->flash('message', 'Foto berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete(int $id)
    {
        $gallery = Gallery::find($id);
        if ($gallery) {
            if ($gallery->image_path) {
                FileUploadService::delete($gallery->image_path);
            }
            $gallery->delete();
            session()->flash('message', 'Foto berhasil dihapus.');
        }
    }

    // Filter state
    public string $search = '';
    public string $filterCategory = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $galleries = Gallery::with('createdBy')
            ->when($this->search, function ($query) {
                $query->where('caption', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->latest('date')
            ->paginate(12);

        return view('livewire.admin.gallery-index', [
            'galleries' => $galleries,
        ]);
    }
}
