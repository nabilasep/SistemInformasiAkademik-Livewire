<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            Dashboard Mahasiswa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 rounded-xl p-4 md:p-6 mb-6 shadow-lg">
                <h3 class="font-bold text-xl text-white">Selamat Datang, {{ $mahasiswa->nama }}!</h3>
                <p class="text-slate-400 mt-1">
                    <span class="font-semibold">NIM:</span> {{ $mahasiswa->nim }} | 
                    <span class="font-semibold">Prodi:</span> {{ $mahasiswa->prodi->nama_prodi ?? 'N/A' }}
                </p>
            </div>
            <div class="bg-slate-800 rounded-xl overflow-hidden shadow-lg">
                <div class="p-4 md:px-6 md:py-5 border-b border-slate-700">
                    <h4 class="font-bold text-lg text-white mb-0">Kartu Rencana Studi (KRS) Terakhir</h4>
                </div>
                @if (count($krs_terakhir) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-slate-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">Nama Matakuliah</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-slate-400 uppercase tracking-wider">SKS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-slate-800 divide-y divide-slate-700">
                                @foreach ($krs_terakhir as $krs)
                                    <tr class="hover:bg-slate-700/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $krs->matakuliah->kode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">{{ $krs->matakuliah->nama_matakuliah }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300 text-center">{{ $krs->matakuliah->sks }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-800 border-t-2 border-slate-700">
                                <tr>
                                    <td colspan="2" class="px-6 py-3 text-right font-bold text-slate-400 uppercase text-sm">Total SKS</td>
                                    <td class="px-6 py-3 font-bold text-white text-center text-lg">{{ $total_sks_terakhir }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="p-10 text-center text-slate-400">
                        Anda belum mengisi KRS untuk semester ini.
                    </div>
                @endif
                <div class="bg-slate-900/50 p-4 md:px-6 md:py-4 flex justify-end items-center">
                    <a href="{{ route('mahasiswa.krs') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md hover:shadow-lg hover:-translate-y-0.5 transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                           <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                           <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                        Isi / Ubah KRS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
