<?php

namespace App\Livewire\Mahasiswa;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Auth;
use App\Models\Krs;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $mahasiswa;
    public $krs_terakhir = [];
    public $total_sks_terakhir = 0;

    public function mount()
    {
        $this->mahasiswa = Auth::user()->mahasiswa;
        $this->loadKrsData();
    }

    #[On('krs-saved')]
    public function loadKrsData()
    {
        $semester_terakhir = Krs::where('mahasiswa_id', $this->mahasiswa->id)
                                ->orderBy('semester', 'desc')
                                ->first();

        if ($semester_terakhir) {
            $this->krs_terakhir = Krs::with('matakuliah')
                                    ->where('mahasiswa_id', $this->mahasiswa->id)
                                    ->where('semester', $semester_terakhir->semester)
                                    ->get();
            $this->total_sks_terakhir = $this->krs_terakhir->sum('matakuliah.sks');
        } else {
            $this->krs_terakhir = [];
            $this->total_sks_terakhir = 0;
        }
    }

    public function render()
    {
        return view('livewire.mahasiswa.dashboard');
    }
}
