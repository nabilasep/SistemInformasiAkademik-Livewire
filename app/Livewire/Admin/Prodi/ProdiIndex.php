<?php

namespace App\Livewire\Admin\Prodi;

use App\Models\Fakultas;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
class ProdiIndex extends Component
{
    use WithPagination;

    public $nama_prodi;
    public $fakultas_id; 
    public $prodi_id; 

    public $isModalOpen = false;

    public $semua_fakultas_dropdown;

    public function mount()
    {
        $this->semua_fakultas_dropdown = Fakultas::all();
    }

    private function resetInputFields()
    {
        $this->nama_prodi = '';
        $this->fakultas_id = '';
        $this->prodi_id = null;
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

    public function saveProdi()
    {
        $this->validate([
            'nama_prodi' => [
                'required', 'string', 'min:3',
                Rule::unique('prodis', 'nama_prodi')->ignore($this->prodi_id)
            ],
            'fakultas_id' => 'required|exists:fakultas,id',
        ]);

        Prodi::updateOrCreate(
            ['id' => $this->prodi_id],
            [
                'nama_prodi' => $this->nama_prodi,
                'fakultas_id' => $this->fakultas_id,
            ]
        );

        session()->flash('message', $this->prodi_id ? 'Prodi berhasil diperbarui.' : 'Prodi berhasil ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $this->prodi_id = $id;
        $this->nama_prodi = $prodi->nama_prodi;
        $this->fakultas_id = $prodi->fakultas_id;
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        try {
            Prodi::findOrFail($id)->delete();
            session()->flash('message', 'Prodi berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus prodi, kemungkinan masih terhubung dengan data lain.');
        }
    }

    public function render()
    {
        $semua_prodi = Prodi::with('fakultas')->latest()->paginate(5);
        return view('livewire.admin.prodi.prodi-index', [
            'semua_prodi' => $semua_prodi
        ]);
    }
}