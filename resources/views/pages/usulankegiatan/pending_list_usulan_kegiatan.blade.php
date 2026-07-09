<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar usulan kegiatan yang diajukan oleh OPD yang saat ini perlu untuk diproses dan diverifikasi.
            </p>
        </div>

        <!-- FILTER FORM -->
        <div class="bg-white rounded-xl border border-gray-200 shadow p-6 mb-4">
            <form method="GET" class="flex flex-wrap gap-5 items-end">

                {{-- Search --}}
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                        Cari Nama Kegiatan, Nomor Surat, atau OPD
                    </label>

                    <div class="relative">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Cari nama kegiatan, nomor surat, OPD"
                            class="block w-full pl-10 pr-4 py-2 text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>
                </div>

                {{-- Tanggal Pengajuan --}}
                <div class="flex-1 min-w-0">
                    <label
                        class="block text-sm font-semibold text-[#5A5A5A] mb-2"
                        for="tanggal_pengajuan">
                        Tanggal Pengajuan
                    </label>

                    <input
                        type="date"
                        id="tanggal_pengajuan"
                        name="tanggal_pengajuan"
                        value="{{ request('tanggal_pengajuan') }}"
                        class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                </div>

                {{-- Status --}}
                <div class="flex-1 min-w-0">
                    <label
                        class="block text-sm font-semibold text-[#5A5A5A] mb-2"
                        for="statususulan_kegiatan">
                        Status Usulan
                    </label>

                    <select
                        id="statususulan_kegiatan"
                        name="statususulan_kegiatan"
                        onchange="this.form.submit()"
                        class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">

                        <option value="">Semua Status Usulan</option>
                        <option value="pending"
                            {{ request('statususulan_kegiatan') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="accepted"
                            {{ request('statususulan_kegiatan') == 'accepted' ? 'selected' : '' }}>
                            Disetujui
                        </option>

                        <option value="rejected"
                            {{ request('statususulan_kegiatan') == 'rejected' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
                </div>

                {{-- Button --}}
                <div class="flex items-end gap-2 h-full">
                    <button
                        type="submit"
                        class="px-5 h-[42px] bg-[#4361EE] text-white text-sm font-semibold rounded-lg hover:bg-[#3651d4] transition flex items-center justify-center">
                        Terapkan
                    </button>

                    <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                        class="px-5 h-[42px] bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-400 transition flex items-center justify-center">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">Nomor Surat</th>
                        <th class="py-3 px-4">OPD</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Status Usulan</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Surat -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{ $u->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}
                        </td>

                        <!-- OPD -->
                        <td class="py-3 px-4 font-semibold">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-3 px-4 text-center" x-data="{ openDokumen: false }">
                            <div class="flex items-center justify-center gap-2">
                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if($u->boleh_cetak)
                                <a href="{{ route('superadmin.balasanusulankegiatan.cetak', $u->id) }}"
                                class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-biruBlue text-white hover:bg-biruBlue/80 transition inline-flex items-center justify-center">
                                Cetak
                            </a>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->boleh_kirim)
                                <a href="{{ route('superadmin.balasanusulankegiatan.kirim', $u->id) }}"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-unguSedang text-white hover:bg-unguSedang/80 transition inline-flex items-center justify-center">
                                    Kirim
                                </a>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- ===================== REVIEW DOKUMEN ===================== --}}
                                @if($u->isReviewUsulan())
                                <button onclick="openReviewModal('{{ $u->id }}', 'usulankegiatans')"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-hijauGreen text-white hover:bg-hijauGreen/80 transition inline-flex items-center justify-center">
                                    Review
                                </button>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Review</button>
                                @endif

                                {{-- Open Dokumen --}}
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

                                            {{-- Surat & KAK Usulan --}}
                                            <a href="{{ route('superadmin.usulankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguTransparan text-unguTua hover:bg-unguTua/60 transition">
                                                Lihat Surat dan KAK Usulan
                                            </a>

                                            {{-- Surat Balasan --}}
                                            @if($u->sudah_cetak || $u->sudah_kirim)
                                            <a href="{{ route('superadmin.usulankegiatan.downloadBalasan', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-coklatMuda/25 text-coklatGelap hover:bg-coklatGelap/60 transition">
                                                Lihat Surat Balasan Usulan
                                            </a>
                                            @else
                                            <button
                                                disabled
                                                class="block w-full px-4 py-3 rounded-lg bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                                Lihat Surat Balasan Usulan
                                            </button>
                                            @endif

                                            {{-- Pelaksanaan --}}
                                            @if($u->inputusulankegiatans?->pelaksanaankegiatans)
                                            <a href="{{ route('superadmin.pelaksanaankegiatan.show', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahMaroon/60 transition">
                                                Lihat Pelaksanaan Kegiatan
                                            </a>
                                            @else
                                            <button
                                                disabled
                                                class="block w-full px-4 py-3 rounded-lg bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                                Lihat Pelaksanaan Kegiatan
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- TOMBOL ARSIP --}}
                                <form action="{{ route('superadmin.usulankegiatan.archive',$u->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengarsipkan usulan ini?')">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-kuningBening hover:bg-kuningBening/70 transition"
                                        title="Arsip">

                                        <img src="{{ asset('images/archive.png') }}"
                                            class="w-4 h-4">
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