<!-- Dashboard Admin Page -->
<x-app-layout>
  <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

    {{-- Sidebar --}}
    @php
    $activeRole = session('active_role', auth()->user()->role);
@endphp

@if ($activeRole === 'superadmin')
    @include('pages.sidebar.superadmin')
@else
    @include('pages.sidebar.admin')
@endif

    {{-- Main Content --}}
    <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

      {{-- Header --}}
      @include('layouts.navigation')

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