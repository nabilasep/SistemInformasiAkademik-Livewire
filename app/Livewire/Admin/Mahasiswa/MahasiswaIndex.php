<?php

namespace App\Livewire\Admin\Mahasiswa;

use App\Models\Fakultas;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class MahasiswaIndex extends Component
{
    use WithPagination;

    public $nim, $nama, $prodi_id, $mahasiswa_id, $email, $password, $tahun_masuk;
    public $isModalOpen = false;
    public $semua_prodi_dropdown;
    public $filterFakultas = '';
    public $filterTahun = '';
    public $semua_fakultas_filter;
    public $opsi_tahun_filter = [];

    public function mount()
    {
    $this->semua_prodi_dropdown = Prodi::orderBy('nama_prodi')->get();
    $this->semua_fakultas_filter = Fakultas::all();
    $this->opsi_tahun_filter = Mahasiswa::select('tahun_masuk')
                                    ->whereNotNull('tahun_masuk')
                                    ->distinct()
                                    ->orderBy('tahun_masuk', 'desc')
                                    ->pluck('tahun_masuk');
    }

    private function resetInputFields()
    {
        $this->nim = '';
        $this->nama = '';
        $this->prodi_id = '';
        $this->email = '';
        $this->password = '';
        $this->tahun_masuk = '';
        $this->mahasiswa_id = null;
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function saveMahasiswa()
    {
        $userId = null;
        if ($this->mahasiswa_id) {
            $userId = Mahasiswa::find($this->mahasiswa_id)->user_id;
        }

        $this->validate([
            'nim' => ['required', 'string', 'min:8', Rule::unique('mahasiswas', 'nim')->ignore($this->mahasiswa_id)],
            'nama' => 'required|string|min:3',
            'tahun_masuk' => 'required|integer|digits:4|min:2000',
            'prodi_id' => 'required|exists:prodis,id',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => [$this->mahasiswa_id ? 'nullable' : 'required', 'string', 'min:8'],
        ]);

        DB::transaction(function () {
            if ($this->mahasiswa_id) {
                $mahasiswa = Mahasiswa::find($this->mahasiswa_id);
                $mahasiswa->update([
                    'nim' => $this->nim,
                    'nama' => $this->nama,
                    'tahun_masuk' => $this->tahun_masuk,
                    'prodi_id' => $this->prodi_id,
                ]);
                
                if ($mahasiswa->user) {
                    $mahasiswa->user->update(['email' => $this->email, 'name' => $this->nama]);
                }
            } else {
                $user = User::create([
                    'name' => $this->nama,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'role' => 'mahasiswa',
                ]);

                $user->mahasiswa()->create([
                    'nim' => $this->nim,
                    'nama' => $this->nama,
                    'tahun_masuk' => $this->tahun_masuk,
                    'prodi_id' => $this->prodi_id,
                ]);
            }
        });

        session()->flash('message', $this->mahasiswa_id ? 'Data Mahasiswa berhasil diperbarui.' : 'Data Mahasiswa & Akun Login berhasil dibuat.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
        $this->mahasiswa_id = $id;
        $this->nim = $mahasiswa->nim;
        $this->nama = $mahasiswa->nama;
        $this->tahun_masuk = $mahasiswa->tahun_masuk;
        $this->prodi_id = $mahasiswa->prodi_id;
        
        if ($mahasiswa->user) {
            $this->email = $mahasiswa->user->email;
        }
        
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        try {
            Mahasiswa::findOrFail($id)->delete();
            session()->flash('message', 'Data Mahasiswa berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus mahasiswa, kemungkinan masih terhubung dengan data KRS.');
        }
    }

    public function render()
    {
        $query = Mahasiswa::with(['prodi.fakultas'])->withSum('matakuliahs', 'sks');

        $query->when($this->filterFakultas, function ($q) {
            $q->whereHas('prodi', function ($subq) {
                $subq->where('fakultas_id', $this->filterFakultas);
            });
        });

        $query->when($this->filterTahun, function ($q) {
            $q->where('tahun_masuk', $this->filterTahun);
        });

        $semua_mahasiswa = $query->latest()->paginate(10);
        
        return view('livewire.admin.mahasiswa.mahasiswa-index', [
            'semua_mahasiswa' => $semua_mahasiswa
        ]);
    }
}
