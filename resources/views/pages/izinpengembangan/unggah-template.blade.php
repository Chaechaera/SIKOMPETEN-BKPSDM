<x-app-layout>
    <x-slot name="title">
        Unggah Template Sertifikat
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 8])

    <div class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]">

        {{-- Card --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-center text-xl font-semibold mb-1">
                Unggah Template Sertifikat
            </h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Upload template sertifikat yang akan digunakan untuk peserta kegiatan
            </p>

            {{-- Panduan --}}
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
                <p class="font-semibold text-sm mb-2">
                    Panduan Template Sertifikat
                </p>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Format file: PDF, Word (.docx), atau desain (.png, .jpg)</li>
                    <li>Ukuran maksimal: 5MB</li>
                    <li>Gunakan placeholder untuk data dinamis (nama, NIP, dll)</li>
                    <li>Sertakan logo instansi dan tanda tangan pejabat</li>
                    <li>Pastikan layout sesuai ukuran kertas standar</li>
                </ul>
            </div>

            {{-- Upload File --}}
<div class="mb-6">
    <label class="block text-sm font-medium mb-2">
        Upload Template Sertifikat
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
        Upload file template sertifikat
    </p>
</div>


            {{-- Keterangan --}}
            <div class="mb-8">
                <label class="block text-sm font-medium mb-2">
                    Keterangan Template (Opsional)
                </label>
                <textarea
                    rows="3"
                    placeholder="Catatan atau keterangan tentang template"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-orange-500 focus:border-orange-500"
                ></textarea>
            </div>

            {{-- Button --}}
<button
    type="submit"
    class="w-full flex items-center justify-center gap-2
           bg-orange-600 hover:bg-orange-700
           text-white font-medium py-3 rounded-lg transition">
    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2
                 M7 10l5-5m0 0l5 5m-5-5v12" />
    </svg>
    Upload Template
</button>

            {{-- Catatan --}}
            <div class="mt-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-sm text-yellow-800">
                <strong>Catatan:</strong> Template Menunggu Verifikasi
                <p class="mt-1 text-xs text-yellow-700">
                    Template akan diverifikasi oleh BKPSDM sebelum sertifikat dibuat
                </p>
            </div>

            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">8</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.unggah-peserta') }}"
            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Kembali
        </a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.download-sertifikat') }}"
   class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition inline-block">
    Selanjutnya
</a>

    </div>
</div>

        </div>
    </div>
</x-app-layout>
