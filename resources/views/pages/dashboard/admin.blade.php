<!-- Dashboard Admin Page -->
<x-app-layout>
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}} 
        @include('pages.sidebar.admin')

        {{-- Konten Utama --}}
        <main class="flex-1 p-6">

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

            {{-- Notifikasi Pengumuman Laporan Kegiatan Dari Superadmin --}}
            @if ($catatan_verifikasi_laporan->count())
            @foreach ($catatan_verifikasi_laporan as $catatan)
            <div class="p-4 mb-4 bg-blue-100 border-l-4 border-blue-500 text-blue-800 rounded">
                <h3 class="font-semibold">📢 Catatan Review Laporan Kegiatan</h3>

                <p>
                    <strong>
                        {{ optional($catatan->laporankegiatans->inputlaporankegiatans->inputusulankegiatans)->nama_kegiatan ?? '-' }}
                    </strong>
                    telah
                    <span class="{{ $catatan->status_verifikasilaporankegiatan === 'accepted'
                    ? 'text-green-700'
                    : 'text-red-700' }}">
                        {{ ucfirst($catatan->status_verifikasilaporankegiatan) }}
                    </span>.
                </p>

                <p class="mt-2 italic">
                    {{ $catatan->catatan_verifikasilaporankegiatan ?: 'Tidak ada catatan tambahan.' }}
                </p>

                <p class="text-sm text-gray-600 mt-1">
                    Diverifikasi pada
                    {{ \Carbon\Carbon::parse($catatan->tanggalverifikasi_inputlaporankegiatan)->format('d/m/Y H:i') }}
                </p>
            </div>
            @endforeach
            @endif

            {{-- Dashboard Title --}}

    <!-- Header -->
<header class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
  <div>
    <h1 class="text-2xl font-semibold text-[#2B3674]">Hallo, Admin!</h1>
    <p class="text-sm text-gray-500">Hope you have a good day</p>
  </div>

  <div class="flex items-center gap-4">
    <!-- Ikon Notifikasi -->
    <img 
      src="{{ asset('images/notif.png') }}" 
      alt="Notifikasi"
      class="w-6 h-6 cursor-pointer hover:opacity-80 transition"
    >

    <!-- Ikon Pesan -->
    <img 
      src="{{ asset('images/pesan.png') }}" 
      alt="Pesan" 
      class="w-5 h-5 cursor-pointer hover:opacity-80 transition"
    >

    <!-- Profil Dropdown -->
<div x-data="{ open: false }" class="relative">
  <!-- Trigger -->
  <div @click="open = !open" class="flex items-center gap-2 cursor-pointer select-none">
    <img src="{{ asset('images/bkpsdm.png') }}" alt="Profile" class="w-8 h-8 rounded-full">
    <span class="text-[#2B3674] font-medium text-sm sm:text-base">{{ Auth::user()->name }}</span>
    <i class="fa-solid fa-chevron-down text-gray-400 text-sm transition-transform duration-200"
       :class="{ 'rotate-180': open }"></i>
  </div>

  <!-- Dropdown Menu -->
  <div x-show="open" 
       @click.outside="open = false"
       x-transition
       class="absolute right-0 mt-2 w-40 bg-white border border-gray-100 rounded-lg shadow-lg py-2 z-50">
    <a href="{{ route('profile.edit') }}" 
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
      Profile
    </a>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" 
              class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        Log Out
      </button>
    </form>
  </div>
</div>

</header>
            <!-- Removed duplicate title -->
            <p class="mb-6">Selamat datang, Admin!</p>

<!-- Cards -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
  <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Total Usulan</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">5</p>
    <p class="text-xs text-[#E74C3C] mt-1">+2 dari bulan lalu</p>
  </div>

  <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Disetujui</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
    <p class="text-xs text-[#3498DB] mt-1">60% approval rate</p>
  </div>

  <div class="p-5 sm:p-6 rounded-xl bg-[#F2E9FF] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Sertifikat</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">2</p>
    <p class="text-xs text-[#9B59B6] mt-1">Sertifikat Diterbitkan</p>
  </div>
</section>

            {{-- Content Box --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-[#2B3674]">Informasi Terbaru</h2>
                <p class="text-gray-600">Belum ada informasi terbaru.</p>
            </div>
        </main>
    </div>
</x-app-layout>