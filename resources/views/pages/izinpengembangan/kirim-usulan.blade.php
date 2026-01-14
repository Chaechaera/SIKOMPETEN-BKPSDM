<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kirim Usulan
        </h2>
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 3])

    <div class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]">

        <!-- Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            {{-- Icon --}}
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                </div>
            </div>

            {{-- Title --}}
            <h2 class="text-center text-xl font-semibold mb-1">
                Kirim Usulan ke BKPSDM
            </h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Lengkapi data dan kirim usulan ke BKPSDM untuk diverifikasi
            </p>

            {{-- Nomor Surat --}}
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">
                    Nomor Surat
                </label>
                <input
                    type="text"
                    placeholder="Contoh: 002/OPD/2025"
                    class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:ring-green-500 focus:border-green-500"
                >
            </div>

            {{-- Tanggal Surat --}}
            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">
                    Tanggal Surat
                </label>
                <input
                    type="date"
                    class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:ring-green-500 focus:border-green-500"
                >
            </div>

            {{-- Button --}}
            <button
                type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                </svg>
                Kirim Usulan ke BKPSDM
            </button>

            {{-- Status --}}
            <div class="mt-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-sm text-yellow-800">
                <strong>Status Progress:</strong> Usulan Menunggu Verifikasi
                <p class="mt-1 text-xs text-yellow-700">
                    Usulan Anda akan diverifikasi oleh BKPSDM
                </p>
            </div>


            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">3</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.cetak-usulan') }}"
            class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Kembali
        </a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.input-laporan') }}"
   class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition inline-block">
    Selanjutnya
</a>

    </div>
</div>

</div>
    </div>
</x-app-layout>
