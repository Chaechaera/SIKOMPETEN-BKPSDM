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
          <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">5</p>
        </div>

        <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
          <h2 class="text-gray-700 text-sm font-medium">Disetujui</h2>
          <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
        </div>

        <div class="p-5 sm:p-6 rounded-xl bg-[#F2E9FF] shadow-sm">
          <h2 class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</h2>
          <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">2</p>
        </div>
      </section>

            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow p-6">
                 <!-- FILTER ATAS -->
    <div class="flex justify-end mb-4">
        <form method="GET">
            <select name="statuslaporan_kegiatan" onchange="this.form.submit()"
                class="w-full md:w-52 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-200">
                
                <option value="">Semua Status Laporan</option>

                <option value="pending"
                    {{ request('statuslaporan_kegiatan') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="accepted"
                    {{ request('statuslaporan_kegiatan') == 'accepted' ? 'selected' : '' }}>
                    Disetujui
                </option>

                <option value="rejected"
                    {{ request('statuslaporan_kegiatan') == 'rejected' ? 'selected' : '' }}>
                    Ditolak
                </option>
            </select>
        </form>
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

                                <!-- Status Usulan Kegiatan -->
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
                                        is_null($u->inputlaporankegiatans->laporankegiatans->cetaklaporankegiatans))
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
                                                    Progress Kegiatan
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
    <a href="{{ route('admin.sertifikat.download', $u->id) }}"
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
                                        <span class="text-gray-400">|</span>
                                        @if($u->inputlaporankegiatans)
<form action="{{ route('admin.laporankegiatan.destroy', $u->inputlaporankegiatans->id) }}" method="POST"
      method="POST"
      class="inline"
      onsubmit="return confirm('Yakin hapus laporan ini?')">
    @csrf
    @method('DELETE')

    <button type="submit" class="text-red-600 hover:underline">
        Hapus
    </button>
</form>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">
                                    Tidak ada data usulan kegiatan.
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