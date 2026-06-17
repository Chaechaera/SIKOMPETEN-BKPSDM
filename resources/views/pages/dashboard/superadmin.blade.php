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

                <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Laporan Masuk</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">12</p>
                    <p class="text-xs text-blue-600">3 menunggu verifikasi</p>
                </div>
            </div>

            {{-- Content Box --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-[#2B3674]">Menu Utama</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Daftar Usulan Masuk</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Verifikasi usulan kegiatan dari OPD
                    </p>
                </div>

                <div class="bg-purple-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Daftar Laporan Masuk</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Verifikasi laporan hasil kegiatan
                    </p>
                </div>

                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Buat Surat Balasan</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Generate surat balasan untuk OPD
                    </p>
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

        {{-- Content --}}
        <div class="px-6 py-4 space-y-3">
            @php
                $laporans = [
                    ['id'=>1,'title'=>'Laporan Pelatihan Leadership','opd'=>'Dinas Pendidikan','status'=>'pending','date'=>'10 Nov 2025'],
                    ['id'=>2,'title'=>'Laporan Workshop Digital Marketing','opd'=>'Dinas Pariwisata','status'=>'approved','date'=>'9 Nov 2025'],
                    ['id'=>3,'title'=>'Laporan Bimtek Pengadaan','opd'=>'BPKAD','status'=>'approved','date'=>'8 Nov 2025'],
                    ['id'=>4,'title'=>'Laporan Pelatihan IT','opd'=>'Diskominfo','status'=>'pending','date'=>'7 Nov 2025'],
                    ['id'=>5,'title'=>'Laporan Sosialisasi E-Gov','opd'=>'Sekretariat Daerah','status'=>'approved','date'=>'6 Nov 2025'],
                ];
            @endphp

            @foreach ($laporans as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">{{ $item['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $item['opd'] }} • {{ $item['date'] }}</p>
                    </div>
                    <span class="px-2 py-1 rounded text-xs 
                        @if($item['status'] === 'approved') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 border border-yellow-300 @endif">
                        {{ $item['status'] === 'approved' ? 'Disetujui' : 'Pending' }}
                    </span>
                </div>
            @endforeach

            <a href="/laporan-masuk" class="w-full mt-4 text-blue-600 text-left hover:underline" onclick="handleViewReports()">
                Lihat Semua Laporan →
            </a>
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

</div>
            {{-- INFO ALERT --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
                <img src="{{ asset('images/Info.png') }}" class="h-5 w-5">
                <div class="text-medium text-blue-800">
                    <p class="font-bold">Informasi</p>
                    <p class="mt-1">
                        Terdapat 8 usulan dan 3 laporan yang menunggu verifikasi.
                        Mohon segera ditindaklanjuti.
                    </p>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>