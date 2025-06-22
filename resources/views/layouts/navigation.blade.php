<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard') }}">
                        <span class="text-white font-bold text-lg">SIAKAD</span>
                    </a>
                </div>
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            {{-- Link untuk Admin --}}
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Admin Dashboard
                            </a>
                            <a href="{{ route('admin.fakultas.index') }}" class="{{ request()->routeIs('admin.fakultas.index') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Fakultas
                            </a>
                            <a href="{{ route('admin.prodi.index') }}" class="{{ request()->routeIs('admin.prodi.index') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Prodi
                            </a>
                            <a href="{{ route('admin.matakuliah.index') }}" class="{{ request()->routeIs('admin.matakuliah.index') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Matakuliah
                            </a>
                            <a href="{{ route('admin.mahasiswa.index') }}" class="{{ request()->routeIs('admin.mahasiswa.index') || request()->routeIs('admin.mahasiswa.krs') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Mahasiswa
                            </a>
                        @else
                            {{-- Link untuk Mahasiswa --}}
                            <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Dashboard
                            </a>
                            <a href="{{ route('mahasiswa.krs') }}" class="{{ request()->routeIs('mahasiswa.krs') ? 'bg-gray-900 text-white border-b-2 border-indigo-400' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium self-center transition-colors">
                                Isi KRS
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-800 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-900 focus:outline-none focus:bg-gray-900 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Admin Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.fakultas.index')" :active="request()->routeIs('admin.fakultas.index')">Fakultas</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.prodi.index')" :active="request()->routeIs('admin.prodi.index')">Prodi</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.matakuliah.index')" :active="request()->routeIs('admin.matakuliah.index')">Matakuliah</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.mahasiswa.index') || request()->routeIs('admin.mahasiswa.krs')">Mahasiswa</x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('mahasiswa.dashboard')" :active="request()->routeIs('mahasiswa.dashboard')">Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('mahasiswa.krs')" :active="request()->routeIs('mahasiswa.krs')">Isi KRS</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>