<x-app-layout>

    <div class="flex min-h-screen bg-gray-50">

        {{-- Sidebar Superadmin --}}
        @include('pages.sidebar.superadmin')

        {{-- Main Content --}}
        <main class="flex-1 p-6 space-y-6 ml-64">

            {{-- ================= HEADER ================= --}}
            <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4 mt-4">
                
                <div>
                    <h1 class="text-2xl font-semibold text-[#2B3674]">Hallo, Superadmin!</h1>
                    <p class="text-sm text-gray-500">Hope you have a good day</p>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notifikasi -->
                    <img 
                        src="{{ asset('images/notif.png') }}" 
                        class="w-6 h-6 cursor-pointer hover:opacity-80 transition"
                    >

                    <!-- Pesan -->
                    <img 
                        src="{{ asset('images/pesan.png') }}" 
                        class="w-5 h-5 cursor-pointer hover:opacity-80 transition"
                    >

                    <!-- Profil Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <div @click="open = !open" class="flex items-center gap-2 cursor-pointer">
                            <img src="{{ asset('images/bkpsdm.png') }}" class="w-8 h-8 rounded-full">
                            <span class="text-[#2B3674] font-medium text-sm sm:text-base">
                                {{ Auth::user()->name }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-sm"
                                :class="{ 'rotate-180': open }"></i>
                        </div>

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
                </div>

            </header>

            {{-- Greeting --}}
            <p class="mb-6 text-gray-700">Selamat datang, Superadmin!</p>

            {{-- ================= CARDS ================= --}}
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                <div class="p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Usulan</h2>
                    <p class="text-3xl font-bold text-[#2B3674] mt-2">5</p>
                    <p class="text-xs text-[#E74C3C] mt-1">+2 dari bulan lalu</p>
                </div>

                <div class="p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Disetujui</h2>
                    <p class="text-3xl font-bold text-[#2B3674] mt-2">3</p>
                    <p class="text-xs text-[#3498DB] mt-1">60% approval rate</p>
                </div>

                <div class="p-6 rounded-xl bg-[#F2E9FF] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Sertifikat</h2>
                    <p class="text-3xl font-bold text-[#2B3674] mt-2">2</p>
                    <p class="text-xs text-[#9B59B6] mt-1">Sertifikat Diterbitkan</p>
                </div>

            </section>

            {{-- ================= INFO BOX ================= --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-[#2B3674]">Informasi Terbaru</h2>
                <p class="text-gray-600">Belum ada informasi terbaru.</p>
            </div>

        </main>
    </div>

</x-app-layout>
