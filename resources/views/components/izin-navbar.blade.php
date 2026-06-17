@php
$activeRole = session('active_role', Auth::user()->role ?? null);
$realRole = Auth::user()->role ?? null;
@endphp

<header x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 20" :class="scrolled ? 'shadow-md backdrop-blur-md' : ''"
    class="fixed top-0 left-0 w-full px-8 py-1 flex justify-between items-center text-white transition-all duration-300 z-50">

    <!-- Background layer -->
    <div :class="scrolled ? 'opacity-95' : 'opacity-100'"
        class="absolute inset-0 bg-primary-gradient transition-opacity duration-300 -z-10">
    </div>

    <!-- Logo -->
    <div class="flex items-center gap-4 text-3xl font-bold">
        <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-28 object-contain" alt="Logo BKPSDM">
        <span>SIKOMPETEN</span>
    </div>

    <!-- Navigation -->
    <div class="hidden md:flex items-center gap-10 font-normal text-sm">
        @auth
        {{-- ===== ROLE USER → PROFIL MODE ===== --}}
        @if ($realRole === 'user')
        <div class="absolute left-1/2 -translate-x-1/2 flex items-center gap-6">
            <a href="{{ route('user.aboutus') }}" class="hover:text-[#fea73d] transition">
                About Us
            </a>
            <a href="{{ route('user.sertifikat') }}" class="hover:text-orange transition">
                Sertifikat
            </a>
            <a href="{{ route('user.rekapitulasi') }}" class="hover:text-orange transition">
                Rekapitulasi
            </a>
            <a href="{{ route('user.dashboard') }}" class="hover:text-orange transition">
                Dashboard
            </a>
        </div>
        <nav x-data="{
                        openProfile:false,
                        greeting:'',
                        init() {
                            const hour = new Date().getHours();
                            if (hour >= 5 && hour < 12) this.greeting = 'Selamat pagi';
                            else if (hour >= 12 && hour < 17) this.greeting = 'Selamat siang';
                            else if (hour >= 17 && hour < 21) this.greeting = 'Selamat sore';
                            else this.greeting = 'Selamat malam';
                        }
                    }" class="text-sm font-normal">

            <div class="relative" x-cloak>
                <!-- Trigger Profile -->
                <div @click="openProfile = !openProfile" class="flex items-center gap-2 cursor-pointer select-none">
                    <!-- Foto Profil -->
                    <img src="{{ asset('images/bkpsdm.png') }}" alt="Profile" class="w-8 h-8 rounded-full">

                    <!-- Nama User -->
                    <span class="font-medium text-sm">
                        Halo, {{ Auth::user()->nama }}
                    </span>
                    <i data-lucide="chevron-down" class="text-sm w-5 h-5 transition-transform text-white duration-200" :class="{ 'rotate-180': openProfile }"></i>
                </div>

                <!-- Dropdown Profile -->
                <div x-show="openProfile" @click.outside="openProfile = false" x-transition
                    class="absolute right-0 mt-3 w-72 text-black bg-white border border-abuabuCerah/60 rounded-xl shadow-xl z-50 overflow-hidden">

                    <!-- User Card -->
                    <div class="flex items-center space-x-4 p-4 border-b border-abuabuCerah">
                        <!-- Foto Profil -->
                        <img src="{{ asset('images/bkpsdm.png') }}" alt="Foto Profil"
                            class="w-12 h-12 rounded-full object-cover border border-abuabuCerah/40" />

                        <!-- User Info -->
                        <div class="flex flex-col">
                            <span class="font-medium text-sm text-abuabuSedang">
                                <span x-text="greeting"></span>,
                            </span>
                            <span class="font-semibold text-lg">
                                {{ Auth::user()->nama }}
                            </span>
                        </div>
                    </div>

                    <!-- User Detail -->
                    <div class="flex items-center space-x-4 p-4 border-b border-abuabuCerah">
                        <div class="flex flex-col">
                            <span class="font-medium text-xs text-abuabuSedang pb-2">
                                Tentang Anda
                            </span>
                            <div class="flex items-center gap-2 text-sm py-1">
                                <i data-lucide="building-2" class="w-5 h-5 mt-0.5 flex-shrink-0"></i>
                                <span class="leading-snug break-words">{{ Auth::user()->subunitkerjas->sub_unitkerja ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm py-1">
                                <i data-lucide="id-card" class="w-5 h-5"></i>
                                <span>{{ Auth::user()->nip ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm py-1">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                                <span>{{ Auth::user()->email ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Menu -->
                    @if ($activeRole === 'user')
                    @include('components.izin-menu-user')
                    @endif
                </div>
            </div>
        </nav>
        @endif
        @else
        <a href="/" class="font-semibold hover:text-orange transition">
            About Us
        </a>
        <a href="{{ route('register') }}"
            class="bg-orange px-5 py-2 font-semibold rounded-lg shadow-md hover:bg-orange/70 transition">
            Registrasi
        </a>
        <a href="{{ route('login') }}"
            class="bg-orange px-5 py-2 font-semibold rounded-lg shadow-md hover:bg-orange/70 transition">
            Login
        </a>
        @endauth
    </div>

</header>