<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.superadmin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            <!-- JUDUL -->
            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar laporan kegiatan yang dilaporkan oleh OPD yang saat ini perlu untuk diproses dan diverifikasi.
                </p>
            </div>

            <!-- TABLE -->
<div class="bg-white rounded-xl shadow p-6">

    <!-- FILTER ATAS -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

        {{-- Search --}}
<form method="GET" class="flex-1 relative">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        placeholder="Cari nama kegiatan, nomor surat, atau OPD..." 
        onkeyup="this.form.submit()" 
        class="w-full pl-10 pr-4 py-2 border rounded-lg"
    />

    <svg 
        xmlns="http://www.w3.org/2000/svg" 
        class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor"
    >
        <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2" 
            d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" 
        />
    </svg>
</form>
        <!-- FILTER + SORT -->
        <div class="flex items-center gap-3 flex-wrap">

            <form method="GET" class="flex items-center gap-3 flex-wrap">

                <!-- TAHUN -->
                <select name="tahun" onchange="this.form.submit()"
                    class="border rounded-lg px-4 py-2 text-sm min-w-[140px]">
                    <option value="">Semua Tahun</option>
                    @for ($year = 2021; $year <= 2026; $year++)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>

                <!-- STATUS -->
                <select name="status" onchange="this.form.submit()"
                    class="border rounded-lg px-4 py-2 text-sm min-w-[140px]">

                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
                    <option value="need_review" {{ request('status') == 'need_review' ? 'selected' : '' }}>need review</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>draft</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>rejected</option>
                    <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>finish</option>

                </select>

            </form>

            <!-- SORT -->
            <div x-data="{ openSort: false }" class="relative">

                <button @click="openSort = !openSort"
                    class="border rounded-lg px-3 py-2 bg-white hover:bg-gray-100 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4h13M3 8h9m-9 4h6m-6 4h3" />
                    </svg>
                </button>

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
    </div>
                <div class="border rounded-lg overflow-x-auto">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-32">Nomor Surat</th>
                                <th class="py-3 px-4 w-24">OPD</th>
                                <th class="py-3 px-4 w-48">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Usulan</th>
                                <th class="py-3 px-4 w-[450px]">Update Progress</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usulankegiatans as $index => $u)
                            <tr class="border-b hover:bg-gray-50"
                            x-data="{ openDokumen: false }">

                                <!-- Nomor Surat -->
                                <td class="py-3 px-4 text-gray-600 text-center break-words">
    {{ $u->inputlaporankegiatans->cetaklaporankegiatans->identitassurats->nomor_surat ?? '-' }}
</td>

                                <!-- OPD -->
                                <td class="py-3 px-4 text-center font-medium text-gray-800">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                                <!-- Tanggal Pelaksanaan Kegiatan -->
                                <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                    {{$u->tanggalmulai_kegiatan && $u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                                </td>

                                <!-- Status Usulan Kegiatan -->
                                <td class="py-3 px-4 text-center">
                                    <span class="{{ $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui_class }}">
                                        {{ str_replace('_', ' ', $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui) }}
                                    </span>
                                </td>

                                <!-- Update Progress -->
<td class="py-3 px-4 text-center">
    <div class="flex justify-center items-center gap-2">

        {{-- CETAK --}}
@if($u->inputlaporankegiatans?->laporankegiatans?->boleh_cetak_laporan)

   <a href="{{ route(
    'superadmin.balasanlaporankegiatan.cetak',
    $u->inputlaporankegiatans->laporankegiatans->id
    ) }}"
    class="w-24 px-3 py-1.5 text-xs font-medium rounded-md
    bg-[#4361EE] text-white hover:bg-[#3651d4] transition
    inline-flex items-center justify-center">
        Cetak
    </a>

@else

    <button
        class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
        Cetak
    </button>

@endif

        {{-- KIRIM --}}
        @if($u->inputlaporankegiatans?->laporankegiatans?->boleh_kirim_balasan)
            <a href="{{ route(
                'superadmin.balasanlaporankegiatan.kirim',
                $u->inputlaporankegiatans->laporankegiatans->id
            ) }}"
                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                Kirim
            </a>
        @else
            <button
                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                Kirim
            </button>
        @endif

        {{-- REVIEW --}}
        @if($u->isReviewLaporan())
            <button
                onclick="openReviewModal('{{ $u->inputlaporankegiatans->laporankegiatans->id }}', 'laporankegiatans')"
                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
                Review
            </button>
        @else
            <button
                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                Review
            </button>
        @endif

        {{-- UPDATE --}}
        <button
    type="button"
    @click="openDokumen = true"
    class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-blue-600 text-white hover:bg-blue-700 transition">
    Update
</button>

    </div>
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
                                                    {{-- Lihat Surat Balasan Usulan --}}
                                                    <a href="{{ route('superadmin.pelaksanaankegiatan.show', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#fff1f5] text-[#ab5353]">
                                                        Lihat Pelaksanaan Kegiatan
                                                    </a>

                                                    {{-- Lihat Surat dan Laporan Hasil --}}
                                                    <a href="{{ route('superadmin.laporankegiatan.download', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#e0fbfc] text-[#0077b6]">
                                                        Lihat Surat dan Laporan Hasil
                                                    </a>
                                                </div>

                                                    <p class="text-sm text-gray-500 my-6">
                                                    Pilih aksi yang ingin dilakukan:
                                                    </p>

                                                    <div class="flex flex-col space-y-3 font-bold">
                                                    
                                                    {{-- ARCHIVE --}}
                                                    @if(
                                                        $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui === 'finish'
                                                        && !$u->inputlaporankegiatans?->laporankegiatans?->is_archived
                                                    )

                                                    <form
                                                        action="{{ route(
                                                        'superadmin.laporankegiatan.archive',
                                                        $u->inputlaporankegiatans->laporankegiatans->id
                                                    ) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin arsipkan laporan ini?')">
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="block w-full px-4 py-2 rounded-lg bg-[#5B2C89] text-white">
                                                        Arsipkan
                                                    </button>

                                                    </form>

                                                    @elseif(
                                                        $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui !== 'finish'
                                                    )

                                                    <span
                                                        class="block w-full px-4 py-2 rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed">
                                                        Arsipkan
                                                    </span>

                                                    @else

                                                    <span
                                                        class="block w-full px-4 py-2 rounded-lg bg-gray-100 text-gray-400">
                                                        Arsipkan
                                                    </span>

                                                    @endif
</td>
                                    <div class="flex justify-center gap-2">
                                        <div class="flex justify-center items-center gap-2 text-sm">
                                                    </div>
                                                </div>
                                
                                                                                </tr>
                                                                                @empty
                                                                                <tr>
                                                                                    <td colspan="7" class="text-center text-gray-500 p-4">
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
    <div id="reviewModalContainer"></div>

    <script>
        async function openReviewModal(id, type) {
            const container = document.getElementById('reviewModalContainer');
            container.innerHTML = `
                            <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 text-white">
                                <div class="animate-pulse text-lg">Memuat form review...</div>
                            </div>
                        `;

            // Tentukan endpoint berdasarkan tipe
            let url = '';

            if (type === 'laporankegiatans') {
                url = `/superadmin/laporankegiatan/${id}/review`;
            } else {
                url = `/superadmin/usulankegiatan/${id}/review`;
            }

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Gagal memuat form review.');
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



