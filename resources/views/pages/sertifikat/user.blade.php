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
                        <option class="text-black" value="">Status Laporan</option>
                        <option class="text-black" value="belum_upload" {{ request('statuslaporan_pesertakegiatan') == 'belum_upload' ? 'selected' : '' }}>Belum Upload</option>
                        <option class="text-black" value="pending" {{ request('statuslaporan_pesertakegiatan') == 'pending' ? 'selected' : '' }}>Sedang Divalidasi</option>
                        <option class="text-black" value="approved" {{ request('statuslaporan_pesertakegiatan') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option class="text-black" value="rejected" {{ request('statuslaporan_pesertakegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>

            {{-- Tabel Sertifikat --}}
            <div class="bg-white rounded-xl overflow-hidden shadow">
                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr class="bg-abuabuMuda font-semibold border-b text-center">
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
                            <td class="py-3 px-4 text-left whitespace-nowrap">{{ $p->nama_peserta }}</td>
                            <td class="py-3 px-4">{{ $p->nip_nik_peserta }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $tahun }}</td>
                            <td class="py-3 px-4 font-semibold text-left">{{ $s->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $p->sertifikats->inputusulankegiatans->subunitkerjas->singkatan ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $p->nomorsertifikatpeserta_kegiatan }}</td>
                            <td class="py-3 px-4" x-data="{ openModal: false }">
                                @if(!$laporan)
                                <a href="{{ route('user.laporanpeserta.create', $s->id) }}"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-orangeMuda text-coklat hover:bg-orangeMuda/60 transition">
                                    Upload
                                </a>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'pending')
                                <span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-unguMuda text-unguSedang transition">Pending</span>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'revisi')
<span class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-orangeBening text-orange transition">Revisi</span>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'rejected')
                                <button @click="openModal = true"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahBening text-merahCabai hover:bg-merahCabai/50 transition x-data=" { openProgress: false }"">
                                    Ditolak
                                </button>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'approved')
                                <button @click="openModal = true"
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauBening text-hijauTua hover:bg-hijauTua/50 transition x-data=" { openProgress: false }"">
                                    Disetujui
                                </button>
                                @endif

                                <!-- Open Modal -->
                                <div x-show="openModal" x-cloak x-transition.opacity
                                    class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">

                                    <div @click.outside="openModal = false" x-transition.scale
                                        class="relative bg-white w-[540px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

                                        {{-- Close --}}
                                        <button @click="openModal = false"
                                            class="absolute top-3 right-3"><i data-lucide="x"></i></button>

                                        {{-- ISI MODAL KAMU --}}
                                        @if($laporan && $laporan->statuslaporan_pesertakegiatan === 'approved')

                                        <h2 class="font-semibold text-3xl">
                                            <span class="bg-primary-gradient bg-clip-text text-transparent leading-tight">Laporan Peserta</span>
                                            <span class="text-hijauDaun">Diterima</span>
                                        </h2>

                                        <p class="font-light text-lg mb-3 text-abuabuBesi">
                                            Berikut adalah catatan yang diberikan.
                                        </p>

                                        <div class="bg-gray-100 border border-gray-300 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                                            <p class="font-light text-sm text-justify text-hitamSedang">
                                                <b class="font-bold text-hijauDaun">Selamat!!</b>
                                                Laporan Anda untuk kegiatan
                                                <b class="font-bold">"{{ $s->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}"</b>
                                                telah dinyatakan sesuai dengan kriteria dan disetujui oleh BKPSDM Kota Surakarta. Kini Anda dapat mengunduh sertifikat digital sebagai bukti partisipasi kegiatan.
                                            </p>
                                            
                                            @if(!empty($laporan->catatanlaporan_pesertakegiatan))
                                            <p class="font-bold text-hijauDaun mt-3">
                                                Berikut ada catatan yang diberikan:
                                            </p>

                                            @php
                                            $catatan = $laporan->catatanlaporan_pesertakegiatan;
                                            @endphp

                                            @if(preg_match('/^\s*\d+\./m', $catatan))
                                            {{-- Kalau format list angka --}}
                                            <ol class="list-decimal ml-5 space-y-1 text-left">
                                                @foreach(preg_split('/\n/', $catatan) as $line)
                                                @if(trim($line))
                                                <li>{{ preg_replace('/^\d+\.\s*/', '', $line) }}</li>
                                                @endif
                                                @endforeach
                                            </ol>
                                            @else
                                            {{-- Kalau paragraf --}}
                                            <div class="whitespace-normal text-justify">
                                                {{ $catatan }}
                                            </div>
                                            @endif
                                            @endif
                                        </div>

                                        <div class="mt-3 flex flex-wrap justify-end">
                                            <a href="{{ route('user.sertifikat.download', [$p->sertifikat_id, $p->id]) }}"
                                                class="px-5 py-3 text-xs font-semibold rounded-lg bg-hijauDaun text-white hover:bg-hijauDaun/60 transition">
                                                Download Sertifikat Anda
                                            </a>
                                        </div>

                                        @elseif($laporan && $laporan->statuslaporan_pesertakegiatan === 'rejected')

                                        <h2 class="font-semibold text-3xl">
                                            <span class="bg-primary-gradient bg-clip-text text-transparent leading-tight">Laporan Peserta</span>
                                            <span class="text-merahCabai">Ditolak</span>
                                        </h2>

                                        <p class="font-light text-lg mb-3 text-abuabuBesi">
                                            Berikut adalah catatan yang diberikan.
                                        </p>

                                        <div class="bg-gray-100 border border-gray-300 rounded-xl p-4 text-sm text-gray-700 leading-relaxed">
                                            <p class="font-light text-sm text-justify text-hitamSedang">
                                                <b class="font-bold text-merahCabai">Maaf!!</b>
                                                Laporan Anda untuk kegiatan
                                                <b class="font-bold">"{{ $s->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}"</b>
                                                telah dinyatakan tidak sesuai dengan kriteria dan ditolak oleh BKPSDM Kota Surakarta.
                                            </p>

                                            <p class="font-bold text-merahCabai mt-3">
                                                Berikut adalah catatan yang diberikan:
                                            </p>

                                            @php
                                            $catatan = $laporan->catatanlaporan_pesertakegiatan;
                                            @endphp

                                            @if(preg_match('/^\s*\d+\./m', $catatan))
                                            {{-- Kalau format list angka --}}
                                            <ol class="list-decimal ml-5 space-y-1 text-left">
                                                @foreach(preg_split('/\n/', $catatan) as $line)
                                                @if(trim($line))
                                                <li>{{ preg_replace('/^\d+\.\s*/', '', $line) }}</li>
                                                @endif
                                                @endforeach
                                            </ol>
                                            @else
                                            {{-- Kalau paragraf --}}
                                            <div class="whitespace-normal text-justify">
                                                {{ $catatan }}
                                            </div>
                                            @endif
                                        </div>

                                        <div class="mt-5 flex flex-wrap justify-end">
                                            <a href="{{ route('user.laporanpeserta.create', $s->id) }}"
                                                class="px-5 py-3 text-xs font-semibold rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahBata/50 transition">
                                                Reupload Laporan Anda
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
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
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-abuabuMuda">
                                Tidak ada data
                            </td>
                        </tr>
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