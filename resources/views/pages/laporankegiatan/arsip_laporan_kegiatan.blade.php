<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            <!-- JUDUL -->
            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR ARSIP LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar kegiatan yang saat ini telah diarsipkan.
                </p>
            </div>

            <!-- TABLE -->
<div class="bg-white rounded-xl shadow p-6">

    <!-- FILTER ATAS -->
    <form method="GET" class="flex flex-col md:flex-row gap-4 mb-4 items-center">

        {{-- SEARCH --}}
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari..."
               class="flex-1 border rounded-lg px-4 py-2"
               onkeydown="if(event.key==='Enter'){this.form.submit()}" />

        {{-- TAHUN --}}
        <select name="tahun"
                onchange="this.form.submit()"
                class="border rounded-lg px-4 py-2 min-w-[140px]">
            <option value="">Semua Tahun</option>
            @for($y = 2021; $y <= 2026; $y++)
                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                    {{ $y }}
                </option>
            @endfor
        </select>

        {{-- SORT DROPDOWN --}}
        <div x-data="{ openSort: false }" class="relative">

            <!-- ICON SORT -->
            <button type="button"
                    @click="openSort = !openSort"
                    class="border rounded-lg px-3 py-2 bg-white hover:bg-gray-100 flex items-center gap-1">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 4h13M3 8h9m-9 4h6m-6 4h3" />
                </svg>

            </button>

            <!-- DROPDOWN -->
            <div x-show="openSort"
                 x-transition
                 @click.outside="openSort = false"
                 class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow z-50">

                <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request('sort','desc')=='desc'?'bg-gray-100 font-semibold':'' }}">
                    Terbaru
                </a>

                <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
                   class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request('sort')=='asc'?'bg-gray-100 font-semibold':'' }}">
                    Terlama
                </a>

            </div>
        </div>

    </form>

               <div class="border rounded-lg overflow-hidden">
    <table class="w-full table-fixed text-sm">
        <thead>
    <tr class="bg-gray-50 border-b text-gray-600">
        <th class="py-3 px-4 w-16 text-center">No</th>
        <th class="py-3 px-4 text-left">Nama Kegiatan</th>
        <th class="py-3 px-4 text-left">Lokasi Kegiatan</th>
        <th class="py-3 px-4 text-center">Tanggal Pelaksanaan</th>
        <th class="py-3 px-4 text-center">Aksi</th>
    </tr>
</thead>

        <tbody>
@forelse ($usulankegiatans as $index => $u)
<tr class="border-b hover:bg-gray-50 " x-data="{ openModal:false }">

    <td class="py-4 px-4 text-center">
        {{ $usulankegiatans->firstItem() + $index }}
    </td>

    <td class="py-4 px-4 font-medium text-gray-800">
        {{ $u->inputusulankegiatans->nama_kegiatan }}
    </td>

    <td class="py-4 px-4 text-gray-600">
        {{ $u->inputlaporankegiatans?->laporankegiatans?->lokasi_kegiatan ?? '-' }}
    </td>

    <td class="py-4 px-4 text-center text-gray-600 whitespace-nowrap">
        {{
            $u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan
            ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d/m/Y')
            : '-'
        }}
        -
        {{
            $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
            ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d/m/Y')
            : '-'
        }}
    </td>

    <td class="py-4 px-4 text-center">
        {{-- BUTTON UPDATE --}}
<button type="button"
    @click="openModal = true"
    class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
    Update
</button>

{{-- MODAL --}}
<div x-show="openModal"
     x-cloak
     x-transition.opacity
     class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

    <div @click.outside="openModal = false"
         x-transition.scale
         class="relative bg-white w-[440px] max-w-full rounded-2xl shadow-2xl p-6">

        {{-- CLOSE --}}
        <button type="button"
            @click="openModal = false"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">
            ✖
        </button>

        {{-- TITLE --}}
        <h2 class="text-lg font-semibold text-gray-800 mb-1">
            Update & Aksi
        </h2>

        <p class="text-sm text-gray-500 mb-5">
            Pilih menu yang ingin dilakukan
        </p>

        {{-- CONTENT --}}
        <div class="flex flex-col space-y-3 font-bold">

            {{-- UPDATE --}}
            @if($u->status_ui === 'in_progress')
                <a href="{{ route('admin.laporankegiatan.create', $u->id) }}"
                   class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#e0f2fe] text-[#0369a1] font-medium hover:brightness-95 transition">
                    Update Laporan
                </a>
            @else
                <div class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
                    Update Laporan
                </div>
            @endif

            {{-- SURAT & LAPORAN --}}
            @if($u->inputlaporankegiatans?->laporankegiatans)
                <a href="{{ route('admin.laporankegiatan.download', $u->id) }}"
                   target="_blank"
                   class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#e0fbfc] text-[#0077b6] font-medium hover:brightness-95 transition">
                    Lihat Surat & Laporan Hasil
                </a>
            @else
                <div class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
                    Lihat Surat & Laporan Hasil
                </div>
            @endif

            {{-- BALASAN --}}
            @if($u->inputlaporankegiatans?->laporankegiatans?->balasanlaporankegiatans ?? false)
                <a href="{{ route('admin.balasanlaporankegiatan.download', $u->id) }}"
                   target="_blank"
                   class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#ffe5ec] text-[#d00000] font-medium hover:brightness-95 transition">
                    Lihat Surat Balasan
                </a>
            @else
                <div class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
                    Lihat Surat Balasan
                </div>
            @endif

            {{-- SERTIFIKAT --}}
                                            @php
    $laporanId = $u->inputlaporankegiatans?->laporankegiatans?->id;
@endphp

@if($laporanId)
    <a href="{{ route('admin.sertifikat.download', $laporanId) }}"
        target="_blank"
       class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#defff8] text-[#136769] font-medium hover:brightness-95 transition">
                    Download Sertifikat

    </a>
@else
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
                    Sertifikat belum tersedia

    </span>
@endif
        </div>

        <p class="text-sm text-gray-500 my-6">
                                                    Pilih aksi yang ingin dilakukan:
                                                    </p>

                                                    <div class="flex flex-col space-y-3 font-bold">


{{-- RESTORE --}}
@if($u->inputlaporankegiatans?->laporankegiatans?->is_archived)
    <form action="{{ route('admin.laporankegiatan.unarchive', $u->inputlaporankegiatans->id) }}"
          method="POST"
          onsubmit="return confirm('Pulihkan laporan ini dari arsip?')">
        @csrf

        <button type="submit"
                class="block w-full px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700">
            Pulihkan
        </button>
    </form>

@elseif(
    $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui !== 'finish'
)
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
        Pulihkan
    </span>

@else
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
        Pulihkan
    </span>
@endif

            </div>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-gray-500 py-4">
        Tidak ada data arsip.
    </td>
</tr>
@endforelse
</tbody>
    </table>
</div>
                {{-- Footer Pagination --}}
                <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-3 text-sm text-gray-500">
                    <span>Total {{ $usulankegiatans->total() }} arsip
                    <div>
                        {{ $usulankegiatans->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</x-app-layout>

