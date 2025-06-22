<?php

namespace App\Livewire\Admin;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $totalMahasiswa;
    public $totalFakultas;
    public $totalProdi;
    public $totalMatakuliah;

    public function mount()
    {
        $this->totalMahasiswa = Mahasiswa::count();
        $this->totalFakultas = Fakultas::count();
        $this->totalProdi = Prodi::count();
        $this->totalMatakuliah = Matakuliah::count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}