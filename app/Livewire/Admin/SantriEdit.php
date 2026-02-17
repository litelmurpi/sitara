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
#[Title('Edit Santri')]
class SantriEdit extends Component
{
    use WithFileUploads;

    public Santri $santri;

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

    public function mount(Santri $santri)
    {
        $this->santri = $santri;
        $this->name = $santri->name;
        $this->parent_name = $santri->parent_name;
        $this->parent_phone = $santri->parent_phone;
        $this->address = $santri->address ?? '';
        $this->birth_date = $santri->birth_date->format('Y-m-d');
    }

    public function save()
    {
        $validated = $this->validate();

        $this->santri->update([
            'name' => $validated['name'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'address' => $validated['address'] ?? null,
            'birth_date' => $validated['birth_date'],
        ]);

        if ($this->avatar) {
            // Delete old avatar if exists
            FileUploadService::delete($this->santri->avatar);
            $path = FileUploadService::upload($this->avatar, 'avatars');
            $this->santri->update(['avatar' => $path]);
        }

        session()->flash('message', 'Data santri berhasil diperbarui.');

        return $this->redirect(route('admin.santri.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.santri-form', [
            'title' => 'Edit Santri',
            'submitLabel' => 'Perbarui',
        ]);
    }
}
