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
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR SERTIFIKAT PESERTA KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Unduh Sertifikat Keikutsertaan Anda dalam Kegiatan Pengembangan Kompetensi disini.
                </p>
            </div>

            {{-- Tabel Sertifikat --}}
                <div class="bg-white border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-60">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-24">NIP/NIK</th>
                                <th class="py-3 px-4 w-28">OPD</th>
                                <th class="py-3 px-4 w-48">Nama Peserta</th>
                                <th class="py-3 px-4 w-28">Nomor Sertifikat</th>
                                <th class="py-3 px-4 w-20">Laporan</th>
                                <th class="py-3 px-4 w-20">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($usulankegiatans as $index => $u)
                                @php
                                    $pesertas = $u->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->pesertakegiatans ?? collect();
                                @endphp

                                @foreach ($pesertas as $p)
                                    @php
                                        // Cek apakah peserta sudah upload laporan
                                        $laporanpesertakegiatans = \App\Izin\Models\Izin_Laporanpesertakegiatans::where('pesertakegiatan_id', $p->id)
                                            ->where('sertifikat_id', $p->sertifikat_id)
                                            ->first();
                                        
                                        $statuslaporan_pesertakegiatan = $laporanpesertakegiatans->statuslaporan_pesertakegiatan ?? null;
                                    @endphp
                                    <tr class="text-center hover:bg-gray-50 transition">
                                        <td class="py-3 px-4 text-left">
                                            {{ $u->inputusulankegiatans->nama_kegiatan }}
                                        </td>
                                        <td class="py-3 px-4">{{ $p->nip_nik_peserta }}</td>
                                        <td class="py-3 px-4">{{ $p->subunitkerjas->singkatan ?? '-' }}</td>
                                        <td class="py-3 px-4 text-left">{{ $p->nama_peserta }}</td>
                                        <td class="py-3 px-4">{{ $p->nomorsertifikatpeserta_kegiatan }}</td>
                                        <td class="py-3 px-4">
                                            @if(!$statuslaporan_pesertakegiatan)
        <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
           class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-orange-100 text-orange-700 hover:bg-orange-200 transition">
            Upload
        </a>

    @elseif($statuslaporan_pesertakegiatan === 'pending')
        <span class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-yellow-100 text-yellow-700">
            ⏳ Menunggu Validasi
        </span>

    @elseif($statuslaporan_pesertakegiatan === 'rejected')
        <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
           class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition">
            Upload Ulang
        </a>

    @elseif($statuslaporan_pesertakegiatan === 'approved')
        <span class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-green-100 text-green-700">
            ✓ Disetujui
        </span>
    @endif

                                        </td>
                                        <td class="py-3 px-4">
                                            @if($statuslaporan_pesertakegiatan === 'approved')
                                                <a href="{{ route('user.sertifikat.download', [$p->sertifikat_id, $p->id]) }}"
                                                   class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
                                                    Download
                                                </a>
                                            @else
                                                <button type="button" disabled
                                                   class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-gray-300 text-gray-500 cursor-not-allowed opacity-60">
                                                    Download
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>