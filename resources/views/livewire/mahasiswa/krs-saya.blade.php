<div>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 -mx-4 -my-4 sm:-mx-6 sm:-my-6 lg:-mx-8 lg:-my-8 px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        Formulir Rencana Studi (KRS)
                    </h2>
                    <p class="text-blue-100 mt-1">Silakan pilih mata kuliah yang akan Anda ambil.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="bg-gray-100 dark:bg-gray-900/50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-3 mb-3">Data Mahasiswa</h3>
                        @if($mahasiswa)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <dt class="text-gray-500 font-medium">Nama</dt>
                                <dd class="text-gray-900 dark:text-gray-100 font-semibold">{{ $mahasiswa->nama }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">NIM</dt>
                                <dd class="text-gray-900 dark:text-gray-100 font-semibold">{{ $mahasiswa->nim }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Prodi Utama</dt>
                                <dd class="text-gray-900 dark:text-gray-100 font-semibold">{{ $mahasiswa->prodi->nama_prodi ?? 'N/A' }}</dd>
                            </div>
                        </div>
                        @else
                        <p class="text-gray-500">Profil mahasiswa tidak ditemukan.</p>
                        @endif
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">
                    <form wire:submit.prevent="saveKrs">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Pilih Mata Kuliah</h3>

                        @if (session()->has('error'))
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4" role="alert">
                                <p>{{ session('error') }}</p>
                            </div>
                        @endif
                        <div class="mt-4 p-4 border rounded-lg bg-gray-50 dark:bg-gray-900/50 dark:border-gray-700">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Semester Pengambilan KRS</label>
                            <div class="flex items-center space-x-4 mt-2">
                                <div class="w-1/2">
                                    <select wire:model.defer="tipe_semester" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Pilih Tipe</option>
                                        @foreach($opsi_tipe_semester as $tipe)
                                            <option value="{{ $tipe }}">{{ $tipe }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipe_semester') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="w-1/2">
                                    <select wire:model.defer="tahun_ajaran" class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Pilih Tahun Ajaran</option>
                                        @foreach($opsi_tahun_ajaran as $tahun)
                                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                                        @endforeach
                                    </select>
                                    @error('tahun_ajaran') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 p-4 border-t border-b dark:border-gray-700 flex justify-end items-center">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mr-4">Total SKS Dipilih:</p>
                            <span class="font-bold text-2xl text-indigo-600 dark:text-indigo-400">{{ $totalSks }}</span>
                            <span class="text-gray-500 dark:text-gray-400 ml-1">/ 24</span>
                        </div>
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse ($semua_matakuliah as $matakuliah)
                                <label class="p-4 flex items-center border dark:border-gray-700 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 dark:hover:bg-gray-700/50 transition-all has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500">
                                    <input type="checkbox" wire:model.live="selectedMatakuliah" value="{{ $matakuliah->id }}" class="h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-4 flex flex-col">
                                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $matakuliah->nama_matakuliah }}</span>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">({{ $matakuliah->sks }} SKS)</span>
                                    </span>
                                </label>
                            @empty
                                <p class="text-gray-500 md:col-span-2">Tidak ada mata kuliah yang tersedia untuk prodi Anda.</p>
                            @endforelse
                        </div>
                        @error('selectedMatakuliah') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Simpan KRS
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
