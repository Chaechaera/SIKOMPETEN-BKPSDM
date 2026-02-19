<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cetak Dokumen Usulan
        </h2>
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 2])

    <div class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]">

            <!-- Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            <!-- Header Icon & Title -->
            <div class="text-center mb-8">
                <div class="mx-auto w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6M7 20h10a2 2 0 002-2V8l-6-6H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>

                <h1 class="text-xl font-semibold text-gray-800">
                    Cetak Dokumen Usulan
                </h1>
                <p class="text-sm text-gray-500">
                    Lengkapi informasi surat dan cetak dokumen usulan
                </p>
            </div>


                <!-- Sifat -->
            <div class="mb-6">
                <label class="text-sm font-medium text-gray-700">
                Sifat
                </label>
            <select
                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                bg-white focus:border-blue-500 focus:ring-blue-500">
            <option value="" selected disabled>
                Pilih sifat surat
            </option>
            <option value="biasa">Biasa</option>
            <option value="segera">Segera</option>
            <option value="sangat_segera">Sangat Segera</option>
            </select>

            <p class="text-xs text-gray-400 mt-1">
                Pilih sifat surat sesuai tingkat urgensi
            </p>
        </div>

                <!-- Lampiran -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700">
                        Lampiran
                    </label>
                    <input type="text"
                           placeholder="Jumlah lampiran (contoh: 2 lembar)"
                           class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <!-- Perihal -->
                <div class="mb-6">
                    <label class="text-sm font-medium text-gray-700">
                        Perihal
                    </label>
                    <input type="text"
                           placeholder="Perihal surat"
                           class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <!-- Yth -->
                <div class="mb-8">
                    <label class="text-sm font-medium text-gray-700">
                        Yth
                    </label>
                    <input type="text"
                           value="BKPSDM Kota Surakarta"
                           disabled
                           class="w-full rounded-lg bg-gray-100 border-gray-200 text-gray-600 text-sm">
                    <p class="text-xs text-gray-400 mt-1">
                        Tujuan surat sudah ditetapkan ke BKPSDM
                    </p>
                </div>

                <!-- Buttons -->
                <div class="space-y-4">
                    <button type="button"
                            class="w-full flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lihat Preview Dokumen
                    </button>

                    <button type="button"
                            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v12m0 0l3-3m-3 3l-3-3m6 5H6" />
                        </svg>
                        Cetak Dokumen Usulan (PDF)
                    </button>
                </div>

                <!-- Status -->
                <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm font-medium text-green-700">
                        Status Progress: Cetak
                    </p>
                    <p class="text-xs text-green-600">
                        Setelah file PDF berhasil dibuat, lanjutkan ke tahap berikutnya
                    </p>
                </div>

                <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">2</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.input-data') }}"
            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Kembali
        </a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.kirim-usulan') }}"
   class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition inline-block">
    Selanjutnya
</a>

    </div>

</div>

            </div>
        </div>
    </div>
</x-app-layout>
