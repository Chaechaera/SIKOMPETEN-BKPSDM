<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan dan verifikasi oleh superadmin.
            </p>
        </div>

        <!-- BUTTON TAMBAH -->
        <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-4">
            <a href="{{ route('admin.usulankegiatan.create') }}"
                class="w-2/12 py-3 bg-orangeMuda text-white rounded-lg text-center font-semibold hover:bg-orangeMuda/80 transition">
                + Buat Usulan Baru
            </a>
        </div>

        <!-- FILTER FORM -->
        <div class="bg-white rounded-xl shadow p-6 mb-4">
            <form method="GET" action="{{ route('admin.usulankegiatan.index') }}" class="flex flex-wrap gap-4 items-end">
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
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
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

                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="px-4 h-[42px] bg-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-400 transition flex items-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if($notifikasiReview->count())
        @foreach($notifikasiReview as $notif)
        <div
            x-data="{ show: true }"
            x-show="show"
            class="mb-4">

            <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 relative">
                <button
                    onclick="closeNotification({{ $notif->id }})"
                    class="absolute top-3 right-4 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
                <h3 class="font-semibold text-[#2B3674] mb-2">
                    📢 Catatan Review Usulan Kegiatan
                </h3>
                <p>
                    <strong>
                        {{ $notif->usulankegiatans->inputusulankegiatans->nama_kegiatan }}
                    </strong>
                    telah
                    <span class="{{
                            $notif->status_verifikasiusulankegiatan === 'accepted'
                            ? 'text-green-600'
                            : 'text-red-600'
                        }}">
                        {{ ucfirst($notif->status_verifikasiusulankegiatan) }}

                    </span>.
                </p>

                <p class="mt-2 italic">
                    {{ $notif->catatan_verifikasiusulankegiatan ?: 'Tidak ada catatan tambahan.' }}
                </p>
            </div>
        </div>
        @endforeach
        @endif

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
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Otomatis -->
                        <td class="py-3 px-4">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">
                            <button
                                @click="openReview = !openReview"
                                class="font-medium text-blue-600 hover:text-blue-800 hover:underline text-left">

                                {{ $u->inputusulankegiatans->nama_kegiatan }}
                            </button>
                        </td>

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
                        <td class="py-3 px-4 text-center" x-data="{ openDokumen: false, openUpdate:false }">
                            <div class="flex items-center justify-center gap-2">
                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if(
                                in_array($u->status_ui, ['draft', 'rejected']) &&
                                is_null($u->cetakusulankegiatans))
                                <a href="{{ route('admin.usulankegiatan.cetak', $u->id) }}"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-biruBlue text-white hover:bg-biruBlue/80 transition">
                                    Cetak
                                </a>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->isPendingUsulan())
                                <a href="{{ route('admin.usulankegiatan.kirim', $u->id) }}"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-unguSedang text-white hover:bg-unguSedang/80 transition">
                                    Kirim
                                </a>
                                @else
                                <button class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- ===================== UPDATE ===================== --}}
                                @if(in_array($u->status_ui, ['accepted', 'in_progress']))
                                <button
                                    type="button"
                                    @click="openUpdate = true"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-hijauGreen text-white hover:bg-hijauGreen/80 transition">
                                    Update
                                </button>
                                @else
                                <button
                                    type="button"
                                    disabled
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Update
                                </button>
                                @endif

                                <!-- MODAL UPDATE -->
                                <div x-show="openUpdate" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                    <div @click.outside="openUpdate=false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

                                        {{-- Button Close --}}
                                        <button @click="openUpdate = false" class="absolute top-3 right-3">
                                            <i data-lucide="x"></i>
                                        </button>

                                        <h2 class="text-2xl font-semibold bg-primary-gradient bg-clip-text text-transparent leading-tight">
                                            PROGRESS KEGIATAN
                                        </h2>

                                        <p class="text-sm font-normal text-abuabuCerah mb-6">
                                            Lakukan update progress secara berkala:
                                        </p>

                                        <div class="flex flex-col space-y-3 font-bold">

                                            {{-- Pelaksanaan --}}
                                            @if($u->status_ui === 'accepted')
                                            <a
                                                href="{{ route('admin.pelaksanaankegiatan.create',$u->id) }}"
                                                class="block w-full text-center px-4 py-3 rounded-lg bg-kuningBening text-orange hover:bg-orangeMuda/50 transition">
                                                Update Pelaksanaan Kegiatan
                                            </a>
                                            @else
                                            <div
                                                class="block w-full text-center px-4 py-3 font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                                Update Pelaksanaan Kegiatan
                                            </div>
                                            @endif

                                            {{-- Laporan --}}
                                            @if($u->status_ui === 'in_progress')
                                            <a
                                                href="{{ route('admin.laporankegiatan.create',$u->id) }}"
                                                class="block w-full text-center px-4 py-3 rounded-lg bg-unguBening text-unguSedang hover:bg-unguMuda/50 transition">
                                                Update Laporan Hasil Kegiatan
                                            </a>
                                            @else
                                            <div
                                                class="block w-full text-center px-4 py-3 font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                                Update Laporan Hasil Kegiatan
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>



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
                                            <a href="{{ route('admin.usulankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguTransparan text-unguTua hover:bg-unguTua/60 transition">
                                                Lihat Surat dan KAK Usulan
                                            </a>

                                            {{-- Surat Balasan --}}
                                            @if($u->sudah_cetak || $u->sudah_kirim)
                                            <a href="{{ route('admin.usulankegiatan.downloadBalasan', $u->id) }}"
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
                                            <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
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

                                {{-- ===================== TOMBOL EDIT ===================== --}}
                                @if(in_array($u->status_ui, ['draft', 'rejected']))
                                <a href="{{ route('admin.usulankegiatan.edit', $u->id) }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-kuningBening text-orange hover:bg-orangeMuda/30 transition"
                                    title="Edit Dokumen">
                                    <i data-lucide="square-pen" class="w-4 h-4"></i>
                                </a>
                                @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-abuabuMuda text-abuabuSedang cursor-not-allowed"
                                    title="Edit Dokumen">
                                    <i data-lucide="square-pen" class="w-4 h-4"></i>
                                </span>
                                @endif

                                {{-- ===================== TOMBOL ARSIP ===================== --}}
                                <form action="{{ route('admin.usulankegiatan.archive', $u->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengarsipkan usulan ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-kuningBening text-orange hover:bg-orangeMuda/30 transition"
                                        title="Arsip">
                                        <img src="{{ asset('images/archive.png') }}"
                                            alt="Arsip"
                                            class="w-4 h-4">
                                    </button>
                                </form>
                            </div>
                        </td>
                        @if($u->verifikasiusulankegiatanterakhir)
                    <tr
                        x-show="openReview"
                        x-transition>
                        <td colspan="6" class="bg-blue-50 px-6 py-4">
                            <div class="rounded-lg border border-blue-200 bg-white p-4">
                                <h4 class="font-semibold text-[#2B3674] mb-3">
                                    📢 Catatan Review Usulan Kegiatan
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>Status Verifikasi:</strong>

                                        <span class="{{
                                                    $u->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan === 'accepted'
                                                    ? 'text-green-600'
                                                    : 'text-red-600'
                                                }}">
                                            {{
                                                        ucfirst(
                                                            $u->verifikasiusulankegiatanterakhir->status_verifikasiusulankegiatan
                                                        )
                                                    }}
                                        </span>
                                    </p>
                                    <p>
                                        <strong>Catatan:</strong>

                                        {{
                                                    $u->verifikasiusulankegiatanterakhir->catatan_verifikasiusulankegiatan
                                                    ?: 'Tidak ada catatan tambahan.'
                                                }}
                                    </p>
                                    <p>
                                        <strong>Tanggal Verifikasi:</strong>

                                        {{
                                                    \Carbon\Carbon::parse(
                                                        $u->verifikasiusulankegiatanterakhir->tanggalverifikasi_inputusulankegiatan
                                                    )->format('d/m/Y H:i')
                                                }}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
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