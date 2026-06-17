<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">


            {{-- Header --}}
            @include('layouts.navigation')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

            {{-- 📝 FORM KIRIM LAPORAN KEGIATAN --}}
            <form method="POST"
      action="{{ route('admin.laporankegiatan.kirim.store', $usulan->id) }}"
      enctype="multipart/form-data">
    @csrf
                <input type="hidden" name="next_route" value="admin.laporankegiatan.kirim">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR KIRIM PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan upload file pada form ini.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulan" :is-laporan="true" />

                {{-- ================================================== --}}
                {{-- ======== BAGIAN 1: UPLOAD IDENTITAS SURAT ======== --}}
                {{-- ================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- ===================================================== --}}
                        {{-- ======= BAGIAN 2: UPLOAD FILE USULAN KEGIATAN ======= --}}
                        {{-- ===================================================== --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Upload File Laporan Kegiatan Final
                                <span class="text-gray-400 text-sm">(PDF/DOC/DOCX)</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Format: .pdf / .doc / .docx</p>
                            <p class="text-xs text-gray-500">Contoh nama file: file_laporan_kegiatan.pdf</p>
                            <div class="relative mb-3 mt-2">
                                <input type="file" name="filekirim_inputlaporankegiatan" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" {{ $laporankegiatans && $laporankegiatans?->kirimlaporankegiatans?->filekirim_inputlaporankegiatan ? '' : 'required' }}>
                                @if($laporankegiatans?->kirimlaporankegiatans?->filekirim_inputlaporankegiatan)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/'.$laporankegiatans?->kirimlaporankegiatans?->filekirim_inputlaporankegiatan) }}" target="_blank" class="text-blue-600">
                                            {{ basename($laporankegiatans?->kirimlaporankegiatans?->filekirim_inputlaporankegiatan) }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                                @error('filekirim_inputlaporankegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =========================================== --}}
                {{-- ========== BAGIAN 3: TOMBOL AKSI ========== --}}
                {{-- =========================================== --}}
                <div class="mt-6 relative flex items-center justify-between">

    {{-- Kiri --}}
    <a href="{{ route('admin.laporankegiatan.index') }}"
        class="w-2/12 text-center py-2.5 
        bg-gray-300 text-gray-700 px-6 
        rounded-lg text-sm hover:bg-gray-200 
        transition font-semibold">
        Batal Kirim
    </a>

    {{-- Step Tengah --}}
    <div class="absolute left-1/2 transform -translate-x-1/2">
        <span class="text-sm font-semibold text-gray-500">
            Step <span class="text-[#FFA41B] font-bold">4</span> dari 4
        </span>
    </div>

    {{-- Kanan --}}
    <button type="submit"
        class="w-2/12 text-center py-2.5 
        bg-[#FFA41B] text-white px-6 
        rounded-lg text-sm hover:bg-[#ff9600] 
        transition font-semibold">
        Kirim Laporan
    </button>

</div>
            </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#tanggal_surat", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

});
</script>
</x-app-layout>