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
    <div class="min-h-screen pt-24">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-4 pb-12">

            {{-- Card Informasi Sertifikat --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
                <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR SERTIFIKAT PESERTA KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-abuabuCerah max-w-4xl">
                    Unduh Sertifikat Keikutsertaan Anda dalam Kegiatan Pengembangan Kompetensi disini.
                </p>
            </div>

            {{-- Filters --}}
            <div class="flex flex-col md:flex-row gap-4 mb-4 text-base font-normal">
                {{-- Search --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                    <form method="GET">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                    </form>
                </div>

                {{-- Status Filter --}}
                <form method="GET">
                    <select name="statuslaporan_pesertakegiatan" onchange="this.form.submit()"
                        class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                        <option value="">Status Laporan</option>
                        <option class="text-black" value="belum_upload" {{ request('statuslaporan_pesertakegiatan') == 'belum_upload' ? 'selected' : '' }}>Belum Upload</option>
                        <option class="text-black" value="pending" {{ request('statuslaporan_pesertakegiatan') == 'pending' ? 'selected' : '' }}>Sedang Divalidasi</option>
                        <option class="text-black" value="approved" {{ request('statuslaporan_pesertakegiatan') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option class="text-black" value="rejected" {{ request('statuslaporan_pesertakegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>

            {{-- Tabel Sertifikat --}}
            <div class="bg-white rounded-xl overflow-hidden shadow">
                <table class="w-full text-sm font-semibold table-auto">
                    <thead>
                        <tr class="bg-abuabuMuda border-b text-center">
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">NIP/NIK</th>
                            <th class="py-3 px-4">
                                <a href="{{ request()->fullUrlWithQuery(['sort_tahun' => request('sort_tahun') == 'asc' ? 'desc' : 'asc']) }}" class="flex items-center justify-center gap-1 transition">
                                    Tahun
                                    @if(request('sort_tahun') == 'asc')
                                    <span><i class="h-5 w-5 text-abuabuSedang" data-lucide="arrow-up-narrow-wide"></i></span>
                                    @elseif(request('sort_tahun') == 'desc')
                                    <span><i class="h-5 w-5 text-abuabuSedang" data-lucide="arrow-down-wide-narrow"></i></span>
                                    @else
                                    <span><i class="h-5 w-5 text-abuabuSedang" data-lucide="arrow-down-wide-narrow"></i></span>
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
                    <tbody>
                        {{--@foreach ($usulankegiatans as $index => $u)
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
                    @endphp--}}
                        @forelse ($sertifikats as $s)

                        @php
                        $p = $s->pesertakegiatans->first();
if (!$p) return;
                        $laporan = $s->laporanpesertakegiatans->first();
                        $tahun = \Carbon\Carbon::parse($s->tanggalkeluarsertifikat_kegiatan)->year;

                        // Cek apakah peserta sudah upload laporan
                        $laporanpesertakegiatans = \App\Izin\Models\Izin_Laporanpesertakegiatans::where('pesertakegiatan_id', $p->id)
                        ->where('sertifikat_id', $p->sertifikat_id)
                        ->first();

                        $statuslaporan_pesertakegiatan = $laporanpesertakegiatans->statuslaporan_pesertakegiatan ?? null;
                        @endphp

                        <tr class="border-b text-center hover:bg-abuabuCerah/30 table-row">
                            <td class="py-3 px-4 text-left">{{ $p->nama_peserta }}</td>
                            <td class="py-3 px-4">{{ $p->nip_nik_peserta }}</td>
                            <td class="py-3 px-4">{{ $tahun }}</td>
                            <td class="py-3 px-4 text-left">{{ $s->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $p->sertifikats->inputusulankegiatans->subunitkerjas->singkatan ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $p->nomorsertifikatpeserta_kegiatan }}</td>
                            <td class="py-3 px-4">
                                @if(!$laporan)
                                <a href="{{ route('user.laporanpeserta.create', $s->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-orangeMuda text-coklat hover:bg-orangeMuda/60 transition">
                                    Upload
                                </a>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'pending')
                                <span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-unguMuda text-unguSedang hover:bg-unguSedang/60 transition">Pending</span>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'rejected')
                                <a href="{{ route('user.laporanpeserta.create', $s->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahBening text-merahCabai hover:bg-merahCabai/60 transition">
                                    Ditolak
                                </a>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'approved')
                                <span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauBening text-hijauTua hover:bg-hijauTua/60 transition">Disetujui</span>
                                @endif
                                {{--@if(!$statuslaporan_pesertakegiatan)
                            <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
                                class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-orangeMuda text-coklat hover:bg-orangeMuda/60 transition">
                                Upload
                                </a>

                                @elseif($statuslaporan_pesertakegiatan === 'pending')
                                <span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-unguMuda text-unguSedang hover:bg-unguSedang/60 transition">
                                    Pending
                                </span>

                                @elseif($statuslaporan_pesertakegiatan === 'rejected')
                                <a href="{{ route('user.laporanpeserta.create', $p->sertifikats->id ?? null) }}"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahBening text-merahCabai hover:bg-merahCabai/60 transition">
                                    Ditolak
                                </a>

                                @elseif($statuslaporan_pesertakegiatan === 'approved')
                                <span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauBening text-hijauTua hover:bg-hijauTua/60 transition">
                                    Disetujui
                                </span>
                                @endif--}}

                            </td>
                            <td class="py-3 px-4">
                                @if($laporan && $statuslaporan_pesertakegiatan === 'approved')
                                <a href="{{ route('user.sertifikat.download', [$p->sertifikat_id, $p->id]) }}"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauDaun text-white hover:bg-hijauDaun/60 transition">
                                    Download
                                </a>
                                @else
                                <button disabled
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-abuabuMuda text-black cursor-not-allowed">
                                    Download
                                </button>
                                @endif
                            </td>
                        </tr>
                        {{--@endif--}}
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-abuabuMuda">
                                Tidak ada data
                            </td>
                        </tr>
                        {{--@endforeach
                    @endforeach--}}
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Pagination --}}
            <div class="mt-4">
                {{ $sertifikats->appends(request()->query())->links() }}
            </div>

            <div id="emptyState" class="hidden text-center py-12 text-gray-500">
                Tidak ada data yang sesuai dengan pencarian
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) return;

            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    // 🔥 hapus parameter search dari URL
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');

                    // optional: hapus page juga biar balik ke halaman 1
                    url.searchParams.delete('page');

                    window.location.href = url.toString();
                }
            });
        });
    </script>

    {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>