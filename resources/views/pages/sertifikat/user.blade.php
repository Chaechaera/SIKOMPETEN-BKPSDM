<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIKOMPETEN</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

            {{-- Filters --}}
            <div class="flex flex-col md:flex-row gap-4 mb-4 text-base font-normal">
                {{-- Search --}}
                <div class="bg-white rounded-xl shadow flex-1 relative">
                    <input type="text" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"><i data-lucide="search"></i></span>
                </div>

                {{-- Status Filter --}}
                <form method="GET">
                    <select name="statuslaporan_pesertakegiatan" onchange="this.form.submit()"
                        class="bg-white rounded-xl shadow w-full border-none md:w-52 px-3 py-3 text-gray-400">
                        <option value="">Status Laporan</option>
                        <option value="pending" {{ request('statuslaporan_pesertakegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('statuslaporan_pesertakegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('statuslaporan_pesertakegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <span><i data-lucide="chevron-down"></i></span>
                    </select>
                </form>
            </div>

            {{-- Tabel Sertifikat --}}
            <div class="bg-white border rounded-lg overflow-hidden">
                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr class="bg-gray-200 border-b text-center text-gray-700">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">NIP/NIK</th>
                            <th class="py-3 px-4 text-center">
                    <a href="{{ request()->fullUrlWithQuery([
                        'sort_tahun' => request('sort_tahun') == 'asc' ? 'desc' : 'asc'
                    ]) }}" class="flex items-center justify-center gap-1 hover:text-black">

                        Tahun

                        @if(request('sort_tahun') == 'asc')
                            <span><i data-lucide="arrow-up-narrow-wide"></i></span>
                        @elseif(request('sort_tahun') == 'desc')
                            <span><i data-lucide="arrow-down-wide-narrow"></i></span>
                        @else
                            <span><i data-lucide="arrow-up-narrow-wide"></i></span>
                        @endif
                    </a>
                </th>
                            <th class="py-3 px-4">Nama Kegiatan</th>
                            <th class="py-3 px-4">OPD Penyelenggara</th>
                            <th class="py-3 px-4">Nomor Sertifikat</th>
                            <th class="py-3 px-4">Laporan</th>
                            <th class="py-3 px-4">Sertifikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($usulankegiatans as $index => $u)
                        @php
                        $pesertas = $u->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->pesertakegiatans ?? collect();
                        @endphp

                        @foreach ($pesertas as $p)
                        @if($p->nip_nik_peserta == auth()->user()->nip || $p->nip_nik_peserta == auth()->user()->email)

                        @php
                        // Ambil tahun dari nomor sertifikat
                            preg_match('/\d{4}/', $p->nomorsertifikatpeserta_kegiatan, $match);
                            $tahun = $match[0] ?? '-';

                        // Cek apakah peserta sudah upload laporan
                        $laporanpesertakegiatans = \App\Izin\Models\Izin_Laporanpesertakegiatans::where('pesertakegiatan_id', $p->id)
                        ->where('sertifikat_id', $p->sertifikat_id)
                        ->first();

                        $statuslaporan_pesertakegiatan = $laporanpesertakegiatans->statuslaporan_pesertakegiatan ?? null;
                        @endphp
                        <tr class="text-center hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-left">{{ $p->nama_peserta }}</td>
                            <td class="py-3 px-4">{{ $p->nip_nik_peserta }}</td>
                            <td class="py-3 px-4">{{ $tahun }}</td>
                            <td class="py-3 px-4">
                                {{ $u->inputusulankegiatans->nama_kegiatan }}
                            </td>
                            <td class="py-3 px-4">{{ $p->subunitkerjas->singkatan ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $p->nomorsertifikatpeserta_kegiatan }}</td>
                            <td class="py-3 px-4">
                                @if(!$statuslaporan_pesertakegiatan)
                                <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
                                    class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-orange-100 text-orange-700 hover:bg-orange-200 transition">
                                    Upload
                                </a>

                                @elseif($statuslaporan_pesertakegiatan === 'pending')
                                <span class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-yellow-100 text-yellow-700 transition">
                                    Pending
                                </span>

                                @elseif($statuslaporan_pesertakegiatan === 'rejected')
                                <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
                                    class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-red-100 text-red-600 hover:bg-red-200 transition">
                                    Ditolak
                                </a>

                                @elseif($statuslaporan_pesertakegiatan === 'approved')
                                <span class="inline-block px-3 py-1.5 text-xs font-medium rounded-md bg-green-100 text-green-700 transition">
                                    Disetujui
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
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Footer Pagination --}}
                <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-3 text-sm text-gray-500">
                    <span>
                        {{ $usulankegiatans->firstItem() }}–{{ $usulankegiatans->lastItem() }}
                        dari {{ $usulankegiatans->total() }} data
                    </span>
                    <div>
                        {{ $usulankegiatans->links() }}
                    </div>
                </div>
        </div>
    </div>

    {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>