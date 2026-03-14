<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIKOMPETEN</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans antialiased">

    {{-- Navbar --}}
    @include('components.izin-navbar')

    {{-- Background utama --}}
    <div class="min-h-screen bg-gray-100 pt-24">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-8 pb-16">

            {{-- Card Formulir --}}
            <div class="bg-white rounded-xl shadow p-6 mb-4 mt-10">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR UPLOAD LAPORAN HASIL IKUT SERTA PESERTA KEGIATAN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Silahkan upload laporan hasil keikutsertaan kegiatan Pengembangan Kompetensi Anda agar dapat mengunduh sertifikat
                </p>
            </div>

            <form action="{{ route('user.laporanpeserta.store', $sertifikat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- =================================================================== --}}
                {{-- === BAGIAN 1: Preview Data Kegiatan Pengembangan Kompetensi ASN === --}}
                {{-- =================================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
        
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan Pengembangan Kompetensi yang Diikuti</label>
                            <div class="relative">
                                <input type="text" name="nama_kegiatan" value="{{ $sertifikat->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan Pengembangan Kompetensi Berlangsung</label>
                            <div class="relative">
                                <input type="text" name="lokasi_kegiatan" value="{{ $sertifikat->laporankegiatans->lokasi_kegiatan ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Pelaksanaan Kegiatan Pengembangan Kompetensi</label>
                            <div class="relative">
                                <input type="text" name="tanggalpelaksanaan_kegiatan" value="{{ $sertifikat->laporankegiatans->tanggalmulai_kegiatan && $sertifikat->laporankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($sertifikat->laporankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                            \Carbon\Carbon::parse($sertifikat->laporankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- NIP/NIK Peserta Kegiatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">NIP/NIK Peserta Kegiatan</label>
                            <div class="relative">
                                <input type="text" name="nipnikpeserta_kegiatan" value="{{ $peserta->nip_nik_peserta ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Nama Peserta Kegiatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Peserta Kegiatan</label>
                            <div class="relative">
                                <input type="text" name="namapeserta_kegiatan" value="{{ $peserta->nama_peserta ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Upload Dokumen Laporan Hasil Kegiatan Peserta --}}
                        <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Upload File Laporan Hasil Kegiatan
                            <span class="text-gray-400 text-sm">(PDF, DOC, DOCX)</span>
                        </label>
                        
                        @if($laporanpesertakegiatans?->filelaporan_pesertakegiatan)
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                File saat ini: 
                                <a href="{{ asset('storage/' . $laporanpesertakegiatans->filelaporan_pesertakegiatan) }}" target="_blank" class="font-semibold underline">
                                    {{ basename($laporanpesertakegiatans->filelaporan_pesertakegiatan) }}
                                </a>
                            </p>
                        </div>
                        @endif

                        <input 
                            type="file" 
                            name="filelaporan_pesertakegiatan"
                            accept=".pdf,.doc,.docx"
                            class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2"
                            {{ $laporanpesertakegiatans ? '' : 'required' }}>
                        @error('filelaporan_pesertakegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-3 mb-6">
                    <a href="{{ route('user.sertifikat') }}" 
                        class="px-6 py-2.5 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 bg-[#FFA41B] text-white rounded-lg font-semibold hover:bg-[#ff9600] transition">
                        Upload Laporan
                    </button>
                </div>
            </form>
        </main>
    </div>
    </div>
    {{-- Navbar --}}
    @include('components.izin-footer')
</body>
</html>