<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <form wire:submit.prevent="saveMatakuliah">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $matakuliah_id ? 'Edit Matakuliah' : 'Tambah Matakuliah Baru' }}
                </h3>
                <div class="mt-4">
                    <label for="kode" class="block text-sm font-medium text-gray-700">Kode Matakuliah</label>
                    <input type="text" wire:model.defer="kode" id="kode" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: MK001">
                    @error('kode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label for="nama_matakuliah" class="block text-sm font-medium text-gray-700">Nama Matakuliah</label>
                    <input type="text" wire:model.defer="nama_matakuliah" id="nama_matakuliah" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: Dasar Pemrograman">
                    @error('nama_matakuliah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label for="sks" class="block text-sm font-medium text-gray-700">SKS</label>
                    <input type="number" wire:model.defer="sks" id="sks" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="2">
                    @error('sks') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                    <select wire:model.defer="prodi_id" id="prodi_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Prodi</option>
                        @foreach($semua_prodi_dropdown as $prodi)
                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                    @error('prodi_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                    Simpan
                </button>
                <button type="button" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>