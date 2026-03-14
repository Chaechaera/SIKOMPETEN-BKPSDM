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

            <!-- Tabel Daftar Usulan -->
            <div class="bg-white rounded-xl shadow p-6">
                {{-- Filters --}}
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <input type="text" placeholder="Cari nama kegiatan, nomor surat, atau OPD..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>

                    {{-- Status Filter --}}
                    <form method="GET">
                        <select name="statuslaporan_kegiatan" onchange="this.form.submit()"
                            class="w-full md:w-52 border rounded-lg px-3 py-2">
                            <option value="">Semua Status Laporan</option>
                            <option value="pending" {{ request('statuslaporan_kegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('statuslaporan_kegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('statuslaporan_kegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </form>
                </div>
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-32">Nomor Surat</th>
                                <th class="py-3 px-4 w-24">OPD</th>
                                <th class="py-3 px-4 w-60">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Usulan</th>
                                <th class="py-3 px-4 w-48">Update Progress</th>
                                <th class="py-3 px-4 w-20">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usulankegiatans as $index => $u)
                            <tr class="border-b hover:bg-gray-50">

                                <!-- Nomor Surat -->
                                <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                    {{ $u->inputlaporankegiatans->kirimlaporankegiatans->identitassurats->nomor_surat ?? '-' }}
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
                                <td class="py-3 px-4 text-center" x-data="{ openProgress: false }">
                                    <div class="flex justify-center gap-2">
                                        {{-- ===================== CETAK DOKUMEN ===================== --}}
                                        @if($u->inputlaporankegiatans?->laporankegiatans?->boleh_cetak_laporan)
                                        <form method="POST"
                                            action="{{ route('superadmin.balasanlaporankegiatan.cetak', $u->id) }}"
                                            onsubmit="return confirm('Yakin cetak?')">
                                            @csrf
                                            <button type="submit"
                                                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#4361EE] text-white hover:bg-[#3651d4] transition">
                                                Cetak
                                            </button>
                                        </form>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                                            Cetak
                                        </button>
                                        @endif

                                        {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                        @if($u->inputlaporankegiatans?->laporankegiatans?->boleh_kirim_laporan)
                                        <a href="{{ route('superadmin.balasanlaporankegiatan.kirim', $u->id) }}"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                                            Kirim
                                        </a>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Kirim</button>
                                        @endif

                                        {{-- ===================== REVIEW DOKUMEN ===================== --}}
                                        @if($u->isReviewLaporan())
                                        <button
                                            onclick="openReviewModal('{{ $u->inputlaporankegiatans->laporankegiatans->id }}', 'laporankegiatans')"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
                                            Review
                                        </button>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Review</button>
                                        @endif
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-3 px-4 text-center" x-data="{ openDokumen: false }">
                                    <div class="flex justify-center gap-2">

                                        {{-- TOMBOL LIHAT DOKUMEN --}}
                                        <a @click="openDokumen = true"
                                            class="text-indigo-600 hover:underline">
                                            <img src="{{ asset('images/File text.png') }}" class="w-6 h-6 inline">
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
                                                    📄 Daftar Dokumen
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
                                            </div>
                                        </div>

                                        {{-- TOMBOL HAPUS --}}
                                        <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin hapus usulan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:underline">
                                                <img src="{{ asset('images/delete.png') }}" alt="Hapus" class="w-6 h-6 inline">
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 p-4">
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