<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR ARSIP LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar arsip laporan hasil kegiatan pengembangan kompetensi ASN.
            </p>
        </div>

        {{-- Search and Filtering --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search ....."
                        class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-abuabuGelap">
                        <i data-lucide="search"></i>
                    </span>
                </form>
            </div>

            {{-- Tahun --}}
            <form method="GET">
                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option value="">Semua Tahun</option>
                    @for ($year = 2021; $year <= 2026; $year++)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                        {{ $year }}
                        </option>
                        @endfor
                </select>
            </form>

            {{-- Sort --}}
            <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'asc' ? 'desc' : 'asc']) }}"
                class="bg-white rounded-xl border border-abuabuMuda/60 shadow px-4 py-3 flex items-center justify-center">
                @if(request('sort','desc') == 'desc')
                <i data-lucide="list-sort-descending" class="w-5 h-5 text-abuabuSedang"></i>
                @else
                <i data-lucide="list-sort-ascending" class="w-5 h-5 text-abuabuSedang"></i>
                @endif
            </a>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">OPD</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Nomor Sertifikat</th>
                        <th class="py-3 px-4">Tanggal Keluar Sertifikat</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor -->
                        <td class="py-4 px-4 text-center">
                            {{ $usulankegiatans->firstItem() + $index }}
                        </td>

                        <!-- OPD -->
                        <td class="py-3 px-4 font-semibold">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        {{-- Nomor Sertifikat --}}
                        <td class="py-4 px-4 text-center">
                            {{ $u->inputlaporankegiatans->laporankegiatans->sertifikats->nomorsertifikat_kegiatan ?? '-' }}
                        </td>

                        {{-- Tanggal Keluar Sertifikat --}}
                        <td class="py-3 px-4 whitespace-nowrap">
                            @if($u->inputlaporankegiatans?->laporankegiatans?->sertifikats?->tanggalkeluarsertifikat_kegiatan)
                            {{ \Carbon\Carbon::parse(
                                            $u->inputlaporankegiatans->laporankegiatans->sertifikats->tanggalkeluarsertifikat_kegiatan
                                        )->format('d/m/Y') }}
                            @else
                            -
                            @endif
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="py-3 px-4" x-data="{ openDokumen: false }">
                            <div class="flex justify-center gap-4">

                                {{-- ===================== LIHAT DOKUMEN ===================== --}}
                                <button
            type="button"
            @click="openDokumen = true"
            class="w-9 h-9 flex items-center justify-center rounded-lg bg-biruCerah/20 text-biruNavy/75 hover:bg-biruCerah/50 transition"
            title="Open Dokumen">
            <i data-lucide="file-text" class="w-4 h-4"></i>
        </button>

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

                                {{-- TOMBOL PULIHKAN --}}
                                @if($u->inputlaporankegiatans?->laporankegiatans)
                                <form action="{{ route('superadmin.laporankegiatan.unarchive', $u->inputlaporankegiatans->laporankegiatans->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Pulihkan laporan ini dari arsip?')">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-700 hover:bg-green-200 transition"
                                        title="Pulihkan">
                                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-abuabuMuda">
                            Tidak ada data arsip
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