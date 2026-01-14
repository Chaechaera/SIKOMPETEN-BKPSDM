<x-app-layout>
    {{-- Alpine JS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main 
            class="flex-1 p-6 space-y-6 transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'"
        >

    {{-- WRAPPER STATE --}}
    <div x-data="{ openModal: false }">

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- Header --}}
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-[#2B3674]">Izin Pengembangan</h2>
                    <p class="text-sm text-gray-500">
                        Kelola dan monitoring usulan kegiatan pengembangan kompetensi
                    </p>
                </div>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Usulan</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">6</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE5B4] shadow-sm">
                <h2 class="text-gray-700 text-sm font-medium">Di Setujui</h2>
                <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#DFFFE0] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Perlu Revisi</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>
            </div>

            {{-- BUTTON ACTION --}}
            <div class="flex justify-end">
            <a href="{{ route('izinpengembangan.input-data') }}"
                class="inline-block bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-medium hover:bg-[#ff9600] transition">
                + Tambah Usulan
            </a>
            </div>
            {{-- Table --}}
<div class="bg-white rounded-xl shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-medium text-gray-900">Daftar Usulan Kegiatan</h3>
        <p class="text-sm text-gray-500">
            Kelola usulan dengan melihat status, mengedit, atau menghapus data
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="border-b text-gray-600 text-sm">
                    <th class="py-3 px-4 text-left">No.</th>
                    <th class="py-3 px-4 text-left">Nomor Surat</th>
                    <th class="py-3 px-4 text-left">Judul</th>
                    <th class="py-3 px-4 text-left">Bentuk Pelatihan</th>
                    <th class="py-3 px-4 text-left">Sub Unit Kerja</th>
                    <th class="py-3 px-4 text-left">Status</th>
                    <th class="py-3 px-4 text-left">Aksi</th>
                </tr>
            </thead>
                        <tbody>
        <tr>
            <td colspan="8" class="py-16 text-center">
                <div class="flex flex-col items-center gap-3 text-gray-500">
                    
                    <!-- Icon -->
                    <img 
    src="{{ asset('images/File text.png') }}" 
    alt="Belum ada data"
    class="w-14 h-14 opacity-40"
/>
                    <!-- Text -->
                    <p class="text-sm">
                        Belum ada usulan kegiatan. Klik tombol "Tambah Usulan" untuk membuat usulan baru.
                    </p>
                </div>
            </td>
        </tr>
    </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
        </div>
    </div>
</div>

</x-app-layout>
