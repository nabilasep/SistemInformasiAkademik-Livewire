<?php

namespace App\Livewire\Mahasiswa;

use App\Models\Krs;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KrsSaya extends Component
{
    public Mahasiswa $mahasiswa;
    public $semua_matakuliah;

    public $selectedMatakuliah = [];
    public $tipe_semester;
    public $tahun_ajaran;
    public $totalSks = 0;

    public $opsi_tipe_semester = ['Ganjil', 'Genap'];
    public $opsi_tahun_ajaran = [];

    public function mount()
    {
        $user = Auth::user();
        
        if ($user && $user->mahasiswa) {
            $this->mahasiswa = $user->mahasiswa;
            
            $this->semua_matakuliah = Matakuliah::where('prodi_id', $this->mahasiswa->prodi_id)
                                                ->orderBy('nama_matakuliah')
                                                ->get();

            $tahun_sekarang = date('Y');
            for ($i = $tahun_sekarang - 2; $i <= $tahun_sekarang + 2; $i++) {
                $this->opsi_tahun_ajaran[] = $i . '/' . ($i + 1);
            }

            $krsTerakhir = Krs::where('mahasiswa_id', $this->mahasiswa->id)->orderBy('created_at', 'desc')->first();
            if ($krsTerakhir) {
                $semesterParts = explode(' ', $krsTerakhir->semester);
                $this->tipe_semester = $semesterParts[0] ?? null;
                $this->tahun_ajaran = $semesterParts[1] ?? null;

                $krsSemesterIni = Krs::where('mahasiswa_id', $this->mahasiswa->id)
                                     ->where('semester', $krsTerakhir->semester)
                                     ->pluck('matakuliah_id')->toArray();
                
                $this->selectedMatakuliah = $krsSemesterIni;
                $this->updatedSelectedMatakuliah();
            }

        } else {
            return redirect('/')->with('error', 'Profil mahasiswa tidak ditemukan.');
        }
    }

    public function updatedSelectedMatakuliah()
    {
        if (empty($this->selectedMatakuliah)) {
            $this->totalSks = 0;
            return;
        }

        $matakuliahTerpilih = Matakuliah::whereIn('id', $this->selectedMatakuliah)->get();
        $currentSks = $matakuliahTerpilih->sum('sks');

        if ($currentSks > 24) {
            session()->flash('error', 'Batas maksimum 24 SKS telah terlampaui.');
            array_pop($this->selectedMatakuliah);
            $currentSks = Matakuliah::whereIn('id', $this->selectedMatakuliah)->sum('sks');
        }

        $this->totalSks = $currentSks;
    }

    public function saveKrs()
    {
        $this->validate([
            'tipe_semester' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required',
            'selectedMatakuliah' => 'nullable|array',
            'selectedMatakuliah.*' => 'exists:matakuliahs,id'
        ]);
        
        $semester_string = $this->tipe_semester . ' ' . $this->tahun_ajaran;
        Krs::where('mahasiswa_id', $this->mahasiswa->id)
           ->where('semester', $semester_string)
           ->delete();

        foreach ($this->selectedMatakuliah as $matakuliah_id) {
            Krs::create([
                'mahasiswa_id' => $this->mahasiswa->id,
                'matakuliah_id' => $matakuliah_id,
                'semester' => $semester_string,
            ]);
        }

        session()->flash('message', 'KRS untuk semester ' . $semester_string . ' berhasil diperbarui.');
        return $this->redirect(route('mahasiswa.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.mahasiswa.krs-saya');
    }
}
