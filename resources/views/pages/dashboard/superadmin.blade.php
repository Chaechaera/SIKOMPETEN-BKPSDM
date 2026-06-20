<!-- Dashboard Super Admin Page -->
<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- STATISTIK CARDS USULAN--}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">RANGKUMAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI</h1>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-2 sm:p-3 rounded-xl bg-kuningBening shadow-sm">
                    <h2 class="text-sm font-medium">Total Usulan yang Masuk</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $totalUsulan }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $usulanMingguIni }} minggu ini</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-unguBening shadow-sm">
                    <h2 class="text-sm font-medium">Usulan yang Menunggu Verifikasi</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $usulanPending }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $usulanMingguIni }} minggu ini</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-hijauMint shadow-sm">
                    <h2 class="text-sm font-medium">Usulan yang Disetujui</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $usulanDisetujui }}</p>
                    <p class="text-xs text-hijauDaun mt-2">{{ $persenUsulanDisetujui }}% dari total</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-merahBening shadow-sm">
                    <h2 class="text-sm font-medium">Usulan yang Ditolak</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $usulanDitolak }}</p>
                    <p class="text-xs text-merahCabai mt-2">{{ $persenUsulanDitolak }}% dari total</p>
                </div>
            </div>
        </div>

        {{-- DATA USULAN TERBARU --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR USULAN KEGIATAN BARU</h1>
                <a href="{{ route('admin.usulankegiatan.create') }}"
                    class="w-2/12 py-3 bg-orangeMuda text-white rounded-lg text-center font-semibold hover:bg-orangeMuda/80 transition">
                    Lihat Semua Usulan
                </a>
            </div>

            <div class="space-y-4">

                @foreach ($usulanTerbaru as $usulan)

                <div class="bg-abuabuKoin rounded-2xl px-5 py-4 flex items-center">

                    {{-- KOLOM KIRI --}}
                    <div class="w-[50%]">
                        <h5 class="font-bold text-base leading-tight">
                            {{ $usulan->inputusulankegiatans->nama_kegiatan ?? '-' }}
                        </h5>

                        <p class="font-normal text-xs mt-2">
                            {{ $usulan->subunitkerjas->sub_unitkerja ?? '-' }}
                            <span class="mx-2">•</span>
                            {{ \Carbon\Carbon::parse($usulan->tanggalmulai_kegiatan)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    {{-- GARIS --}}
                    <div class="w-0.5 h-14 bg-black mx-6"></div>

                    {{-- KOLOM TENGAH --}}
                    <div class="w-[35%]">
                        <p class="font-bold text-sm">
                            {{ $usulan->lokasi_kegiatan }}
                        </p>
                    </div>

                    {{-- STATUS --}}
                    <div class="w-[15%] flex justify-end">
                        <span class="px-6 py-2 rounded-lg text-sm font-bold border {{ $usulan->status_ui_class }}">
                            {{ ucfirst(str_replace('_', ' ', $usulan->status_ui)) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- STATISTIK CARDS LAPORAN --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">RANGKUMAN LAPORAN KEGIATAN PENGEMBANGAN KOMPETENSI</h1>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-2 sm:p-3 rounded-xl bg-kuningBening shadow-sm">
                    <h2 class="text-sm font-medium">Total Laporan yang Masuk</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanMasuk }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $laporanMingguIni }} minggu ini</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-unguBening shadow-sm">
                    <h2 class="text-sm font-medium">Laporan yang Menunggu Verifikasi</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanPending }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $laporanMingguIni }} minggu ini</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-hijauMint shadow-sm">
                    <h2 class="text-sm font-medium">Laporan yang Disetujui</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanDisetujui }}</p>
                    <p class="text-xs text-hijauDaun mt-2">{{ $persenLaporanDisetujui }}% dari total</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-merahBening shadow-sm">
                    <h2 class="text-sm font-medium">Laporan yang Ditolak</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanDitolak }}</p>
                    <p class="text-xs text-merahCabai mt-2">{{ $persenLaporanDitolak }}% dari total</p>
                </div>
            </div>
        </div>

        {{-- DATA LAPORAN TERBARU --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN KEGIATAN BARU</h1>

                <a href="{{ route('admin.usulankegiatan.create') }}"
                    class="w-2/12 py-3 bg-orangeMuda text-white rounded-lg text-center font-semibold hover:bg-orangeMuda/80 transition">
                    Lihat Semua Laporan
                </a>
            </div>

            <div class="space-y-4">

                @foreach ($laporanTerbaru as $laporan)

                <div class="bg-abuabuKoin rounded-2xl px-5 py-4 flex items-center">

                    {{-- KOLOM KIRI --}}
                    <div class="w-[50%]">
                        <h5 class="font-bold text-base leading-tight">
                            {{ $laporan->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                        </h5>

                        <p class="font-normal text-xs mt-2">
                            {{ $laporan->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }}
                            <span class="mx-2">•</span>
                            {{ \Carbon\Carbon::parse($laporan->tanggalmulai_kegiatan)->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    {{-- GARIS --}}
                    <div class="w-0.5 h-14 bg-black mx-6"></div>

                    {{-- KOLOM TENGAH --}}
                    <div class="w-[35%]">
                        <p class="font-bold text-sm">
                            {{ $laporan->lokasi_kegiatan }}
                        </p>
                    </div>

                    {{-- STATUS --}}
                    <div class="w-[15%] flex justify-end">
                        <span class="px-6 py-2 rounded-lg text-sm font-bold border {{ $laporan->status_ui_class }}">
                            {{ ucfirst(str_replace('_', ' ', $laporan->status_ui)) }}
                        </span>
                    </div>

                </div>
                @endforeach
            </div>
        </div>

        {{-- STATISTIK CARDS SERTIFIKAT --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">RANGKUMAN LAPORAN DAN SERTIFIKAT PESERTA KEGIATAN</h1>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-2 sm:p-3 rounded-xl bg-kuningBening shadow-sm">
                    <h2 class="text-sm font-medium">Total Laporan Peserta yang Masuk</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $totalLaporanPeserta }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $laporanPesertaMingguIni }} minggu ini</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-hijauMint shadow-sm">
                    <h2 class="text-sm font-medium">Laporan Peserta yang Disetujui</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanPesertaDisetujui }}</p>
                    <p class="text-xs text-hijauDaun mt-2">{{ $persenLaporanPesertaDisetujui }}% dari total</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-merahBening shadow-sm">
                    <h2 class="text-sm font-medium">Laporan Peserta yang Ditolak</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $laporanPesertaDitolak }}</p>
                    <p class="text-xs text-merahCabai mt-2">{{ $persenLaporanPesertaDitolak }}% dari total</p>
                </div>

                <div class="p-2 sm:p-3 rounded-xl bg-unguBening shadow-sm">
                    <h2 class="text-sm font-medium">Total Sertifikat Peserta</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-biruMariana mt-2">{{ $totalSertifikatPeserta }}</p>
                    <p class="text-xs text-merahBata mt-2">+{{ $sertifikatMingguIni }} minggu ini</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>