<div class="p-6" x-data="{ open: true }">

    <div x-show="open" class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-8 relative">

            {{-- Button Close --}}
            <button @click="open = false" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700"> ✕ </button>
            <div class="px-6 py-4 max-h-[80vh] overflow-y-auto">

            {{-- Header Judul Usulan yang Direview --}}
            <div class="mb-4">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">REVIEW LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan download atau cek surat laporan hasil kegiatan Pengembangan Kompetensi dahulu sebelum melakukan review.
                    </p>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                        Ringkasan Data Laporan Hasil Kegiatan yang Direview
                    </h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <!-- content grid -->


    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-5 text-sm">

        <div>
            <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->usulankegiatans?->subunitkerjas?->sub_unitkerja ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Unit Kerja</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->usulankegiatans?->subunitkerjas?->unitkerjas?->unitkerja ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->nama_kegiatan ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Cara Pelatihan</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->usulankegiatans?->carapelatihans?->cara_pelatihan ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Lokasi Kegiatan</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->lokasi_kegiatan ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Tanggal Pelaksanaan</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->tanggalmulai_kegiatan && $laporankegiatans->tanggalselesai_kegiatan
                    ? \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan)->translatedFormat('d F Y')
                    .' s/d '.
                    \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Waktu Pelaksanaan</p>
            <p class="font-medium text-[#5A5A5A]">
                {{ $laporankegiatans->waktumulai_kegiatan ?? '-' }}
                -
                {{ $laporankegiatans->waktuselesai_kegiatan ?? '-' }}
            </p>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Link Undangan</p>
            <a href="{{ $laporankegiatans->detaillaporankegiatans?->linkundangan_laporan }}"
               target="_blank"
               class="text-blue-600 hover:underline break-all">
                {{ $laporankegiatans->detaillaporankegiatans?->linkundangan_laporan ?? '-' }}
            </a>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Link Materi</p>
            <a href="{{ $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan }}"
               target="_blank"
               class="text-blue-600 hover:underline break-all">
                {{ $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan ?? '-' }}
            </a>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Link Daftar Hadir</p>
            <a href="{{ $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan }}"
               target="_blank"
               class="text-blue-600 hover:underline break-all">
                {{ $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan ?? '-' }}
            </a>
        </div>

        <div>
            <p class="text-gray-400 text-xs mb-1">Link Dokumentasi</p>
            <a href="{{ $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan }}"
               target="_blank"
               class="text-blue-600 hover:underline break-all">
                {{ $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan ?? '-' }}
            </a>
        </div>

    </div>

    <div class="mt-6 border-t pt-4">
        <p class="text-gray-400 text-xs mb-2">Rincian Laporan</p>
        <div class="text-sm text-[#5A5A5A] leading-relaxed whitespace-pre-line">
            {{ $laporankegiatans->detaillaporankegiatans?->rincian_laporan ?? '-' }}
        </div>
    </div>

    <div class="mt-6 border-t pt-4">
        <p class="text-gray-400 text-xs mb-2">Penutup Laporan</p>
        <div class="text-sm text-[#5A5A5A] leading-relaxed whitespace-pre-line">
            {{ $laporankegiatans->detaillaporankegiatans?->penutup_laporan ?? '-' }}
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

            @if($laporankegiatans->detaillaporankegiatans?->rundown_laporan)
                <a href="{{ asset('storage/'.$laporankegiatans->detaillaporankegiatans->rundown_laporan) }}"
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

            @if($laporankegiatans->detaillaporankegiatans?->peserta_laporan)
                <a href="{{ asset('storage/'.$laporankegiatans->detaillaporankegiatans->peserta_laporan) }}"
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

            @if($laporankegiatans->sertifikats?->templatesertifikat_kegiatan)
                <a href="{{ asset('storage/'.$laporankegiatans->sertifikats->templatesertifikat_kegiatan) }}"
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
    $gambar = $laporankegiatans->detaillaporankegiatans?->gambardokumentasi_laporan ?? [];
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

</div>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                        Form Review Laporan Hasil Kegiatan
                    </h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    {{-- Form Review Laporan --}}
                    <form method="POST" action="{{ route('superadmin.laporankegiatan.reviewUpload', $laporankegiatans->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="catatan_verifikasilaporankegiatan" class="block text-sm font-semibold text-[#5A5A5A] mb-2">Catatan Review (Opsional)</label>
                            <textarea
                                name="catatan_verifikasilaporankegiatan"
                                id="catatan_verifikasilaporankegiatan"
                                class="overflow-hidden smart-textarea block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                placeholder="Tuliskan catatan review untuk OPD"></textarea>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                            @php
    $usulanId = $laporankegiatans->inputlaporankegiatans?->inputusulankegiatans?->id;
@endphp

<a href="{{ route('superadmin.laporankegiatan.download', $usulanId) }}"
    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
    Tinjau Laporan
</a>
                            <button
                                type="submit"
                                name="actionlaporan_kegiatan"
                                value="accepted"
                                class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition">
                                Setujui Laporan
                            </button>
                            <button
                                type="submit"
                                name="actionlaporan_kegiatan"
                                value="rejected"
                                class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                                Tolak Laporan
                            </button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>