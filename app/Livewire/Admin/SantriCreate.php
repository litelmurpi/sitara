<?php

namespace App\Livewire\Admin;

use App\Models\Santri;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

#[Layout('components.layouts.admin')]
#[Title('Tambah Santri')]
class SantriCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $parent_name = '';

    #[Validate('required|string|max:20')]
    public string $parent_phone = '';

    #[Validate('nullable|string')]
    public string $address = '';

    #[Validate('required|date')]
    public string $birth_date = '';

    #[Validate('nullable|image|max:2048')]
    public $avatar;

    public function save()
    {
        $validated = $this->validate();

        $santri = Santri::create([
            'name' => $validated['name'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'address' => $validated['address'] ?? null,
            'birth_date' => $validated['birth_date'],
        ]);

        if ($this->avatar) {
            $path = FileUploadService::upload($this->avatar, 'avatars');
            $santri->update(['avatar' => $path]);
        }

        session()->flash('message', 'Santri berhasil ditambahkan.');

        return $this->redirect(route('admin.santri.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.santri-form', [
            'title' => 'Tambah Santri',
            'submitLabel' => 'Simpan',
        ]);
    }
}
