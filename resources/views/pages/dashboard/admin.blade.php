<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">
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

            {{-- Notifikasi Pengumuman Laporan Kegiatan DAri Superadmin --}}
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

            {{-- Header Dashboard --}}
            <h1 class="text-2xl font-bold mb-4">Dashboard Admin</h1>
            <p class="mb-6">Selamat datang, Admin!</p>

            {{-- Isi Konten --}}
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>