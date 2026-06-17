<div class="p-6" x-data="{ open: true }">

    <div x-show="open" class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-8 relative">

            {{-- Button Close --}}
            <button @click="open = false" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700"> ✕ </button>

            {{-- Header Judul Usulan yang Dicetak --}}
            <div class="mb-4">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">CETAK LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan periksa dan pastikan data laporan hasil kegiatan yang telah diisikan sesuai sebelum mencetak.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulan" :is-laporan="true" />

                <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                        Ringkasan Data Laporan Hasil Kegiatan
                    </h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <!-- content grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">

                        <!-- Nama Kegiatan -->
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
                            <p class="font-semibold text-[#5A5A5A]">
                                {{ $usulan->inputusulankegiatans->nama_kegiatan ?? '-' }}
                            </p>
                        </div>

                        <!-- Diajukan Oleh -->
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
                            <p class="font-semibold text-[#5A5A5A]">
                                {{ $usulan->subunitkerjas->sub_unitkerja ?? '-' }}
                            </p>
                        </div>

                        <!-- Lokasi -->
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Lokasi Kegiatan</p>
                            <p class="font-semibold text-[#5A5A5A]">
                                {{ $usulan->inputlaporankegiatans->laporankegiatans->lokasi_kegiatan ?? '-' }}
                            </p>
                        </div>

                        <!-- Tanggal -->
                        <div>
                            <p class="text-gray-400 text-xs mb-1">Tanggal Pelaksanaan</p>
                            <p class="font-semibold text-[#5A5A5A]">
                                {{
                    $usulan->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan && $usulan->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan
                    ? \Carbon\Carbon::parse($usulan->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d F Y')
                      . ' s/d ' .
                      \Carbon\Carbon::parse($usulan->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d F Y')
                    : '-'
                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Review Usulan --}}
            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.laporankegiatan.download', $usulan->id) }}"
                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                    Tinjau Laporan
                </a>
                <form method="POST" action="{{ route('admin.laporankegiatan.cetak', $usulan->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#5b78f8] to-[#3651d4] text-white font-semibold hover:opacity-90 transition">
                        Cetak Laporan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>