<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan dan perlu menunggu verifikasi oleh superadmin.
            </p>
        </div>

        <!-- BUTTON TAMBAH -->
        <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-4">
            <a href="{{ route('admin.usulankegiatan.create') }}"
                class="w-2/12 py-3 bg-orangeMuda text-white rounded-lg text-center font-semibold hover:bg-orangeMuda/80 transition">
                + Buat Usulan Baru
            </a>
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
                        <th class="py-3 px-4">Update Progress</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Otomatis -->
                        <td class="py-3 px-4">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans?->nama_kegiatan ?? '-' }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="py-3 px-4">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Update Progress -->
                        <td class="py-3 px-4" x-data="{ openProgress: false }">
                            <div class="flex justify-center gap-2">
                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if(
                                in_array($u->status_ui, ['draft', 'rejected']) &&
                                is_null($u->cetakusulankegiatans))
                                <button onclick="openCetakModal('{{ $u->id }}', 'usulankegiatans')"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-biruBlue text-white hover:bg-biruBlue/80 transition">
                                    Cetak
                                </button>
                                @else
                                <button
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->isPendingUsulan())
                                <a href="{{ route('admin.usulankegiatan.kirim', $u->id) }}"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-unguSedang text-white hover:bg-unguSedang/80 transition">
                                    Kirim
                                </a>
                                @else
                                <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- ===================== UPDATE PROGRESS ===================== --}}
                                <button type="button" @click="openProgress = true"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-hijauGreen text-white hover:bg-hijauGreen/80 transition">
                                    Update
                                </button>


                                <!-- MODAL DETAIL -->
                                <div x-show="openProgress" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                    <div @click.outside="openProgress = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

                                        {{-- Button Close --}}
                                        <button @click="openProgress = false" class="absolute top-3 right-3">
                                            <i data-lucide="x"></i>
                                        </button>

                                        <h2 class="text-2xl font-semibold bg-primary-gradient bg-clip-text text-transparent leading-tight">
                                            PROGRESS KEGIATAN
                                        </h2>

                                        <p class="text-sm font-normal text-abuabuCerah mb-6">
                                            Lakukan update progress secara berkala:
                                        </p>

                                        <div class="flex flex-col space-y-3 font-bold">
                                            {{-- Update Pelaksanaan --}}
                                            @if($u->status_ui === 'accepted')
                                            <a href="{{ route('admin.pelaksanaankegiatan.create', $u->id) }}"
                                                class="block px-4 py-2 rounded-lg bg-[#ffedd5] text-[#9a3412]">
                                                Update Pelaksanaan Kegiatan
                                            </a>
                                            @else
                                            <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                Update Pelaksanaan Kegiatan
                                            </span>
                                            @endif

                                            {{-- Lihat Pelaksanaan --}}
                                            <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                                class="block px-4 py-2 rounded-lg bg-[#eadffe] text-[#7d5bcd]">
                                                Lihat Pelaksanaan Kegiatan
                                            </a>

                                                    {{-- Buat Laporan --}}
                                                    @if($u->status_ui === 'in_progress')
                                                    <a href="{{ route('admin.laporankegiatan.create', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#e0f2fe] text-[#0369a1]">
                                                        Buat Laporan Hasil Kegiatan
                                                    </a>
                                                    @else
                                                    <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                        Buat Laporan Hasil Kegiatan
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
                                            {{-- Lihat Surat dan KAK Usulan --}}
                                            <a href="{{ route('admin.usulankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguTransparan text-unguTua hover:bg-unguTua/60 transition">
                                                Lihat Surat dan KAK Usulan
                                            </a>

                                            {{-- Lihat Surat Balasan Usulan --}}
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

                                {{-- ===================== TOMBOL EDIT ===================== --}}
                                @if(in_array($u->status_ui, ['draft', 'rejected']))
                                <a href="{{ route('admin.usulankegiatan.edit', $u->id) }}"
                                    class="text-biruBlue cursor-pointer">
                                    <i class="inline" data-lucide="square-pen"></i>
                                </a>
                                @elseif($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                    class="text-biruBlue cursor-pointer">
                                    <i class="inline" data-lucide="square-pen"></i>
                                </a>
                                @else
                                <span class="text-abuabuCerah cursor-not-allowed"><i class="inline" data-lucide="square-pen"></i></span>
                                @endif

                                {{-- ===================== TOMBOL HAPUS ===================== --}}
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
    </script>

</x-app-layout>
