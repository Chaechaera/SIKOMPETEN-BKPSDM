<x-app-layout>
    <div class="space-y-4 px-6 py-4">

            {{-- Header --}}
            @include('layouts.navigation')

            <!-- JUDUL -->
            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar kegiatan yang saat ini telah proses pelaksanaan dan perlu menyertakan laporan hasil kegiatan pelaksanaan.
                </p>
            </div>

            <!-- BUTTON TAMBAH 
            <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-4">
                <a href="{{ route('admin.usulankegiatan.create') }}"
                    class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white text-center font-semibold hover:opacity-90 transition">
                    + Buat Usulan Baru
                </a>
            </div>-->

            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-72">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Laporan</th>
                                <th class="py-3 px-4 w-48">Update Progress</th>
                                <th class="py-3 px-4 w-36">Aksi</th>
                            </tr>
                        </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Otomatis -->
                        <td class="py-3 px-4">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{ $u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan && $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
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
                                        @if (
                                        isset($u->inputlaporankegiatans) &&
                                        isset($u->inputlaporankegiatans->laporankegiatans) &&
                                        in_array($u->inputlaporankegiatans->laporankegiatans->status_laporan_ui, ['completed', 'rejected']) &&
                                        is_null($u->inputlaporankegiatans->laporankegiatans->cetakusulankegiatans))
                                        <button onclick="openCetakModal('{{ $u->id }}', 'laporankegiatans')"
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
                                        @if($u->isPendingLaporan())
                                        <a href="{{ route('admin.laporankegiatan.kirim', $u->id) }}"
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
                                        @if($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
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

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $usulankegiatans->appends(request()->query())->links() }}
        </div>

        {{-- Empty State --}}
        <div id="emptyState" class="hidden text-center py-12 text-abuabuSedang">
            Tidak ada data yang sesuai dengan pencarian
        </div>
    </div>


</x-app-layout>

