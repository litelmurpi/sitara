<?php

namespace App\Livewire;

use App\Models\Gallery as GalleryModel;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.public')]
#[Title('Galeri - SITARA')]
class Gallery extends Component
{
    use WithPagination;

    public $filter = 'all';

    public function setFilter($category)
    {
        $this->filter = $category;
        $this->resetPage();
    }

    public function render()
    {
        $query = GalleryModel::latest();

        if ($this->filter !== 'all') {
            $query->where('category', $this->filter);
        }

        return view('livewire.gallery', [
            'galleries' => $query->paginate(12)
        ]);
    }
}
