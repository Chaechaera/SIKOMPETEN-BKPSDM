<x-app-layout>
    <x-slot name="title">
        Download Sertifikat
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 9])

    <div class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]">

        {{-- Card --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m1 8H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-center text-xl font-semibold mb-1">
                Download Sertifikat
            </h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Sertifikat telah disetujui dan siap untuk diunduh
            </p>

            {{-- Status --}}
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                <div class="flex items-center gap-2 mb-1 text-green-700 font-semibold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status: Sertifikat Disetujui
                </div>
                <p class="text-sm text-green-700">
                    Sertifikat untuk semua peserta telah disetujui oleh BKPSDM dan siap diunduh
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3 mb-6">

                {{-- Download ZIP --}}
                <button
                    type="button"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                    </svg>
                    Download Semua Sertifikat (ZIP)
                </button>

                {{-- Lihat Daftar --}}
                <button
                    type="button"
                    class="w-full border border-gray-300 hover:bg-gray-50 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                    Lihat Daftar Sertifikat
                </button>

                {{-- Download per Peserta --}}
                <button
                    type="button"
                    class="w-full border border-gray-300 hover:bg-gray-50 py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                    Download per Peserta
                </button>

            </div>

            {{-- Informasi --}}
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
                <p class="font-semibold text-sm mb-2">
                    Informasi Sertifikat:
                </p>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Total Peserta: Sesuai data yang diupload</li>
                    <li>Format: PDF (Digital)</li>
                    <li>Status: Terverifikasi BKPSDM</li>
                </ul>
            </div>

            {{-- Tips --}}
            <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-sm text-yellow-800">
                💡 <strong>Tips:</strong>
                Sertifikat dapat dibagikan langsung kepada peserta melalui email atau dicetak untuk distribusi fisik
            </div>

            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">9</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.unggah-template') }}"
            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Kembali
        </a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('pengajuan.izinpengembangan') }}"
   class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition inline-block">
    Selesai
</a>

    </div>
</div>

        </div>
    </div>
</x-app-layout>
