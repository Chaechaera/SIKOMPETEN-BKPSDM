<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar laporan kegiatan yang dilaporkan oleh OPD yang saat ini perlu untuk diproses dan diverifikasi.
            </p>
        </div>

        {{-- Search and Filtering --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                </form>
            </div>

            {{-- Status Filter --}}
            <form method="GET">
                <select name="statuslaporan_kegiatan" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option class="text-black" value="">Status Laporan</option>
                    <option class="text-black" value="pending" {{ request('statuslaporan_kegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option class="text-black" value="accepted" {{ request('statuslaporan_kegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                    <option class="text-black" value="rejected" {{ request('statuslaporan_kegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">Nomor Surat</th>
                        <th class="py-3 px-4">OPD</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Status Usulan</th>
                        <th class="py-3 px-4">Update Progress</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Surat -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{ $u->inputlaporankegiatans->kirimlaporankegiatans->identitassurats->nomor_surat ?? '-' }}
                        </td>

                        <!-- OPD -->
                        <td class="py-3 px-4 font-semibold">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{$u->tanggalmulai_kegiatan && $u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="{{ $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui_class }}">
                                {{ str_replace('_', ' ', $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui) }}
                            </span>
                        </td>

                        <!-- Update Progress -->
                        <td class="py-3 px-4" x-data="{ openProgress: false }">
                            <div class="flex justify-center gap-2">
                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if($u->inputlaporankegiatans?->laporankegiatans?->boleh_cetak_laporan)
                                <form method="POST"
                                    action="{{ route('superadmin.balasanlaporankegiatan.cetak', $u->id) }}"
                                    onsubmit="return confirm('Yakin cetak?')">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-md bg-biruBlue text-white hover:bg-biruBlue/80 transition">
                                        Cetak
                                    </button>
                                </form>
                                @else
                                <button
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->inputlaporankegiatans?->laporankegiatans?->boleh_kirim_laporan)
                                <a href="{{ route('superadmin.balasanlaporankegiatan.kirim', $u->id) }}"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-unguSedang text-white hover:bg-unguSedang/80 transition">
                                    Kirim
                                </a>
                                @else
                                <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- ===================== REVIEW DOKUMEN ===================== --}}
                                @if($u->isReviewLaporan())
                                <button onclick="openReviewModal('{{ $u->inputlaporankegiatans->laporankegiatans->id }}', 'laporankegiatans')"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-hijauGreen text-white hover:bg-hijauGreen/80 transition">
                                    Review
                                </button>
                                @else
                                <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Review</button>
                                @endif
                            </div>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="py-3 px-4" x-data="{ openDokumen: false }">
                            <div class="flex justify-center gap-4">

                                {{-- ===================== LIHAT DOKUMEN ===================== --}}
                                <a @click="openDokumen = true" class="cursor-pointer">
                                    <i class="inline" data-lucide="file-text"></i>
                                </a>

                                <!-- MODAL DETAIL -->
                                <div x-show="openDokumen" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                    <div @click.outside="openDokumen = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

                                        {{-- Button Close --}}
                                        <button @click="openDokumen = false"
                                            class="absolute top-3 right-3">
                                            <i data-lucide="x"></i>
                                        </button>

                                        <h2 class="text-2xl font-semibold bg-primary-gradient bg-clip-text text-transparent leading-tight">
                                            DAFTAR DOKUMEN
                                        </h2>

                                        <p class="text-sm font-normal text-abuabuCerah mb-6">
                                            Pilih dokumen terkait usulan kegiatan yang ingin dilihat.
                                        </p>

                                        <div class="flex flex-col space-y-3 font-semibold text-sm">
                                            {{-- Lihat Surat dan Laporan Kegiatan --}}
                                            <a href="{{ route('superadmin.laporankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-hijauTransparan text-hijauTua hover:bg-hijauTua/60 transition">
                                                Lihat Surat dan Laporan Hasil
                                            </a>

                                            {{-- Lihat Surat Balasan Laporan Kegiatan --}}
                                            <a href="{{ route('superadmin.balasanlaporankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguBening text-unguSedang hover:bg-unguSedang/60 transition">
                                                Lihat Surat Balasan Laporan
                                            </a>

                                            {{-- Lihat Pelaksanaan Kegiatan --}}
                                            <a href="{{ route('superadmin.pelaksanaankegiatan.show', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahMaroon/60 transition">
                                                Lihat Pelaksanaan Kegiatan
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
                                        class="text-merahCabai">
                                        <i alt="Hapus" class="inline" data-lucide="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-abuabuMuda">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $usulankegiatans->appends(request()->query())->links() }}
        </div>

        {{-- Empty State --}}
        <div id="emptyState" class="hidden text-center py-12 text-abuabuSedang">
            Tidak ada data yang sesuai dengan pencarian
        </div>
    </div>
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