<x-app-layout>
    {{-- Alpine JS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.superadmin')

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
                    <h2 class="text-2xl font-semibold text-[#2B3674]">Daftar Sertifikat</h2>
                    <p class="text-sm text-gray-500">
                        Kelola dan Unduh Sertifikat Pengembangan Kompetensi ASN
                    </p>
                </div>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Sertifikat</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">6</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE5B4] shadow-sm">
                <h2 class="text-gray-700 text-sm font-medium">Total Peserta</h2>
                <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#DFFFE0] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Rata rata JP</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>
            </div>

            {{-- BUTTON ACTION --}}
            <div class="flex justify-end">
    <button
        @click="openModal = true"
        class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-medium hover:bg-[#ff9600] transition"
    >
        + Tambah Sertifikat
    </button>
</div>


            {{-- Table --}}
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Usulan (6)</h3>
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-6 py-4">
    
    <!-- Filter Button -->
    <button
        class="flex items-center gap-2 border border-gray-200 px-4 py-2 rounded-lg text-medium text-gray-700 hover:bg-gray-50"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />
        </svg>
        Filters
    </button>

    <!-- Search -->
    <div class="relative w-full md:w-72">
        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
        </span>
        <input
            type="text"
            placeholder="Search..."
            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg text-medium focus:ring-1 focus:ring-purple-500 focus:border-purple-500"
        >
    </div>

</div>
                <div class="overflow-x-auto p-6">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="border-b text-gray-600 text-sm">
                                <th class="py-3 px-4 text-left">No.</th>
                                <th class="py-3 px-4 text-left">Template</th>
                                <th class="py-3 px-4 text-left">Nomor Sertifikat</th>
                                <th class="py-3 px-4 text-left">Nama Kegiatan</th>
                                <th class="py-3 px-4 text-left">Jumlah JP</th>
                                <th class="py-3 px-4 text-left">Tanggal Sertifikat</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
        <tr>
            <td colspan="8" class="py-16 text-center">
                <div class="flex flex-col items-center gap-3 text-gray-500">
                    
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-300"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 2c-2.761 0-5 2.239-5 5v5h10v-5c0-2.761-2.239-5-5-5z" />
                    </svg>

                    <!-- Text -->
                    <p class="text-sm">
                        Belum ada sertifikat yang diterbitkan.  
                        Klik tombol <span class="font-medium text-purple-600">"Tambah Sertifikat"</span>
                        atau verifikasi template dari OPD.
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
   <!-- MODAL TAMBAH SERTIFIKAT -->
<div
    x-show="openModal"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
>
    <div
        @click.outside="openModal = false"
        class="bg-white w-full max-w-3xl rounded-xl shadow-lg max-h-[90vh] overflow-y-auto"
    >

        <!-- Header -->
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">
                Tambah Sertifikat Baru
            </h2>
            <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 text-xl">
                ✕
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">

            <!-- STEP 1 -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-purple-600 text-white flex items-center justify-center text-sm font-semibold">
                        1
                    </span>
                    <h3 class="font-semibold text-gray-800">
                        Informasi Template & Sertifikat
                    </h3>
                </div>

                <!-- Upload -->
                <div class="border-2 border-dashed rounded-xl p-6 text-center cursor-pointer hover:bg-gray-50 transition">
                <div class="flex flex-col items-center gap-3">

                <img
                    src="{{ asset('images/upload.png') }}"
                    alt="Upload"
                    class="w-14 h-14 object-contain"
                />

                <p class="text-sm font-medium">
                    Klik untuk upload atau drag & drop
                </p>

                <p class="text-xs text-gray-500">
                    PDF, DOCX (Max. 10MB)
                </p>
            </div>
    </div>

                <!-- OR -->
                <div class="text-center text-sm text-gray-500 my-3">
                    ATAU
                </div>

                <!-- Pilih Template -->
                <div>
                    <label class="text-sm font-medium">Pilih Template</label>
                    <select class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
                        <option>Pilih Template</option>
                        <option>Template Sertifikat Pelatihan</option>
                        <option>Template Workshop</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih salah satu: upload template baru atau pilih dari template yang sudah ada
                    </p>
                </div>

                <!-- Nomor & Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-sm font-medium">
                            Nomor Sertifikat <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="CERT/BKPSDM/2025/XXX"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Tanggal Sertifikat <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                        >
                    </div>
                </div>

                <!-- JP & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="text-sm font-medium">
                            Jumlah JP <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="24"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select class="mt-1 w-full border rounded-lg px-3 py-2 text-sm">
                            <option>Draft</option>
                            <option>Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-purple-600 text-white flex items-center justify-center text-sm font-semibold">
                        2
                    </span>
                    <h3 class="font-semibold text-gray-800">
                        Informasi Kegiatan & Peserta
                    </h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium">
                            Nama Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="Workshop Pelayanan Publik Berbasis Digital"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            OPD Penyelenggara <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="Dinas Kesehatan"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Jumlah Peserta <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm"
                            placeholder="100 Peserta"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            Contoh: 50 Peserta, 100 Peserta
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
            <button
                @click="openModal = false"
                class="px-4 py-2 border rounded-lg text-sm"
            >
                Batal
            </button>
            <button
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm flex items-center gap-2"
            >
                 Simpan Sertifikat
            </button>
        </div>

    </div>
</div>

</x-app-layout>
