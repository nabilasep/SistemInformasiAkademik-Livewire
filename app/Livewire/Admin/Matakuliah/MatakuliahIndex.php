<?php

namespace App\Livewire\Admin\Matakuliah;

use App\Models\Matakuliah;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
class MatakuliahIndex extends Component
{
    use WithPagination;

    public $kode, $nama_matakuliah, $sks, $prodi_id, $matakuliah_id; 
    public $isModalOpen = false;
    public $semua_prodi_dropdown;

    public function mount()
    {
        $this->semua_prodi_dropdown = Prodi::orderBy('nama_prodi')->get();
    }

    private function resetInputFields()
    {
        $this->kode = '';
        $this->nama_matakuliah = '';
        $this->sks = '';
        $this->matakuliah_id = null;
        $this->prodi_id = '';
        $this->matakuliah_id = null;
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

    public function saveMatakuliah()
    {
        $this->validate([
            'kode' => ['required', 'string', 'min:3', Rule::unique('matakuliahs', 'kode')->ignore($this->matakuliah_id)],
            'nama_matakuliah' => 'required|string|min:5',
            'sks' => 'required|integer|min:1|max:6',
            'prodi_id' => 'required|exists:prodis,id',
        ]);

        Matakuliah::updateOrCreate(
            ['id' => $this->matakuliah_id],
            [
                'kode' => $this->kode,
                'nama_matakuliah' => $this->nama_matakuliah,
                'sks' => $this->sks,
                'prodi_id' => $this->prodi_id,
            ]
        );

        session()->flash('message', $this->matakuliah_id ? 'Matakuliah berhasil diperbarui.' : 'Matakuliah berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $this->matakuliah_id = $id;
        $this->kode = $matakuliah->kode;
        $this->nama_matakuliah = $matakuliah->nama_matakuliah;
        $this->sks = $matakuliah->sks;
        $this->isModalOpen = true;
        $this->prodi_id = $matakuliah->prodi_id; 
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        Matakuliah::findOrFail($id)->delete();
        session()->flash('message', 'Matakuliah berhasil dihapus.');
    }


    public function render()
    {
        $semua_matakuliah = Matakuliah::with('prodi')->latest()->paginate(5);
        return view('livewire.admin.matakuliah.matakuliah-index', [
            'semua_matakuliah' => $semua_matakuliah
        ]);
    }
}