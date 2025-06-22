<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\Fakultas\FakultasIndex;
use App\Livewire\Admin\Prodi\ProdiIndex;
use App\Livewire\Admin\Matakuliah\MatakuliahIndex;
use App\Livewire\Admin\Mahasiswa\MahasiswaIndex;
use App\Livewire\Admin\Krs\KrsForm;
use App\Livewire\Admin\Dashboard as AdminDashboard; 
use App\Livewire\Mahasiswa\Dashboard as MahasiswaDashboard;
use App\Livewire\Mahasiswa\KrsSaya;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('mahasiswa.dashboard');
        }
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/fakultas', FakultasIndex::class)->name('fakultas.index');
    Route::get('/prodi', ProdiIndex::class)->name('prodi.index');
    Route::get('/matakuliah', MatakuliahIndex::class)->name('matakuliah.index');
    Route::get('/mahasiswa', MahasiswaIndex::class)->name('mahasiswa.index');
    Route::get('/mahasiswa/{mahasiswa}/krs', KrsForm::class)->name('mahasiswa.krs');
});

Route::middleware(['auth'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', MahasiswaDashboard::class)->name('dashboard');
    Route::get('/krs', KrsSaya::class)->name('krs');
});


require __DIR__.'/auth.php';