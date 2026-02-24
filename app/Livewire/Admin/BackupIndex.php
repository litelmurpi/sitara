<?php

namespace App\Livewire\Admin;

use App\Models\Achievement;
use App\Models\Attendance;
use App\Models\Finance;
use App\Models\Gallery;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Santri;
use App\Models\Setting;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Backup & Restore')]
class BackupIndex extends Component
{
    public function getTableStats(): array
    {
        return [
            ['name' => 'Users', 'icon' => '👤', 'count' => User::count()],
            ['name' => 'Santri', 'icon' => '🧒', 'count' => Santri::withTrashed()->count()],
            ['name' => 'Kehadiran', 'icon' => '✅', 'count' => Attendance::count()],
            ['name' => 'Prestasi', 'icon' => '🏆', 'count' => Achievement::count()],
            ['name' => 'Keuangan', 'icon' => '💰', 'count' => Finance::count()],
            ['name' => 'Materi', 'icon' => '📚', 'count' => Material::count()],
            ['name' => 'Galeri', 'icon' => '🖼️', 'count' => Gallery::count()],
            ['name' => 'Pengaturan', 'icon' => '⚙️', 'count' => Setting::count()],
            ['name' => 'Kuis', 'icon' => '❓', 'count' => Quiz::count()],
            ['name' => 'Soal Kuis', 'icon' => '📝', 'count' => QuizQuestion::count()],
        ];
    }

    public function getTotalRecords(): int
    {
        return collect($this->getTableStats())->sum('count');
    }

    public function render()
    {
        return view('livewire.admin.backup-index', [
            'tableStats' => $this->getTableStats(),
            'totalRecords' => $this->getTotalRecords(),
        ]);
    }
}
