<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Login;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\SantriIndex;
use App\Livewire\Admin\SantriCreate;
use App\Livewire\Admin\SantriEdit;
use App\Livewire\Admin\SantriShow;
use App\Livewire\Admin\Scanner;
use App\Livewire\Admin\AchievementCreate;
use App\Livewire\Leaderboard;
use App\Livewire\FinancePublic;
use App\Livewire\Gallery;
use App\Livewire\JadwalPublic;
use App\Livewire\QuizPlay;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');

Route::get('/keuangan', FinancePublic::class)->name('keuangan');

Route::get('/galeri', Gallery::class)->name('galeri');

Route::get('/jadwal', JadwalPublic::class)->name('jadwal');

Route::get('/quiz/{quiz}/play', QuizPlay::class)->name('quiz.play');

Route::get('/santri/{token}', \App\Livewire\ParentPortal::class)->name('parent.portal');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', Dashboard::class)->name('dashboard');

        // Santri Management
        Route::get('/santri', SantriIndex::class)->name('santri.index');
        Route::get('/santri/create', SantriCreate::class)->name('santri.create');
        Route::get('/santri/{santri}', SantriShow::class)->name('santri.show');
        Route::get('/santri/{santri}/edit', SantriEdit::class)->name('santri.edit');
        Route::get('/santri/{santri}/card', function (\App\Models\Santri $santri) {
            return view('admin.santri-card', compact('santri'));
        })->name('santri.card');

        // Scanner & Points
        Route::get('/scanner', Scanner::class)->name('scanner');
        Route::get('/achievement/create', AchievementCreate::class)->name('achievement.create');

        // Keuangan
        Route::get('/keuangan', \App\Livewire\Admin\FinanceIndex::class)->name('keuangan.index');

        // Materi
        Route::get('/materi', \App\Livewire\Admin\MaterialIndex::class)->name('materi.index');

        // Kuis
        Route::get('/quiz', \App\Livewire\Admin\QuizIndex::class)->name('quiz.index');
        Route::get('/quiz/{quiz}/editor', \App\Livewire\Admin\QuizEditor::class)->name('quiz.editor');

        // Gallery
        Route::get('/galeri', \App\Livewire\Admin\GalleryIndex::class)->name('gallery.index');

        // Profile & Settings
        Route::get('/profile', \App\Livewire\Admin\ProfileEdit::class)->name('profile.edit');
        Route::get('/settings', \App\Livewire\Admin\SettingsIndex::class)->name('settings.index');

        // Reports
        Route::get('/reports', \App\Livewire\Admin\ReportIndex::class)->name('reports.index');
        Route::get('/reports/export', [\App\Http\Controllers\ReportExportController::class, 'export'])->name('reports.export');

        // PDF Exports
        Route::get('/reports/pdf/finance', [\App\Http\Controllers\ReportPdfController::class, 'exportFinance'])->name('reports.pdf.finance');
        Route::get('/reports/pdf/attendance', [\App\Http\Controllers\ReportPdfController::class, 'exportAttendance'])->name('reports.pdf.attendance');
        Route::get('/reports/pdf/leaderboard', [\App\Http\Controllers\ReportPdfController::class, 'exportLeaderboard'])->name('reports.pdf.leaderboard');
    });
