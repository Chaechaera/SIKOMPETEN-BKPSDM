<!-- Dashboard Admin Page -->
<x-app-layout>
  <div class="space-y-4 px-6 py-4">

    {{-- Notifikasi Pengumuman Usulan Kegiatan Dari Superadmin --}}
    @if ($catatan_verifikasi_usulan->count())
    @foreach ($catatan_verifikasi_usulan as $catatan)
    <div class="p-4 mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
      <h3 class="font-semibold">📢 Catatan Review Usulan Kegiatan</h3>

      <p>
        <strong>
          {{ optional($catatan->usulankegiatans->inputusulankegiatans)->nama_kegiatan ?? '-' }}
        </strong>
        telah
        <span class="{{ $catatan->status_verifikasiusulankegiatan === 'accepted'
                    ? 'text-green-700'
                    : 'text-red-700' }}">
          {{ ucfirst($catatan->status_verifikasiusulankegiatan) }}
        </span>.
      </p>

      <p class="mt-2 italic">
        {{ $catatan->catatan_verifikasiusulankegiatan ?: 'Tidak ada catatan tambahan.' }}
      </p>

        <p class="text-sm text-gray-600 mt-1">
          Diverifikasi pada
          {{ \Carbon\Carbon::parse($catatan->tanggalverifikasi_inputusulankegiatan)->format('d/m/Y H:i') }}
        </p>
      </div>
      @endforeach
      @endif

    {{-- STATISTIK CARDS USULAN--}}
    <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
      <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">RANGKUMAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI</h1>

      <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-2 sm:p-3 rounded-xl bg-kuningBening shadow-sm">
          <h2 class="text-sm font-medium">Total Usulan yang Diajukan</h2>
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
          <h2 class="text-sm font-medium">Total Laporan yang Diajukan</h2>
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

      <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR SERTIFIKAT PESERTA KEGIATAN BARU</h1>

          <a href="{{ route('admin.usulankegiatan.create') }}"
            class="w-2/12 py-3 bg-orangeMuda text-white rounded-lg text-center font-semibold hover:bg-orangeMuda/80 transition">
            Lihat Semua Sertifikat
          </a>
        </div>

        <div class="space-y-4">

          @foreach ($sertifikatTerbaru as $sertifikat)

          <div class="bg-abuabuKoin rounded-2xl px-5 py-4 flex items-center">

            {{-- KOLOM KIRI --}}
            <div class="w-[50%]">
              <h5 class="font-bold text-base leading-tight">
                {{ $sertifikat->inputusulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
              </h5>

              <p class="font-normal text-xs mt-2">
                {{ $sertifikat->inputusulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }}
                <span class="mx-2">•</span>
                {{ \Carbon\Carbon::parse($sertifikat->tanggalkeluarsertifikat_kegiatan)->translatedFormat('d F Y') }}
              </p>
            </div>

            {{-- GARIS --}}
            <div class="w-0.5 h-14 bg-black mx-6"></div>

            {{-- KOLOM TENGAH --}}
            <div class="w-[35%]">
              <p class="font-bold text-sm">
                {{ $sertifikat->nomorsertifikat_kegiatan ?? '-' }}
              </p>
            </div>

            {{-- STATUS --}}
            <div class="w-[15%] flex justify-end">
              <span class="px-6 py-2 rounded-lg text-sm font-bold border bg-green-100 text-green-700">
                Sertifikat
              </span>
            </div>

          </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</x-app-layout>
