@php
$activeRole = session('active_role', Auth::user()->role ?? null);
$realRole = Auth::user()->role ?? null;
@endphp

<header x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 20" :class="scrolled
    ? 'bg-gradient-to-r from-[#922B80]/95 to-[#5B2C89]/95 backdrop-blur shadow-md'
    : 'bg-gradient-to-r from-[#922B80] to-[#5B2C89]'" class="fixed top-0 left-0 w-full px-8 py-1 flex justify-between items-center
           text-white transition-all duration-300 z-50">

    <!-- Logo -->
    <div class="flex items-center gap-4 text-2xl font-bold">
        <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-32 object-contain" alt="Logo BKPSDM">
        <span>SIKOMPETEN</span>
    </div>

    <!-- Navigation -->
    <nav class="hidden md:flex items-center gap-6 font-medium text-base">
        @auth
        {{-- ===== ROLE USER → PROFIL MODE ===== --}}
        @if ($realRole === 'user')
        <div class="absolute left-1/2 -translate-x-1/2 flex items-center gap-6">
            <a href="{{ route('user.aboutus') }}" class="hover:text-[#fea73d] transition">
                Informasi
            </a>
            <a href="{{ route('user.sertifikat') }}" class="hover:text-[#fea73d] transition">
                Sertifikat
            </a>
            <a href="{{ route('user.rekapitulasi') }}" class="hover:text-[#fea73d] transition">
                Rekapitulasi
            </a>
            <a href="{{ route('user.dashboard') }}" class="hover:text-[#fea73d] transition">
                Dashboard
            </a>
        </div>
        <div x-data="{
                                    openProfile:false,
                                    greeting:'',
                                    init() {
                                        const hour = new Date().getHours();
                                        if (hour >= 5 && hour < 12) this.greeting = 'Selamat pagi';
                                        else if (hour >= 12 && hour < 17) this.greeting = 'Selamat siang';
                                        else if (hour >= 17 && hour < 21) this.greeting = 'Selamat sore';
                                        else this.greeting = 'Selamat malam';
                                    }
                                }" class="relative" x-cloak>

            <!-- Trigger -->
            <div @click="openProfile = !openProfile" class="flex items-center gap-2 cursor-pointer select-none">

                <img src="{{ asset('images/bkpsdm.png') }}" alt="Profile" class="w-8 h-8 rounded-full">

                <span class="font-medium text-sm sm:text-base">
                    Halo, {{ Auth::user()->nama }}
                </span>

                <i class="fa-solid fa-chevron-down text-sm transition-transform text-white duration-200"
                    :class="{ 'rotate-180': openProfile }"></i>
            </div>

            <!-- Dropdown -->
            <div x-show="openProfile" @click.outside="openProfile = false" x-transition
                class="absolute right-0 mt-3 w-72 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden text-gray-800">

                <!-- USER CARD -->
                <div class="flex items-center space-x-4 p-4 border-b border-gray-200">

                    <img src="{{ asset('images/bkpsdm.png') }}" alt="Foto Profil"
                        class="w-12 h-12 rounded-full object-cover border border-gray-300" />

                    <div class="flex flex-col">
                        <span class="font-semibold text-base">
                            <span x-text="greeting"></span>, {{ Auth::user()->nama }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ Auth::user()->email }}
                        </span>
                    </div>
                </div>

                <!-- Menu -->
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 hover:bg-gray-100 text-sm">
                    Dashboard
                </a>

                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 hover:bg-gray-100 text-sm">
                    <i class="fa-solid fa-user w-4"></i>
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 text-sm">
                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
        @endif
        @else
        <a href="/" class="hover:text-[#fea73d] transition">
            About Us
        </a>
        <a href="{{ route('register') }}"
            class="bg-[#F7941E] px-5 py-2 rounded-lg shadow-md hover:bg-[#fea73d] transition">
            Registrasi
        </a>
        <a href="{{ route('login') }}"
            class="bg-[#F7941E] px-5 py-2 rounded-lg shadow-md hover:bg-[#fea73d] transition">
            Login
        </a>
        @endauth
    </nav>

</header>