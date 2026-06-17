@php
$activeRole = session('active_role', Auth::user()->role);
$realRole = Auth::user()->role;
@endphp

<nav
    x-data="{
    openMenu:false,
    openProfile:false,
    greeting:'',

    init() {
        const hour = new Date().getHours();
        if (hour >= 5 && hour < 12) this.greeting = 'Selamat pagi';
        else if (hour >= 12 && hour < 17) this.greeting = 'Selamat siang';
        else if (hour >= 17 && hour < 21) this.greeting = 'Selamat sore';
        else this.greeting = 'Selamat malam';
    }
}">

    <div class="px-8 py-4">
        <div class="flex justify-between items-center h-16">

            <!-- LEFT: Greeting -->
            <div>
                <h1 class="text-2xl font-medium text-biruDark">
                    <span x-text="greeting"></span>,
                    <span class="font-bold">
    {{ Auth::user()->nama }} - {{ Auth::user()->subunitkerjas?->sub_unitkerja ?? '-' }} 🪄
</span>
                </h1>
                <p class="text-sm font-normal text-abuabuCerah">
                    Hope you have a good day and good mood for work today!
                </p>
            </div>

            <!-- RIGHT: Profile -->
            <div class="flex items-center gap-4">

                <!-- Profile Dropdown -->
                <div class="relative" x-cloak>
                    <!-- Trigger Profile -->
                    <div @click="openProfile = !openProfile" class="flex items-center gap-2 cursor-pointer select-none">
                        <!-- Foto Profil -->
                        <img src="{{ asset('images/bkpsdm.png') }}" alt="Profile" class="w-8 h-8 rounded-full">

                        <!-- Nama User -->
                        <span class="font-medium text-sm">
                            Halo, {{ $activeRole }}!!
                        </span>
                        <i data-lucide="chevron-down" class="text-sm w-5 h-5 transition-transform text-black duration-200" :class="{ 'rotate-180': openProfile }"></i>
                    </div>

                    <!-- Dropdown Profile -->
                    <div x-show="openProfile" @click.outside="openProfile = false" x-transition
                        class="absolute right-0 mt-3 w-72 bg-white border border-abuabuCerah/60 rounded-xl shadow-xl z-50 overflow-hidden">

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
                        @if ($activeRole === 'admin')
                        @include('components.izin-menu-admin')
                        @elseif ($activeRole === 'superadmin')
                        @include('components.izin-menu-superadmin')
                        @elseif ($activeRole === 'user')
                        @include('components.izin-menu-user')
                        @endif
                    </div>
                </div>

                <!-- Hamburger (mobile) -->
                <button @click="openMenu = !openMenu"
                    class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">

                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': openMenu, 'inline-flex': !openMenu}"
                            class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': !openMenu, 'inline-flex': openMenu}"
                            class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="openMenu" class="sm:hidden border-t border-gray-200">
        <div class="px-4 py-3 space-y-2">

            <a href="{{ route('dashboard') }}"
                class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                Dashboard
            </a>

            <a href="{{ route('profile.edit') }}"
                class="block px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-3 py-2 rounded-md text-gray-700 hover:bg-gray-100">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>