<x-app-layout>
    {{-- Alpine JS --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            <div class="min-h-screen bg-gray-50 py-8">
                <div class="max-w-7xl mx-auto px-4 space-y-6">

                    {{-- Header --}}
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <h2 class="text-2xl font-semibold text-[#2B3674]">Daftar Sertifikat</h2>
                            <p class="text-sm text-gray-500">
                                Upload dan Kelola Template Sertifikat Kegiatan Pengembangan Kompetensi
                            </p>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="bg-white rounded-xl shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-medium text-gray-900">Daftar Usulan (6)</h3>
                        </div>

                        <div class="border rounded-lg overflow-hidden">
                            <table class="w-full text-sm table-fixed">
                                <thead>
                                    <tr class="bg-gray-50 border-b text-center text-gray-600">
                                        <th class="py-3 px-4 w-14">No</th>
                                        <th class="py-3 px-4 w-72">Nama Kegiatan</th>
                                        <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                        <th class="py-3 px-4 w-32">Jumlah Peserta</th>
                                        <th class="py-3 px-4 w-32">Sertifikat Peserta (ZIP)</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($usulankegiatans as $index => $u)
                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="py-3 px-4 text-center">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                                        <!-- Nama Kegiatan -->
                                        <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                                        <!-- Tanggal Pelaksanaan Kegiatan -->
                                        <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                            {{$u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan && $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}
                                        </td>

                                        <!-- Jumlah Peserta -->
                                        <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                            {{ $u->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->pesertakegiatans?->count() ?? 0 }} Peserta
                                        </td>

                                        <!-- Sertifikat -->
                                        <td class="py-3 px-4 text-center">
                                            @php
    $laporanId = $u->inputlaporankegiatans?->laporankegiatans?->id;
@endphp

@if($laporanId)
    <a href="{{ route('admin.sertifikat.download', $laporanId) }}"
        target="_blank"
        class="block px-3 py-2 text-xs rounded-lg bg-[#defff8] text-[#136769] font-medium hover:bg-[#c0f0e8]">
        Download Sertifikat
    </a>
@else
    <span class="block px-3 py-2 text-xs rounded-lg bg-gray-200 text-gray-400">
        Tidak tersedia
    </span>
@endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
</x-app-layout>