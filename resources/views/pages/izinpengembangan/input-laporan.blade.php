<x-app-layout>
<div class="flex min-h-screen bg-gray-50">

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 space-y-6">

        <!-- HEADER -->
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-semibold text-[#2B3674]">
                FORMULIR LAPORAN KEGIATAN
            </h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                Silakan lengkapi data pada form ini untuk melakukan pelaporan kegiatan.
            </p>
        </div>

        {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 4])

        <!-- FORM (UI ONLY) -->
        <form>

            <!-- IDENTITAS SURAT -->
            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Laporan Pelaksanaan Kegiatan</h2>
                <p class="text-gray-500 text-sm mb-6">Isi laporan setelah kegiatan selesai dilaksanakan</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                     <div>
                        <label class="text-sm font-medium text-gray-700">Waktu Mulai</label>
                        <input
                            type="time"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Waktu Selesai</label>
                        <input
                            type="time"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                        <input type="text" placeholder="Masukkan lokasi kegiatan"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    @foreach (['Laporan Kegiatan', 'Susunan Acara', 'Penutup'] as $label)
                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
                            <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm h-28"
                                placeholder="Masukkan {{ strtolower($label) }}"></textarea>
                        </div>
                    @endforeach

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Link Kegiatan</label>
                        <input type="text" placeholder="https://contoh.com/dokumentasi"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <p class="text-xs text-gray-400 mt-1">
                            Link dokumentasi atau informasi kegiatan (opsional)
                        </p>
                    </div>

                   <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Edit Narasumber</label>
                        <input type="text" placeholder="Perbarui nama narasumber jika berbeda"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <!-- Status -->
                    <div class="sm:col-span-2 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-700">
                        Status Progress: Laporan Draft
                        </p>
                    </div>
                </div>
            </div>

            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">4</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('izinpengembangan.kirim-usulan') }}"
   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
    Kembali
</a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.cetak-laporan') }}"
            class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
            Selanjutnya
        </a>
    </div>

</div>

        </form>
    </main>
</div>
</x-app-layout>
