<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="#">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    {{-- ================= MENU ADMIN ================= --}}
                    @if(Auth::user()->role == 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard Admin') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.doctors.index')" :active="request()->routeIs('admin.doctors.*')">
                            {{ __('Kelola Dokter') }}
                        </x-nav-link>
                        {{-- Tambahkan menu admin lain di sini --}}
                    @endif

                    {{-- ================= MENU DOKTER ================= --}}
                    @if(Auth::user()->role == 'dokter')
                        <x-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.schedules.index')" :active="request()->routeIs('doctor.schedules.*')">
                            {{ __('Jadwal Saya') }}
                        </x-nav-link>

                        {{-- MENU VALIDASI (DENGAN BADGE NOTIFIKASI) --}}
                        <x-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">
                            {{ __('Validasi Janji') }}
                            
                            @php
                                $pendingCount = \App\Models\Appointment::where('doctor_id', Auth::id())->where('status', 'Pending')->count();
                            @endphp
                            
                            @if($pendingCount > 0)
                                <span class="ml-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </x-nav-link>

                        <x-nav-link :href="route('doctor.consultation.index')" :active="request()->routeIs('doctor.consultation.*')">
                            {{ __('Pemeriksaan') }}
                        </x-nav-link>
                    @endif

                    {{-- ================= MENU PASIEN ================= --}}
                    @if(Auth::user()->role == 'pasien')
                        <x-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                            {{ __('Dashboard Pasien') }}
                        </x-nav-link>
                        <x-nav-link :href="route('patient.appointments.create')" :active="request()->routeIs('patient.appointments.create')">
                            {{ __('Buat Janji Baru') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} <span class="text-xs text-gray-400">({{ ucfirst(Auth::user()->role) }})</span></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link> --}}

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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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
            
            {{-- MOBILE MENU DOKTER --}}
            @if(Auth::user()->role == 'dokter')
                <x-responsive-nav-link :href="route('doctor.dashboard')" :active="request()->routeIs('doctor.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('doctor.appointments.index')" :active="request()->routeIs('doctor.appointments.*')">
                    {{ __('Validasi Janji') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('doctor.consultation.index')" :active="request()->routeIs('doctor.consultation.*')">
                    {{ __('Pemeriksaan') }}
                </x-responsive-nav-link>
            
            {{-- MOBILE MENU PASIEN --}}
            @elseif(Auth::user()->role == 'pasien')
                <x-responsive-nav-link :href="route('patient.dashboard')" :active="request()->routeIs('patient.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                {{-- <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link> --}}

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