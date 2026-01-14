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
                <h3 class="font-semibold text-gray-800">Data Surat Balasan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Nomor Surat</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 mt-1"
                            placeholder="Contoh: 800/01/BKPSDM/2025">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Tanggal Surat</label>
                        <input type="date" class="w-full rounded-lg border-gray-300 mt-1">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Nomor Usulan Terkait</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 mt-1"
                            placeholder="USL-002">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Lampiran</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 mt-1"
                            placeholder="1 berkas">
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Perihal</label>
                    <textarea class="w-full rounded-lg border-gray-300 mt-1"
                        placeholder="Balasan Permohonan Izin Pelaksanaan Pelatihan..."></textarea>
                </div>
            </div>

            {{-- DATA USULAN (READ ONLY) --}}
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 space-y-4">
                <h3 class="font-semibold text-green-800">Data Usulan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Kegiatan</p>
                        <p class="font-medium">Pelatihan SPBE dan Transformasi Digital</p>
                    </div>

                    <div>
                        <p class="text-gray-500">OPD Pengusul</p>
                        <p class="font-medium">Diskominfo</p>
                    </div>
                </div>
            </div>

            {{-- KEPUTUSAN VERIFIKASI --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="font-semibold text-gray-800">Keputusan Verifikasi</h3>

                <select class="w-full rounded-lg border-gray-300">
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
                <h3 class="font-semibold text-green-800">Detail Persetujuan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" class="rounded-lg border-gray-300"
                        placeholder="Tempat Pelaksanaan">

                    <input type="number" class="rounded-lg border-gray-300"
                        placeholder="Jumlah Peserta">

                    <input type="date" class="rounded-lg border-gray-300">
                    <input type="date" class="rounded-lg border-gray-300">
                </div>

                <input type="text" class="w-full rounded-lg border-gray-300"
                    placeholder="Anggaran yang Disetujui">

                <textarea class="w-full rounded-lg border-gray-300"
                    placeholder="Syarat dan ketentuan khusus..."></textarea>
            </div>
            @endif

            {{-- ALASAN PENOLAKAN --}}
            @if($statusVerifikasi == 'rejected')
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 space-y-4">
                <h3 class="font-semibold text-red-800">Alasan Penolakan</h3>

                <textarea class="w-full rounded-lg border-gray-300"
                    placeholder="Jelaskan alasan penolakan usulan..."></textarea>
            </div>
            @endif

            {{-- CATATAN & TINDAK LANJUT --}}
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h3 class="font-semibold text-gray-800">Catatan dan Tindak Lanjut</h3>

                <textarea class="w-full rounded-lg border-gray-300"
                    placeholder="Instruksi atau tindak lanjut untuk OPD..."></textarea>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3">
                <button onclick="history.back()"
                 class="px-4 py-2 rounded-lg border text-gray-700">
                    Batal
                </button>
                <button class="px-4 py-2 rounded-lg bg-blue-600 text-white">
                    Preview Surat
                </button>
            </div>

        </div>
    </div>
</x-app-layout>
