<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Superadmin') }}
        </h2>
    </x-slot>
<!-- Profil Dropdown -->
<div x-data="{ open: false }" class="relative">
  <!-- Trigger -->
  <div @click="open = !open" class="flex items-center gap-2 cursor-pointer select-none">
    <img src="{{ asset('images/bkpsdm.png') }}" alt="Profile" class="w-8 h-8 rounded-full">
    <span class="text-[#2B3674] font-medium text-sm sm:text-base">{{ Auth::user()->name }}</span>
    <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform duration-200"
       :class="{ 'rotate-180': open }"></i>
  </div>

  <!-- Dropdown Menu -->
  <div x-show="open" 
       @click.outside="open = false"
       x-transition
       class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-lg py-2 z-50">
    <a href="{{ route('profile.edit') }}" 
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
      Profile
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" 
              class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Log Out
      </button>
    </form>
  </div>
</div>
    <div class="flex min-h-screen bg-gray-50">
        {{-- Sidebar --}}
        @include('pages.sidebar.superadmin')

        {{-- Konten Utama --}}
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Dashboard Superadmin</h1>
            <p>Selamat datang, Superadmin!</p>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
