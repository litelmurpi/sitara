<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use App\Services\FileUploadService;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Layout('components.layouts.admin')]
#[Title('Pengaturan TPA')]
class SettingsIndex extends Component
{
    use WithFileUploads;

    public string $tpa_name = '';
    public string $tpa_address = '';
    public string $tpa_phone = '';
    public string $primary_color = '#059669';
    public $logo;
    public ?string $current_logo = null;

    public function mount()
    {
        $this->tpa_name = Setting::get('tpa_name', 'TPA SITARA');
        $this->tpa_address = Setting::get('tpa_address', '');
        $this->tpa_phone = Setting::get('tpa_phone', '');
        $this->primary_color = Setting::get('primary_color', '#059669');
        $this->current_logo = Setting::get('logo_path', '');
    }

    public function save()
    {
        $this->validate([
            'tpa_name' => 'required|string|max:255',
            'tpa_address' => 'nullable|string|max:500',
            'tpa_phone' => 'nullable|string|max:20',
            'primary_color' => 'required|string|max:7',
            'logo' => 'nullable|image|max:2048',
        ]);

        Setting::set('tpa_name', $this->tpa_name);
        Setting::set('tpa_address', $this->tpa_address);
        Setting::set('tpa_phone', $this->tpa_phone);
        Setting::set('primary_color', $this->primary_color);

        if ($this->logo) {
            // Delete old logo
            if ($this->current_logo) {
                FileUploadService::delete($this->current_logo);
            }

            $path = FileUploadService::upload($this->logo, 'settings');
            Setting::set('logo_path', $path);
            $this->current_logo = $path;
            $this->logo = null;
        }

        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }

    public function removeLogo()
    {
        if ($this->current_logo) {
            FileUploadService::delete($this->current_logo);
            Setting::set('logo_path', '');
            $this->current_logo = null;
            session()->flash('message', 'Logo berhasil dihapus.');
        }
    }

    public function render()
    {
        return view('livewire.admin.settings-index');
    }
}
