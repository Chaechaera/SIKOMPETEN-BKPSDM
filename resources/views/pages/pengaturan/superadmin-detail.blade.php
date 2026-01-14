<x-app-layout>
<div 
    x-data="{ 
        sidebarOpen: false, 
        activeTab: 'kop' 
    }" 
    class="flex min-h-screen bg-gray-50"
>

    {{-- Sidebar --}} 
    @include('pages.sidebar.superadmin')

    {{-- Main Content --}}
    <main 
        class="flex-1 p-6 space-y-6 transition-all duration-300"
        :class="sidebarOpen ? 'ml-64' : 'ml-0'"
    >
            {{-- Header --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('superadmin.pengaturan') }}"
                   class="bg-white text-blue-600 px-6 py-2 rounded-lg text-medium hover:bg-gray-200 transition">
                    &larr; Kembali
                </a>
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-[#2B3674]">
                        REFERENSI IZIN PENGEMBANGAN KOMPETENSI
                    </h2>
                    <p class="text-sm text-gray-500">
                        Daftar Referensi Izin Pengembangan Kompetensi ASN
                    </p>
                </div>
            </div>

            {{-- Profil --}}
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gray-200 flex items-center justify-center text-xl font-semibold text-gray-600">
                        D
                    </div>
                    <div>
                        <h3 class="font-semibold">Dr. Budi Santoso, M.Si</h3>
                        <p class="text-sm text-gray-600">NIP: 197805152008011001</p>
                        <p class="text-sm text-gray-600">Jabatan: Kepala BKPSDM</p>
                        <p class="text-sm text-gray-600">
                            Instansi: BKPSDM Provinsi Kalimantan Barat
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="bg-white rounded-lg p-6 shadow-sm">

                {{-- TAB BUTTON --}}
                <div class="flex gap-2 border-b pb-4 mb-6">
                    <button
                        @click="activeTab = 'kop'"
                        :class="activeTab === 'kop'
                            ? 'bg-purple-600 text-white'
                            : 'border text-gray-600'"
                        class="px-4 py-2 text-sm rounded-md transition">
                        KOP Surat
                    </button>

                    <button
                        @click="activeTab = 'ttd'"
                        :class="activeTab === 'ttd'
                            ? 'bg-purple-600 text-white'
                            : 'border text-gray-600'"
                        class="px-4 py-2 text-sm rounded-md transition">
                        Tanda Tangan
                    </button>

                    <button
                        @click="activeTab = 'stempel'"
                        :class="activeTab === 'stempel'
                            ? 'bg-purple-600 text-white'
                            : 'border text-gray-600'"
                        class="px-4 py-2 text-sm rounded-md transition">
                        Stempel
                    </button>
                </div>

                {{-- KOP SURAT --}}
                <div x-show="activeTab === 'kop'" x-transition>
                    <h4 class="text-sm font-medium mb-3">Upload KOP Surat</h4>

                    <div class="border-2 border-dashed rounded-lg p-10 text-center text-gray-500">
                        <p class="mb-2">Drag & drop file KOP surat atau</p>

                        <label class="cursor-pointer bg-purple-600 text-white px-4 py-2 rounded-md text-sm">
                            Pilih File
                            <input type="file" class="hidden">
                        </label>

                        <p class="text-xs text-gray-400 mt-2">
                            Format: PNG, JPG (Max 2MB)
                        </p>
                    </div>
                </div>

                {{-- TANDA TANGAN --}}
                <div x-show="activeTab === 'ttd'" x-transition>
                    <h4 class="text-sm font-medium mb-3">Upload Tanda Tangan</h4>

                    <div class="border-2 border-dashed rounded-lg p-10 text-center text-gray-500">
                        <p class="mb-2">Drag & drop file tanda tangan atau</p>

                        <label class="cursor-pointer bg-purple-600 text-white px-4 py-2 rounded-md text-sm">
                            Pilih File
                            <input type="file" class="hidden">
                        </label>

                        <p class="text-xs text-gray-400 mt-2">
                            Format: PNG background transparan (Max 1MB)
                        </p>
                    </div>
                </div>

                {{-- STEMPEL --}}
                <div x-show="activeTab === 'stempel'" x-transition>
                    <h4 class="text-sm font-medium mb-3">Upload Stempel</h4>

                    <div class="border-2 border-dashed rounded-lg p-10 text-center text-gray-500">
                        <p class="mb-2">Drag & drop file stempel atau</p>

                        <label class="cursor-pointer bg-purple-600 text-white px-4 py-2 rounded-md text-sm">
                            Pilih File
                            <input type="file" class="hidden">
                        </label>

                        <p class="text-xs text-gray-400 mt-2">
                            Format: PNG background transparan (Max 1MB)
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>
</x-app-layout>
