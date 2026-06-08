<div class="p-6" x-data="{ open: true }">

    <div x-show="open" class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-8 relative">

            {{-- Button Close --}}
            <button @click="open = false" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700"> ✕ </button>
            <div class="px-6 py-4 max-h-[80vh] overflow-y-auto">

            {{-- Header Judul Usulan yang Dicetak --}}
            <div class="mb-4">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">CETAK LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan periksa dan pastikan data laporan hasil kegiatan yang telah diisikan sesuai sebelum mencetak.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulan" :is-laporan="true" />

                <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                        Ringkasan Data Laporan Hasil Kegiatan
                    </h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <!-- ========================= -->
<!-- DATA LAPORAN KEGIATAN -->
<!-- ========================= -->

<div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-5 text-sm">

    <div>
        <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->subunitkerjas?->sub_unitkerja ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Unit Kerja</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->subunitkerjas?->unitkerjas?->unitkerja ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->inputusulankegiatans?->nama_kegiatan ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Cara Pelatihan</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->carapelatihans?->cara_pelatihan ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Lokasi Kegiatan</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->lokasi_kegiatan ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Tanggal Pelaksanaan</p>
        <p class="font-medium text-[#5A5A5A]">
            @if(
                $usulan->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan &&
                $usulan->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
            )
                {{ \Carbon\Carbon::parse($usulan->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->translatedFormat('d F Y') }}
                s/d
                {{ \Carbon\Carbon::parse($usulan->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->translatedFormat('d F Y') }}
            @else
                -
            @endif
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Waktu Pelaksanaan</p>
        <p class="font-medium text-[#5A5A5A]">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->waktumulai_kegiatan ?? '-' }}
            -
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->waktuselesai_kegiatan ?? '-' }}
        </p>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Link Undangan</p>
        <a href="{{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkundangan_laporan }}"
           target="_blank"
           class="text-blue-600 hover:underline break-all">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkundangan_laporan ?? '-' }}
        </a>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Link Materi</p>
        <a href="{{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkmateri_laporan }}"
           target="_blank"
           class="text-blue-600 hover:underline break-all">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkmateri_laporan ?? '-' }}
        </a>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Link Daftar Hadir</p>
        <a href="{{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkdaftarhadir_laporan }}"
           target="_blank"
           class="text-blue-600 hover:underline break-all">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkdaftarhadir_laporan ?? '-' }}
        </a>
    </div>

    <div>
        <p class="text-gray-400 text-xs mb-1">Link Dokumentasi</p>
        <a href="{{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkdokumentasi_laporan }}"
           target="_blank"
           class="text-blue-600 hover:underline break-all">
            {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->linkdokumentasi_laporan ?? '-' }}
        </a>
    </div>

</div>

<!-- ========================= -->
<!-- RINCIAN LAPORAN -->
<!-- ========================= -->

<div class="mt-6 border-t pt-4">
    <p class="text-gray-400 text-xs mb-2">Rincian Laporan</p>

    <div class="text-sm text-[#5A5A5A] leading-relaxed whitespace-pre-line">
        {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->rincian_laporan ?? '-' }}
    </div>
</div>

<!-- ========================= -->
<!-- PENUTUP LAPORAN -->
<!-- ========================= -->

<div class="mt-6 border-t pt-4">
    <p class="text-gray-400 text-xs mb-2">Penutup Laporan</p>

    <div class="text-sm text-[#5A5A5A] leading-relaxed whitespace-pre-line">
        {{ $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->penutup_laporan ?? '-' }}
    </div>
</div>
<!-- ========================= -->
<!-- FILE PENDUKUNG LAPORAN -->
<!-- ========================= -->

<div class="mt-6 border-t pt-4">
    <p class="text-gray-400 text-xs mb-4">File Pendukung Laporan</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-5 text-sm">

        {{-- Rundown --}}
        <div>
            <p class="text-gray-400 text-xs mb-1">Rundown Kegiatan</p>

            @if($usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->rundown_laporan)
                <a href="{{ asset('storage/'.$usulan->inputlaporankegiatans->laporankegiatans->detaillaporankegiatans->rundown_laporan) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline">
                    Lihat File Rundown
                </a>
            @else
                <span class="text-[#5A5A5A]">-</span>
            @endif
        </div>

        {{-- Peserta --}}
        <div>
            <p class="text-gray-400 text-xs mb-1">Daftar Peserta Kegiatan</p>

            @if($usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->peserta_laporan)
                <a href="{{ asset('storage/'.$usulan->inputlaporankegiatans->laporankegiatans->detaillaporankegiatans->peserta_laporan) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline">
                    Lihat File Peserta
                </a>
            @else
                <span class="text-[#5A5A5A]">-</span>
            @endif
        </div>

        {{-- Template Sertifikat --}}
        <div>
            <p class="text-gray-400 text-xs mb-1">Template Sertifikat Kegiatan</p>

            @if($usulan->inputlaporankegiatans?->laporankegiatans?->sertifikats?->templatesertifikat_kegiatan)
                <a href="{{ asset('storage/'.$usulan->inputlaporankegiatans->laporankegiatans->sertifikats->templatesertifikat_kegiatan) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline">
                    Lihat Template Sertifikat
                </a>
            @else
                <span class="text-[#5A5A5A]">-</span>
            @endif
        </div>

    </div>
</div>
<!-- ========================= -->
<!-- DOKUMENTASI KEGIATAN -->
<!-- ========================= -->

<div class="mt-6 border-t pt-4">
    <p class="text-gray-400 text-xs mb-4">Dokumentasi Kegiatan</p>

    @php
        $gambar = $usulan->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->gambardokumentasi_laporan ?? [];
    @endphp

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @forelse($gambar as $file)
            <a href="{{ asset('storage/'.$file) }}" target="_blank">
                <img src="{{ asset('storage/'.$file) }}"
                     class="w-full h-40 object-cover rounded-lg border hover:opacity-90 transition">
            </a>
        @empty
            <p class="text-[#5A5A5A]">Tidak ada dokumentasi.</p>
        @endforelse

    </div>
</div>

            {{-- Form Review Usulan --}}
<div class="mt-6 relative flex items-center justify-between">

    {{-- Tombol Kiri --}}
    <a href="{{ route('admin.laporankegiatan.download', $usulan->id) }}"
        class="inline-flex items-center justify-center px-6 py-2.5 
        rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] 
        text-white font-semibold hover:opacity-90 transition">
        Tinjau Laporan
    </a>

    {{-- Step Tengah --}}
    <div class="absolute left-1/2 transform -translate-x-1/2">
        <span class="text-sm font-semibold text-gray-500">
            Step <span class="text-[#FFA41B] font-bold">3</span> dari 4
        </span>
    </div>

    {{-- Tombol Kanan --}}
    <form method="POST" action="{{ route('admin.laporankegiatan.cetak', $usulan->id) }}">
        @csrf
        <button type="submit"
            class="inline-flex items-center justify-center px-6 py-2.5 
            rounded-lg bg-gradient-to-r from-[#5b78f8] to-[#3651d4] 
            text-white font-semibold hover:opacity-90 transition">
            Cetak Laporan
        </button>
    </form>
</div>

</div>
        </div>
    </div>
</div>