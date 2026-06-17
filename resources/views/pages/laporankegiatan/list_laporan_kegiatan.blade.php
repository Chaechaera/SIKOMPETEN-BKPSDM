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
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar kegiatan yang saat ini telah proses pelaksanaan dan perlu menyertakan laporan hasil kegiatan pelaksanaan.
                </p>
            </div>

            <!-- Cards -->
      <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">

@foreach($counts as $status => $value)
@php
    $bg = $colors[$status] ?? 'bg-gray-100';
@endphp

<a href="{{ request()->fullUrlWithQuery(['status' => $status]) }}"
   class="block p-5 sm:p-6 rounded-xl {{ $bg }} shadow-sm hover:scale-[1.02] transition">
    <h2 class="text-gray-700 text-sm font-medium">
        {{ str_replace('_', ' ', ucfirst($status)) }}
    </h2>
    <p class="text-2xl font-bold text-[#2B3674] mt-2">
        {{ $value }}
    </p>
</a>

@endforeach

</section>

            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow p-6">
                 <!-- FILTER ATAS -->
    <div class="flex flex-col md:flex-row gap-4 mb-4">
               {{-- Search --}}
<form method="GET" class="flex-1 relative">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Cari nama kegiatan, tanggal pelaksanaan..."
        onkeyup="this.form.submit()"
        class="w-full pl-10 pr-4 py-2 border rounded-lg" />

    <svg xmlns="http://www.w3.org/2000/svg"
        class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
    </svg>
</form>
        <form method="GET" class="flex gap-3 justify-end flex-wrap">

    <!-- FILTER TAHUN -->
    <select name="tahun" onchange="this.form.submit()"
        class="border rounded-lg px-4 py-2 text-sm min-w-[140px] whitespace-nowrap">
        <option value="">Semua Tahun</option>
        @for ($year = 2021; $year <= 2026; $year++)
            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor
    </select>

    <!-- FILTER STATUS -->
    <select name="status" onchange="this.form.submit()"
        class="border rounded-lg px-4 py-2 text-sm min-w-[140px] whitespace-nowrap">

        <option value="">Semua Status</option>

        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
            pending
        </option>

        <option value="need_review" {{ request('status') == 'need_review' ? 'selected' : '' }}>
            need review
        </option>

        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
            draft
        </option>

        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
            accepted
        </option>

        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
            rejected
        </option>

        <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>
            finish
        </option>

    </select>

</form>

<div x-data="{ openSort: false }" class="relative">
    
    <!-- ICON SORT -->
    <button @click="openSort = !openSort"
        class="border rounded-lg px-3 py-2 text-sm bg-white hover:bg-gray-100 flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8"
    fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 4h13M3 8h9m-9 4h6m-6 4h3" />
</svg>
    </button>

    <!-- DROPDOWN -->
    <div x-show="openSort" @click.outside="openSort = false"
        x-transition
        class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow z-50">

        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}"
            class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request('sort', 'desc') == 'desc' ? 'bg-gray-100 font-semibold' : '' }}">
            Terbaru
        </a>

        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}"
            class="block px-4 py-2 text-sm hover:bg-gray-100 {{ request('sort') == 'asc' ? 'bg-gray-100 font-semibold' : '' }}">
            Terlama
        </a>

    </div>
</div>
    </div>
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-72">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Laporan</th>
                                <th class="py-3 px-4 w-48">Update Progress</th>

                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usulankegiatans as $index => $u)
                            <tr class="border-b hover:bg-gray-50">

                                <!-- Nomor Otomatis -->
                                <td class="py-3 px-4 text-center">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">
                                    <button
                                        type="button"
                                        @click="$dispatch('show-catatan-' + {{ $index }})"
                                        class="hover:underline text-left">
                                        {{ $u->inputusulankegiatans->nama_kegiatan }}
                                    </button>
                                </td>

                                <!-- Tanggal Pelaksanaan Kegiatan -->
                                <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                    {{ $u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan && $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                                </td>

                                <!-- Status Laporan Kegiatan -->
                                <td class="py-3 px-4 text-center">
                                    <span class="{{ $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui_class }}">
                                        {{ str_replace('_', ' ', $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui) }}
                                    </span>
                                </td>


                                <!-- Update Progress -->
                                <td class="py-3 px-4 text-center"
                                    x-data="{ openModal: false }">
                                    <div class="flex justify-center gap-2">
                                        @php
    $laporan = $u->inputlaporankegiatans?->laporankegiatans;
@endphp

{{-- ===================== CETAK DOKUMEN ===================== --}}
@if (
    $laporan &&
    in_array($laporan->status_laporan_ui, ['draft', 'rejected']) &&
    is_null($laporan->cetakusulankegiatans)
)
    <a href="{{ route('admin.laporankegiatan.cetak', $u->id) }}"
       class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#4361EE] text-white hover:bg-[#3651d4] transition text-center block">
        Cetak
    </a>
@else
    <button
        class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
        Cetak
    </button>
@endif

                                        {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                        @if($u->isPendingLaporan())
                                        <a href="{{ route('admin.laporankegiatan.kirim.form', $u->id) }}"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                                            Kirim
                                        </a>
                                        @else
                                        <button class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Kirim</button>
                                        @endif
                                        
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
            📌 Update & Aksi
        </h2>

        <p class="text-sm text-gray-500 mb-5">
            Pilih menu yang ingin dilakukan
        </p>

        {{-- CONTENT --}}
        <div class="space-y-3 text-sm">

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
           @php
$laporanId = $u->inputlaporankegiatans?->laporankegiatans?->id;

$balasan = \App\Izin\Models\Izin_Balasanlaporankegiatans::where(
    'inputlaporankegiatan_id',
    $laporanId
)->first();
@endphp

@if($balasan)
@php
$laporanId = $u->inputlaporankegiatans?->laporankegiatans?->id;

$balasan = \App\Izin\Models\Izin_Balasanlaporankegiatans::where(
    'inputlaporankegiatan_id',
    $laporanId
)->first();
@endphp
<a href="{{ route('admin.balasanlaporankegiatan.download', $balasan->id) }}"
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
    $laporan = $u->inputlaporankegiatans?->laporankegiatans;
    $sertifikat = $laporan?->sertifikats;
@endphp

@if($laporan?->status_laporan_ui === 'finish' && $sertifikat)
    <a href="{{ route('admin.sertifikat.download', $laporan->id) }}"
       target="_blank"
       class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#defff8] text-[#136769] font-medium hover:brightness-95 transition">
        Download Sertifikat
    </a>
@else
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
        Sertifikat belum tersedia
    </span>
@endif

{{-- ================= AKSI EDIT & HAPUS ================= --}}
    @if($u->inputlaporankegiatans)
        <div class="pt-2 border-t">
            <p class="text-sm text-gray-500 mb-5">
            Pilih aksi yang ingin dilakukan
        </p>
            <div class="flex items-center justify-center gap-4">

                {{-- EDIT --}}
                @if($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                    <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                       class="flex items-center justify-center px-4 py-2 rounded-lg bg-yellow-200 text-yellow-800 font-medium hover:brightness-95 transition">
                        Edit
                    </a>
                @else
                    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">Edit</span>
                @endif

                <span class="text-gray-300">|</span>

    {{-- ARCHIVE --}}
@if(
    $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui === 'finish'
    && !$u->inputlaporankegiatans?->laporankegiatans?->is_archived
)
    <form action="{{ route('admin.laporankegiatan.archive', $u->inputlaporankegiatans->id) }}"
          method="POST"
          onsubmit="return confirm('Yakin arsipkan laporan ini?')">
        @csrf

        <button type="submit"
                class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#5B2C89] text-white font-medium hover:bg-[#7a3db3] transition">
            Arsipkan
        </button>
    </form>

@elseif(
    $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui !== 'finish'
)
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
        Arsipkan
    </span>

@else
    <span class="flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
        Arsipkan
    </span>
@endif
            </div>
        </div>
    @endif
        </div>
    </div>
</div>
                                </td>
                            </tr>

{{-- ================= CATATAN REVIEW ================= --}}
@php
    $verif = $u->inputlaporankegiatans?->laporankegiatans?->verifikasilaporankegiatanterakhir;
    $catatan = $verif?->catatan_verifikasilaporankegiatan;
@endphp

@if(!empty($catatan))

<tr
    x-data="{
        key: 'catatan-{{ $u->id }}',
        showCatatan: true,

        init() {
            this.showCatatan = localStorage.getItem(this.key) !== 'closed';

            window.addEventListener('show-catatan-{{ $index }}', () => {
                this.showCatatan = true;
                localStorage.removeItem(this.key);
            });
        },

        closeCatatan() {
            this.showCatatan = false;
            localStorage.setItem(this.key,'closed');
        }
    }"

    x-init="init()"

    x-show="showCatatan"
    x-transition
>
    <td colspan="6" class="bg-blue-50 px-6 py-3 border-b">

        <div class="flex justify-between items-start bg-blue-100 border-l-4 border-blue-500 rounded-lg p-4">

            <div>

                <div class="font-semibold text-blue-800">
                    📢 Catatan Review Laporan Kegiatan
                </div>

                <div class="mt-1 text-gray-700 text-sm">
                    {{ $verif->status_verifikasilaporankegiatan }}
                </div>

                <div class="mt-1 text-gray-700 text-sm">
                    {{ $catatan }}
                </div>

                <div class="mt-2 text-xs text-gray-500">
                    {{ \Carbon\Carbon::parse($verif->tanggalverifikasi_inputlaporankegiatan)->format('d/m/Y') }}
                </div>

            </div>

            <button
                type="button"
                @click="closeCatatan()"
                class="ml-4 text-gray-500 hover:text-red-600 font-bold text-lg">
                ✕
            </button>

        </div>

    </td>
</tr>

@endif
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">
                                    Tidak ada data laporan kegiatan.
                                </td>
                            </tr>
                            
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-3 text-sm text-gray-500">
                    <span>
                        {{ $usulankegiatans->firstItem() }}–{{ $usulankegiatans->lastItem() }}
                        dari {{ $usulankegiatans->total() }} data
                    </span>
                    <div>
                        {{ $usulankegiatans->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>


</x-app-layout>

