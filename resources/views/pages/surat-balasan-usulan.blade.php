<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Form Surat Balasan
            </h2>
        </div>
    </x-slot>

    @php
        // =========================
        // UI ONLY (dummy status)
        // approved | rejected
        // =========================
        $statusVerifikasi = 'approved';
    @endphp

      <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- BACK --}}
<button onclick="history.back()"
    class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
     Kembali
</button>

            {{-- INFO --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-medium text-blue-800 flex items-center gap-2">
            <img src="{{ asset('images/Info.png') }}" class="h-5 w-5 flex-shrink-0">
            <span>
                Form ini digunakan untuk membuat surat balasan hasil verifikasi
                usulan kegiatan OPD.
            </span>
            </div>

            {{-- DATA SURAT BALASAN --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="text-lg font-semibold text-[#2B3674] mb-1">Data Surat Balasan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nomor Surat</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                            placeholder="Contoh: 800/01/BKPSDM/2025">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Surat</label>
                        <input type="date" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Nomor Usulan Terkait</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                            placeholder="USL-002">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Lampiran</label>
                        <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                            placeholder="1 berkas">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Perihal</label>
                    <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                        placeholder="Balasan Permohonan Izin Pelaksanaan Pelatihan..."></textarea>
                </div>
            </div>

            {{-- DATA USULAN (READ ONLY) --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-green-800">Data Usulan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Nama Kegiatan</p>
                        <p class="font-medium">Pelatihan SPBE dan Transformasi Digital</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-700">OPD Pengusul</p>
                        <p class="font-medium">Diskominfo</p>
                    </div>
                </div>
            </div>

            {{-- KEPUTUSAN VERIFIKASI --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="text-lg font-semibold text-[#2B3674] mb-1">Keputusan Verifikasi</h3>

                <select class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option {{ $statusVerifikasi=='approved'?'selected':'' }}>
                        Disetujui
                    </option>
                    <option {{ $statusVerifikasi=='rejected'?'selected':'' }}>
                        Ditolak
                    </option>
                </select>
            </div>

            {{-- DETAIL PERSETUJUAN --}}
            @if($statusVerifikasi == 'approved')
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-green-800">Detail Persetujuan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                        placeholder="Tempat Pelaksanaan">

                    <input type="number" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                        placeholder="Peserta">

                    <input type="date" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <input type="date" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                </div>

                <input type="text" class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    placeholder="Anggaran yang Disetujui">

                <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    placeholder="Syarat dan ketentuan khusus..."></textarea>
            </div>
            @endif

            {{-- ALASAN PENOLAKAN --}}
            @if($statusVerifikasi == 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 space-y-4">
                <h3 class="text-lg font-semibold text-red-800">Alasan Penolakan</h3>

                <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    placeholder="Jelaskan alasan penolakan usulan..."></textarea>
            </div>
            @endif

            {{-- CATATAN & TINDAK LANJUT --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="text-lg font-semibold text-[#2B3674] mb-1">Catatan dan Tindak Lanjut</h3>

                <textarea class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    placeholder="Instruksi atau tindak lanjut untuk OPD..."></textarea>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-between sm:justify-end gap-3 w-full sm:w-auto">
                <button onclick="history.back()"
                 class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                    Batal
                </button>
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm">
                    Preview Surat
                </button>
                <a href="{{ route('usulankegiatan.daftar-masuk') }}"
                class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
                    Kirim
                </a>

            </div>

        </div>
    </div>
</x-app-layout>
