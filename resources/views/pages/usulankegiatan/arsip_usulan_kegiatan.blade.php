<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR ARSIP USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar arsip usulan kegiatan pengembangan kompetensi ASN.
            </p>
        </div>

        <!-- FILTER FORM -->
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <form method="GET" action="{{ route('admin.usulankegiatan.arsip') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Search by Nama Kegiatan -->
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cari Nama Kegiatan</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama kegiatan..."
                        class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                </div>

                <!-- Filter by Tanggal Pengajuan -->
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" value="{{ request('tanggal_pengajuan') }}"
                        class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                </div>

                <!-- Filter by Status -->
                <div class="flex-1 min-w-0">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Status Usulan</label>
                    <select name="status" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                        <option value="">-- Semua Status --</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="need_review" {{ request('status') == 'need_review' ? 'selected' : '' }}>Need Review</option>
                        <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>Finish</option>
                    </select>
                </div>

                <!-- BUTTON GROUP -->
                <div class="flex items-end gap-2 h-full">
                    <button type="submit"
                        class="px-4 h-[42px] bg-[#4361EE] text-white text-sm font-semibold rounded-lg hover:bg-[#3651d4] transition flex items-center">
                        Filter
                    </button>

                    <a href="{{ route('admin.usulankegiatan.arsip') }}"
                        class="px-4 h-[42px] bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-400 transition flex items-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Status Usulan</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody x-data="{ openReview: false }">
                    @forelse($usulankegiatans as $index => $u)

                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Otomatis -->
                        <td class="py-3 px-4 text-center">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 truncate">
                            <button
                                @click="openReview = !openReview"
                                class="font-medium text-blue-600 hover:text-blue-800 hover:underline text-left">

                                {{ $u->inputusulankegiatans->nama_kegiatan }}
                            </button>
                        </td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                            {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="py-3 px-4 text-center">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Update Progress dan Tombol Aksi -->
                        <td class="py-3 px-4 text-center" x-data="{ openProgress: false, openDokumen: false }">
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
                                            <a href="{{ route('admin.usulankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguTransparan text-unguTua hover:bg-unguTua/60 transition">
                                                Lihat Surat dan KAK Usulan
                                            </a>

                                            {{-- Lihat Surat Balasan Laporan Kegiatan --}}
                                            <a href="{{ route('admin.usulankegiatan.downloadBalasan', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-coklatMuda/25 text-coklatGelap hover:bg-coklatGelap/60 transition">
                                                Lihat Surat Balasan Usulan
                                            </a>

                                            {{-- Lihat Pelaksanaan Kegiatan --}}
                                            <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahMaroon/60 transition">
                                                Lihat Pelaksanaan Kegiatan
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pulihkan --}}
                                <form action="{{ route('admin.usulankegiatan.restore', $u->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Pulihkan usulan kegiatan ini dari arsip?')">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-700 hover:bg-green-200 transition"
                                        title="Pulihkan">

                                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>

                                    </button>
                                </form>
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

            if (type === 'usulankegiatans') {
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

        function closeNotification(id) {
            fetch(`/admin/usulankegiatan/notifikasi/${id}/close`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content
                    }
                })
                .then(() => location.reload());
        }
    </script>

</x-app-layout>