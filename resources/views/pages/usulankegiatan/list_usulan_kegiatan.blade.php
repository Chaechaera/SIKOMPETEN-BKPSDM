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
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan dan verifikasi oleh superadmin.
                </p>
            </div>

            <!-- BUTTON TAMBAH -->
            <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-4">
                <a href="{{ route('admin.usulankegiatan.create') }}"
                    class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white text-center font-semibold hover:opacity-90 transition">
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

            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-72">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Usulan</th>
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

                                <!-- Update Progress -->
                                <td class="py-3 px-4 text-center" x-data="{ openProgress: false }">
                                    <div class="flex justify-center gap-2">
                                        {{-- ===================== CETAK DOKUMEN ===================== --}}
                                        @if(
                                        in_array($u->status_ui, ['draft', 'rejected']) &&
                                        is_null($u->cetakusulankegiatans))
                                        <button onclick="openCetakModal('{{ $u->id }}', 'usulankegiatans')"
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
                                        @if($u->isPendingUsulan())
                                        <a href="{{ route('admin.usulankegiatan.kirim', $u->id) }}"
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
                                                    {{-- Update Pelaksanaan --}}
                                                    @if($u->status_ui === 'accepted')
                                                    <a href="{{ route('admin.pelaksanaankegiatan.create', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#ffedd5] text-[#9a3412]">
                                                        Upload Pelaksanaan Kegiatan
                                                    </a>
                                                    @else
                                                    <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                        Upload Pelaksanaan Kegiatan
                                                    </span>
                                                    @endif

                                                    {{-- Lihat Pelaksanaan --}}
                                                    @if($u->inputusulankegiatans?->pelaksanaankegiatans)
                                                    <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                                        class="block px-4 py-2 rounded-lg bg-[#eadffe] text-[#7d5bcd]">
                                                        Lihat Pelaksanaan Kegiatan
                                                    </a>
                                                    @else
                                                    <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                        Lihat Pelaksanaan Kegiatan
                                                    </span>
                                                    @endif

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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Tombol Aksi -->
                                <td class="py-3 px-4 text-center" x-data="{ openDokumen: false }">
                                    <div class="flex justify-center gap-4">

                                        {{-- ===================== LIHAT DOKUMEN ===================== --}}
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
                                                    {{-- Lihat Surat dan KAK Usulan --}}
                                                    <a href="{{ route('admin.usulankegiatan.download', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#edf2fb] text-[#3a0ca3]">
                                                        Lihat Surat dan KAK Usulan
                                                    </a>

                                                    {{-- Lihat Surat Balasan Usulan --}}
                                                    <a href="{{ route('admin.usulankegiatan.downloadBalasan', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#fff1f5] text-[#ab5353]">
                                                        Lihat Surat Balasan Usulan
                                                    </a>

                                                    {{-- Lihat Surat dan Laporan Hasil --}}
                                                    <a href="{{ route('admin.laporankegiatan.download', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#e0fbfc] text-[#0077b6]">
                                                        Lihat Surat dan Laporan Hasil
                                                    </a>

                                                    {{-- Lihat Surat Balasan Laporan --}}
                                                    <a href="{{ route('admin.balasanlaporankegiatan.download', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#ffe5ec] text-[#d00000]">
                                                        Lihat Surat Balasan Laporan
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== TOMBOL EDIT ===================== --}}
                                        @if(in_array($u->status_ui, ['draft', 'rejected']))
                                        <a href="{{ route('admin.usulankegiatan.edit', $u->id) }}"
                                            class="text-indigo-600 hover:underline">
                                            <img src="{{ asset('images/edit.png') }}" class="w-6 h-6 inline">
                                        </a>
                                        @elseif($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                        <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                            class="text-indigo-600 hover:underline">
                                            <img src="{{ asset('images/edit.png') }}" class="w-6 h-6 inline">
                                        </a>
                                        @else
                                        <span class="text-gray-400 italic"><img src="{{ asset('images/edit.png') }}" class="w-6 h-6 inline"></span>
                                        @endif

                                        {{-- ===================== TOMBOL HAPUS ===================== --}}
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