<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <div x-data="{ sidebarOpen: false }" class="flex min-h-full">

            <!-- SIDEBAR -->
            @include('pages.sidebar.admin')

            {{-- Main Content --}}
            <main
                class="flex-1 p-6 space-y-6 transition-all duration-300"
                :class="sidebarOpen ? 'ml-64' : 'ml-0'">

                <!-- JUDUL -->
                <div class="bg-white rounded-xl shadow p-6 mb-10">
                    <h1 class="text-2xl font-semibold text-[#2B3674]">
                        DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN
                    </h1>
                    <p class="text-sm text-gray-500 max-w-2xl">
                        Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan.
                    </p>
                </div>

                <!-- PROGRES -->
                <div class="w-full bg-white rounded-xl shadow p-6 mb-8">
                    <h2 class="text-lg font-semibold text-[#2B3674] mb-6">PROGRES PENGAJUAN</h2>

                    @include('components.proggres-stepper', [
                    'processStatus' => $usulankegiatans[0]->process_status ?? null
                    ])
                </div>

                <!-- BUTTON TAMBAH -->
                <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-2">
                    <a href="{{ route('admin.usulankegiatan.create') }}"
                        class="bg-[#FFA41B] text-white px-4 py-2 rounded-lg hover:bg-[#ff9600] transition">
                        + Buat Usulan Baru
                    </a>
                </div>

                <!-- TABLE -->
                <section class="bg-white rounded-xl shadow p-4 sm:p-6">
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full text-sm text-gray-600">
                            <thead class="border-b text-gray-700 bg-[#FAFAFB]">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($usulankegiatans as $u)
                                <tr class="border-b hover:bg-gray-50 transition">

                                    <!-- Nomor Otomatis -->
                                    <td class="py-3 px-4 text-center">{{ $loop->iteration }}</td>

                                    <!-- Nama Kegiatan -->
                                    <td class="py-3 px-4 font-medium">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                                    <!-- Tanggal Pelaksanaan Kegiatan -->
                                    <td class="py-3 px-4">
                                        {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                                    </td>

                                    <!-- Status Usulan Kegiatan -->
                                    <td class="py-3 px-4 capitalize font-semibold">
                                        <span class="{{ $u->status_ui_class }}">
                                            {{ str_replace('_', ' ', $u->status_ui) }}
                                        </span>
                                    </td>

                                    <!-- Tombol Aksi -->
                                    <td class="p-2 space-x-2 relative flex items-centergap-2" x-data="{ openProgress: false, openDokumen: false }">

                                        {{-- ===================== CETAK DOKUMEN ===================== --}}
                                        @if(
                                        in_array($u->status_ui, ['draft', 'rejected']) &&
                                        is_null($u->cetakusulankegiatans))
                                        <form method="POST"
                                            action="{{ route('admin.usulankegiatan.cetak', $u->id) }}"
                                            onsubmit="return confirm('Yakin cetak? Status akan berubah ke pending.')">
                                            @csrf
                                            <button type="submit"
                                                class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                                Cetak
                                            </button>
                                        </form>
                                        @elseif (
                                        isset($u->inputlaporankegiatans) &&
                                        isset($u->inputlaporankegiatans->laporankegiatans) &&
                                        in_array($u->inputlaporankegiatans->laporankegiatans->status_laporan_ui, ['completed', 'rejected']) &&
                                        is_null($u->inputlaporankegiatans->laporankegiatans->cetakusulankegiatans))
                                        <form method="POST"
                                            action="{{ route('admin.laporankegiatan.cetak', $u->id) }}"
                                            onsubmit="return confirm('Yakin cetak? Status akan berubah ke pending.')">
                                            @csrf
                                            <button type="submit"
                                                class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                                Cetak
                                            </button>
                                        </form>
                                        @else
                                        <button class="bg-[#dcddde] text-gray-600 italic text-xs px-4 py-1.5 rounded-md">Cetak</button>
                                        @endif

                                        {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                        @if($u->isPendingUsulan())
                                        <a href="{{ route('admin.usulankegiatan.kirim', $u->id) }}"
                                            class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                            Kirim
                                        </a>
                                        @elseif($u->isPendingLaporan())
                                        <a href="{{ route('admin.laporankegiatan.kirim', $u->id) }}"
                                            class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                            Kirim
                                        </a>
                                        @else
                                        <button class="bg-[#dcddde] text-gray-600 italic text-xs px-4 py-1.5 rounded-md">Kirim</button>
                                        @endif

                                        {{-- ===================== UPDATE PROGRESS ===================== --}}
                                        <button type="button" @click="openProgress = true"
                                            class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
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
                                                        Update Pelaksanaan Kegiatan
                                                    </a>
                                                    @else
                                                    <span class="block px-4 py-2 rounded-lg bg-[#dedfe2] text-gray-400 italic cursor-not-allowed">
                                                        Update Pelaksanaan Kegiatan
                                                    </span>
                                                    @endif

                                                    {{-- Lihat Pelaksanaan --}}
                                                    <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#eadffe] text-[#7d5bcd]">
                                                        Lihat Pelaksanaan Kegiatan
                                                    </a>

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

                                                    {{-- Lihat Pelaksanaan --}}
                                                    <a href="{{ route('admin.sertifikat.download', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#defff8] text-[#136769]">
                                                        Download Sertifikat Peserta
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ===================== LIHAT DOKUMEN ===================== --}}
                                        <button type="button" @click="openDokumen = true"
                                            class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                            Lihat
                                        </button>


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

                                        {{-- ===================== AKSI ADMINISTRATIF ===================== --}}
                                        <div class="flex flex-wrap gap-2">

                                            {{-- TOMBOL EDIT --}}
                                            @if(in_array($u->status_ui, ['draft', 'rejected']))
                                            <a href="{{ route('admin.usulankegiatan.edit', $u->id) }}"
                                                class="text-indigo-600 hover:underline">
                                                <img src="{{ asset('images/edit.png') }}" class="w-5 h-5">
                                            </a>
                                            @elseif($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                            <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                                class="text-indigo-600 hover:underline">
                                                <img src="{{ asset('images/edit.png') }}" class="w-5 h-5">
                                            </a>
                                            @else
                                            <span class="text-gray-400 italic"><img src="{{ asset('images/edit.png') }}" class="w-5 h-5"></span>
                                            @endif

                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin hapus usulan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">
                                                    <img src="{{ asset('images/delete.png') }}" alt="Hapus" class="w-5 h-5 inline">
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
                </section>
            </main>
        </div>
    </div>
</x-app-layout>