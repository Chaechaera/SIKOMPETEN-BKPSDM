<x-app-layout>
<div class="flex min-h-screen bg-gray-50">

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 space-y-6">

        <!-- HEADER -->
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-semibold text-[#2B3674]">
                FORMULIR PENGAJUAN USULAN
            </h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                Silakan lengkapi data pada form ini untuk mengajukan usulan kegiatan.
            </p>
        </div>

        {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 1])

        <!-- FORM (UI ONLY) -->
        <form>

            <!-- IDENTITAS SURAT -->
            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Identitas Surat</h2>
                <p class="text-gray-500 text-sm mb-6">Lengkapi informasi identitas usulan.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nomor Surat</label>
                        <input type="text" placeholder="Contoh: 01/OPD/2025"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Surat</label>
                        <input type="date"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Perihal</label>
                        <input type="text" placeholder="Masukkan perihal surat"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Lampiran Surat</label>
                        <input type="text" placeholder="Masukkan jumlah lampiran surat"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Lampiran Surat</label>
                        <input type="text" placeholder="Masukkan jumlah lampiran surat"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Penanggung Jawab OPD</label>
                        <select class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>-- Pilih Penanggung Jawab --</option>
                            <option>Kepala BKPSDM</option>
                            <option>Sekretaris</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Pilih KOP</label>
                        <select class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>-- Pilih KOP Surat --</option>
                            <option>BKPSDM Surakarta</option>
                            <option>Dinas Kesehatan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- USULAN KEGIATAN -->
            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Usulan Kegiatan</h2>
                <p class="text-gray-500 text-sm mb-6">Lengkapi informasi usulan kegiatan.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Nama Kegiatan</label>
                        <input type="text" placeholder="Masukkan nama kegiatan"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Sub Unit Kerja</label>
                        <input type="text" value="Sub Unit Kerja" readonly
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Diajukan Oleh</label>
                        <input type="text" value="Nama Pengguna" readonly
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                        <input type="text" placeholder="Masukkan lokasi kegiatan"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Cara Pelatihan</label>
                        <select class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>-- Pilih Cara Pelatihan --</option>
                            <option>Klasikal</option>
                            <option>Non Klasikal</option>
                        </select>
                    </div>

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
                </div>
            </div>

            <!-- DETAIL KEGIATAN -->
            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Detail Kegiatan</h2>
                <p class="text-gray-500 text-sm mb-6">Lengkapi informasi detail kegiatan.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Narasumber</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Jumlah Peserta</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Alokasi Anggaran</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Metode Pelatihan</label>
                        <select class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>-- Pilih Metode --</option>
                            <option>Online</option>
                            <option>Offline</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">Unggah Jadwal (Excel)</label>
                        <input type="file"
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    @foreach (['Dasar Hukum', 'Latar Belakang', 'Maksud', 'Tujuan', 'Uraian', 'Hasil Langsung', 'Hasil Menengah', 'Hasil Panjang', 'Penutup' ] as $label)
                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
                            <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm h-28"
                                placeholder="Masukkan {{ strtolower($label) }}"></textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- BUTTON -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

    <!-- STEP INFO -->
    <div class="text-sm text-gray-500">
        Step <span class="font-semibold text-[#2B3674]">1</span> dari
        <span class="font-semibold text-[#2B3674]">9</span>
    </div>

    <!-- ACTION BUTTON -->
    <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
        <a href="{{ route('pengajuan.izinpengembangan') }}"
   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
    Kembali
</a>

        <button type="button"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
            Simpan Draft
        </button>

        <a href="{{ route('izinpengembangan.cetak-usulan') }}"
            class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
            Selanjutnya
        </a>
    </div>

</div>

        </form>
    </main>
</div>
</x-app-layout>
