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
      <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

  <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Total Laporan</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">
      {{ $total }}
    </p>
  </div>

  <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Disetujui</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">
      {{ $disetujui }}
    </p>
  </div>

  <div class="p-5 sm:p-6 rounded-xl bg-[#F2E9FF] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</h2>
    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">
      {{ $menunggu }}
    </p>
  </div>

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

        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
            completed
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
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-72">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Laporan</th>
                                <th class="py-3 px-4 w-48">Update Progress</th>
                                <th class="py-3 px-4 w-36">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usulankegiatans as $index => $u)
                            <tr class="border-b hover:bg-gray-50">

                                <!-- Nomor Otomatis -->
                                <td class="py-3 px-4 text-center">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

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
                                <td class="py-3 px-4 text-center" x-data="{ openProgress: false }">
                                    <div class="flex justify-center gap-2">
                                        {{-- ===================== CETAK DOKUMEN ===================== --}}
                                        @if (
                                        isset($u->inputlaporankegiatans) &&
                                        isset($u->inputlaporankegiatans->laporankegiatans) &&
                                        in_array($u->inputlaporankegiatans->laporankegiatans->status_laporan_ui, ['completed', 'rejected']) &&
                                        is_null($u->inputlaporankegiatans->laporankegiatans->cetakusulankegiatans))
                                        <button onclick="openCetakModal('{{ $u->id }}', 'laporankegiatans')"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#4361EE] text-white hover:bg-[#3651d4] transition">
                                            Cetak
                                        </button>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                                            Cetak
                                        </button>
                                        @endif

                                        {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                        @if($u->isPendingLaporan())
                                        <a href="{{ route('admin.laporankegiatan.kirim', $u->id) }}"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                                            Kirim
                                        </a>
                                        @else
                                        <button class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Kirim</button>
                                        @endif

                                        {{-- ===================== UPDATE PROGRESS ===================== --}}
                                        <button type="button" @click="openProgress = true"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
                                            Update
                                        </button>


                                        <!-- MODAL DETAIL -->
                                        <div x-show="openProgress" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                            <div @click.outside="openProgress = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-gray-100">

                                                {{-- Button Close --}}
                                                <button type="button" @click="openProgress = false"
                                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition text-lg font-bold">
                                                    ✖
                                                </button>

                                                <h2 class="text-lg font-bold text-gray-700 mb-4">
                                                    📌 Progress Kegiatan
                                                </h2>

                                                <p class="text-sm text-gray-500 mb-6">
                                                    Lakukan update progress secara berkala:
                                                </p>

                                                <div class="flex flex-col space-y-3 font-bold">
                                                    {{-- Update Laporan --}}
                                                    @if($u->status_ui === 'in_progress')
                                                    <a href="{{ route('admin.laporankegiatan.create', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#e0f2fe] text-[#0369a1]">
                                                        Update Laporan Hasil Kegiatan
                                                    </a>
                                                    @else
                                                    <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                        Update Laporan Hasil Kegiatan
                                                    </span>
                                                    @endif

                                                    {{-- Sertifikat --}}
@php
    $sertifikat = $u->inputlaporankegiatans?->laporankegiatans?->sertifikats;
@endphp

@if($sertifikat)
    <a href="{{ route('admin.sertifikat.download', $sertifikat->id) }}"
       target="_blank"
       class="block px-4 py-2 rounded-lg bg-[#defff8] text-[#136769]">
        Download Sertifikat Peserta
    </a>
@else
    <span class="block px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
        Download Sertifikat Peserta
    </span>
@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-3 px-4 text-center" x-data="{ openDokumen: false }">
                                    <div class="flex justify-center gap-4">

                                        <div class="flex items-center space-x-2">
                                        {{-- ===================== LIHAT DOKUMEN ===================== --}}
                                        <a @click="openDokumen = true"
                                            class="text-blue-600 hover:underline cursor-pointer">
                                            Detail
                                        </a>

                                        <!-- MODAL DETAIL -->
                                        <div x-show="openDokumen" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                            <div @click.outside="openDokumen = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-gray-100">

                                                {{-- Button Close --}}
                                                <button type="button" @click="openDokumen = false"
                                                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition text-lg font-bold">
                                                    ✖
                                                </button>

                                                <h2 class="text-lg font-bold text-gray-700 mb-4">
                                                    Detail Dokumen
                                                </h2>

                                                <p class="text-sm text-gray-500 mb-6">
                                                    Pilih dokumen yang ingin dilihat:
                                                </p>

                                                <div class="flex flex-col space-y-3 font-bold">

    {{-- Lihat Surat dan Laporan Hasil --}}
    @if($u->inputlaporankegiatans?->laporankegiatans)
        <a href="{{ route('admin.laporankegiatan.download', $u->id) }}"
           target="_blank"
           class="block px-4 py-2 rounded-lg bg-[#e0fbfc] text-[#0077b6]">
            Lihat Surat dan Laporan Hasil
        </a>
    @else
        <span class="block px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            Lihat Surat dan Laporan Hasil
        </span>
    @endif


    {{-- Lihat Surat Balasan Laporan --}}
    @if($u->inputlaporankegiatans?->laporankegiatans?->balasanlaporankegiatans ?? false)
        <a href="{{ route('admin.balasanlaporankegiatan.download', $u->id) }}"
           target="_blank"
           class="block px-4 py-2 rounded-lg bg-[#ffe5ec] text-[#d00000]">
            Lihat Surat Balasan Laporan
        </a>
    @else
        <span class="block px-4 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
            Lihat Surat Balasan Laporan
        </span>
    @endif

    </div>
                                            </div>
                                        </div>

                                        {{-- ===================== TOMBOL EDIT ===================== --}}
                                        @if($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                        <span class="text-gray-400">|</span>
                                        <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                            class="text-blue-600 hover:underline">
                                            Edit
                                        </a>
                                        @else
                                        <span class="text-gray-400 ">| Edit</span>
                                        @endif

                                        {{-- ===================== TOMBOL HAPUS ===================== --}}
@if($u->inputlaporankegiatans)
    <span class="text-gray-400">|</span>
    <form action="{{ route('admin.laporankegiatan.destroy', $u->inputlaporankegiatans->id) }}"
        method="POST"
        class="inline"
        onsubmit="return confirm('Yakin hapus laporan ini?')">
        @csrf
        @method('DELETE')

        <button type="submit" class="text-red-600 hover:underline">
            Hapus
        </button>
    </form>
@endif
                                    </div>
                                    </div>
                                </td>
                            </tr>
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

    <!-- Modal Container -->
    <div id="cetakModalContainer"></div>

    <script>
        async function openCetakModal(id, type) {
            const container = document.getElementById('cetakModalContainer');
            container.innerHTML = `
                <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 text-white">
                    <div class="animate-pulse text-lg">Memuat pop-up cetak...</div>
                </div>
            `;

            // Tentukan endpoint berdasarkan tipe
            let url = '';

            if (type === 'laporankegiatans') {
                url = `/admin/laporankegiatan/${id}/cetak`;
            } else {
                url = `/admin/usulankegiatan/${id}/cetak`;
            }

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Gagal memuat pop-up cetak.');
                const html = await response.text();
                container.innerHTML = html;
            } catch (error) {
                container.innerHTML = `
                    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 text-white">
                        <div class="bg-red-700 p-4 rounded shadow">
                            ${error.message}
                        </div>
                    </div>
                `;
            }
        }
    </script>

</x-app-layout>