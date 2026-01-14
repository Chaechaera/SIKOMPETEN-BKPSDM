<x-app-layout>
    <x-slot name="title">
        Unggah Data Peserta
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 7])

    <div class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]">

        {{-- Card --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-full bg-purple-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-center text-xl font-semibold mb-1">
                Unggah Data Peserta
            </h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Upload file Excel berisi daftar peserta yang mengikuti kegiatan
            </p>

            {{-- Template Download --}}
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">
                    Template Excel Peserta
                </label>
                <div class="flex items-center gap-3">
                    <input
                        type="text"
                        class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm"
                        value="Template Excel Peserta"
                        readonly
                    >
                    <a href="#"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        Download
                    </a>
                </div>
                <p class="text-xs text-gray-400 mt-2">
                    Download template, isi data peserta sesuai format, lalu upload kembali
                </p>
            </div>

                    {{-- Upload File --}}
<div class="mb-6">
    <label class="block text-sm font-medium mb-2">
        File Kirim (Upload)
    </label>

    <div class="border-2 border-gray-300 rounded-lg p-3 bg-white">
        <input
            type="file"
            class="w-full text-sm
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-lg file:border-0
                   file:text-sm file:font-semibold
                   file:bg-gray-100 file:text-gray-700
                   hover:file:bg-gray-200"
        >
    </div>

    <p class="text-xs text-gray-400 mt-2">
        Upload dokumen laporan yang sudah ditandatangani dan di-scan (Max 5MB)
    </p>
</div>


            {{-- Format Data --}}
            <div class="mb-8 p-4 rounded-xl bg-blue-50 border border-blue-100">
                <p class="font-semibold text-sm mb-2">
                    Format Data yang Diperlukan:
                </p>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Nama Lengkap</li>
                    <li>NIP</li>
                    <li>Jabatan</li>
                    <li>Unit Kerja</li>
                    <li>Nomor HP (opsional)</li>
                </ul>
            </div>

            {{-- Button --}}
<button
    type="submit"
    class="w-full flex items-center justify-center gap-2
           bg-purple-600 hover:bg-purple-700
           text-white font-medium py-3 rounded-lg transition">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2
                 M7 10l5-5m0 0l5 5m-5-5v12" />
    </svg>
    Upload Peserta
</button>

            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">7</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.kirim-laporan') }}"
            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Kembali
        </a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.unggah-template') }}"
   class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition inline-block">
    Selanjutnya
</a>

    </div>
</div>


        </div>
    </div>
</x-app-layout>
