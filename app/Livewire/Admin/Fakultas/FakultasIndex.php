<?php

namespace App\Livewire\Admin\Fakultas;

use App\Models\Fakultas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule; 

#[Layout('layouts.app')]
class FakultasIndex extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $nama_fakultas;
    public $fakultas_id; 

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

    private function resetInputFields()
    {
        $this->nama_fakultas = '';
        $this->fakultas_id = null;
    }

    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        $this->fakultas_id = $id;
        $this->nama_fakultas = $fakultas->nama_fakultas;
        $this->isModalOpen = true;
    }

    public function saveFakultas()
    {
        $this->validate([
            'nama_fakultas' => [
                'required',
                'string',
                'min:3',
                Rule::unique('fakultas', 'nama_fakultas')->ignore($this->fakultas_id),
            ],
        ]);

        Fakultas::updateOrCreate(
            ['id' => $this->fakultas_id], 
            ['nama_fakultas' => $this->nama_fakultas]
        );

        session()->flash('message', $this->fakultas_id ? 'Fakultas berhasil diperbarui.' : 'Fakultas berhasil ditambahkan.');

        $this->closeModal();
    }

    public function delete($id)
    {
        try {
            Fakultas::findOrFail($id)->delete();
            session()->flash('message', 'Fakultas berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus fakultas, kemungkinan masih terhubung dengan data prodi.');
        }
    }


    public function render()
    {
        $semua_fakultas = Fakultas::latest()->paginate(5);
        return view('livewire.admin.fakultas.fakultas-index', [
            'semua_fakultas' => $semua_fakultas,
        ]);
    }
}