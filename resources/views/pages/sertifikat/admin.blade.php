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
                    <h2 class="text-2xl font-semibold text-[#2B3674]">Daftar Sertifikat</h2>
                    <p class="text-sm text-gray-500">
                        Upload dan Kelola Template Sertifikat Kegiatan Pengembangan Kompetensi
                    </p>
                </div>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Template</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">6</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE5B4] shadow-sm">
                <h2 class="text-gray-700 text-sm font-medium">Di Setujui</h2>
                <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#DFFFE0] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Menunggu</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>
            </div>

            {{-- BUTTON ACTION --}}
            <div class="flex justify-end">
    <button
        @click="openModal = true"
        class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-medium hover:bg-[#ff9600] transition"
    >
        + Upload Template
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
                                <th class="py-3 px-4 text-left">Nama File</th>
                                <th class="py-3 px-4 text-left">Nama Kegiatan</th>
                                <th class="py-3 px-4 text-left">Jenis</th>
                                <th class="py-3 px-4 text-left">Ukuran</th>
                                <th class="py-3 px-4 text-left">Tanggal Upload</th>
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
                        Belum ada template yang di upload.
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

   <!-- MODAL UPLOAD TEMPLATE -->
<div
    x-show="openModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
>
    <div
        @click.outside="openModal = false"
        class="bg-white w-full max-w-2xl rounded-xl shadow-lg overflow-hidden"
    >

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h2 class="text-lg font-semibold text-gray-900">
                Upload Template Sertifikat
            </h2>
            <button
                @click="openModal = false"
                class="text-gray-400 hover:text-gray-600 text-xl"
            >
                ✕
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-5">

            <!-- Jenis Template -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Template <span class="text-red-500">*</span>
                </label>
                <select
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-[#FFA41B] focus:outline-none"
                >
                    <option selected disabled>Pilih Jenis Template</option>
                    <option>Pelatihan</option>
                    <option>Workshop</option>
                    <option>Webinar</option>
                    <option>Bimbingan Teknis</option>
                </select>
            </div>

            <!-- Nama Kegiatan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kegiatan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    placeholder="Workshop Pelayanan Publik Berbasis Digital"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-[#FFA41B] focus:outline-none"
                >
            </div>

            <!-- Upload File -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    File Template <span class="text-red-500">*</span>
                </label>

                <div
                    class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-[#FFA41B] transition cursor-pointer"
                >
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-orange-100 text-[#FFA41B]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0l-4 4m4-4l4 4" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-700">
                            Klik untuk upload atau drag & drop
                        </p>
                        <p class="text-xs text-gray-500">
                            PDF, DOCX (Max. 10MB)
                        </p>
                    </div>
                    <input type="file" class="hidden">
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
            <button
                @click="openModal = false"
                class="px-5 py-2 text-sm rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100"
            >
                Batal
            </button>
            <button
                class="px-5 py-2 text-sm rounded-lg bg-[#FFA41B] text-white hover:bg-[#ff9600]"
            >
                Upload Template
            </button>
        </div>

    </div>
</div>

</x-app-layout>
