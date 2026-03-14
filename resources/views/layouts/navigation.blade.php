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
}"
    class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- LEFT: Greeting -->
            <div>
                <h1 class="text-2xl font-medium text-[#2B3674]">
                    <span x-text="greeting"></span>,
                    <span class="font-bold">{{ Auth::user()->nama }}🪄</span>
                </h1>
                <p class="text-sm text-gray-500">
                    Hope you have a good day and good mood for work today!
                </p>
            </div>

            <!-- RIGHT: Profile -->
            <div class="flex items-center gap-4">

                <!-- Profile Dropdown -->
                <div class="relative" x-cloak>

                    <!-- Trigger -->
                    <div @click="openProfile = !openProfile"
                        class="flex items-center gap-2 cursor-pointer select-none">

                        <img src="{{ asset('images/bkpsdm.png') }}"
                            alt="Profile"
                            class="w-8 h-8 rounded-full">

                        <span class="text-[#2B3674] font-medium text-sm sm:text-base">
                            Halo, {{ $activeRole }}!!
                        </span>

                        <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform duration-200"
                            :class="{ 'rotate-180': openProfile }"></i>
                    </div>

                    <!-- Dropdown -->
                    <div x-show="openProfile"
                        @click.outside="openProfile = false"
                        x-transition
                        class="absolute right-0 mt-3 w-72 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">

                        <!-- USER CARD -->
                        <div class="flex items-center space-x-4 p-4 border-b border-gray-200">

                            <img src="{{ asset('images/bkpsdm.png') }}"
                                alt="Foto Profil"
                                class="w-12 h-12 rounded-full object-cover border border-gray-300" />

                            <div class="flex flex-col">
                                <span class="font-semibold text-base text-black">
                                    <span x-text="greeting"></span>, {{ Auth::user()->nama }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ Auth::user()->email }}
                                </span>
                            </div>
                        </div>

                        <!-- Menu -->
                        @if ($activeRole === 'admin')
                            @include('components.izin-menu-admin')
                        @elseif ($activeRole === 'superadmin')
                            @include('components.izin-menu-superadmin')
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