<div class="p-6"
    x-data="{
        open: true,
        showPreview: false
     }">

    <div x-show="open" class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-8 relative">

            {{-- Button Close --}}
            <button @click="open = false" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700"> ✕ </button>
            <div class="px-6 py-4 max-h-[80vh] overflow-y-auto">

                {{-- Header Judul Usulan yang Direview --}}
                <div class="mb-4">

                    <div class="bg-white rounded-xl shadow p-6 mb-4">
                        <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">REVIEW PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                        <p class="text-sm text-gray-500 max-w-4xl">
                            Silahkan download atau cek surat usulan dan KAK kegiatan Pengembangan Kompetensi dahulu sebelum melakukan review.
                        </p>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                            Ringkasan Data Pengajuan Usulan Kegiatan yang Direview
                        </h2>

                        <!-- 🔻 DIVIDER -->
                        <div class="my-4 border-t-2 border-gray-200"></div>

                        <!-- content grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">

                            <!-- Nama Kegiatan -->
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
                                <p class="font-semibold text-[#5A5A5A]">
                                    {{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                                </p>
                            </div>

                            <!-- Diajukan Oleh -->
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
                                <p class="font-semibold text-[#5A5A5A]">
                                    {{ $usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }}
                                </p>
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Lokasi Kegiatan</p>
                                <p class="font-semibold text-[#5A5A5A]">
                                    {{ $usulankegiatans->lokasi_kegiatan }}
                                </p>
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <p class="text-gray-400 text-xs mb-1">Tanggal Pelaksanaan</p>
                                <p class="font-semibold text-[#5A5A5A]">
                                    {{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                    \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                            Form Review Pengajuan Usulan Kegiatan
                        </h2>

                        <!-- 🔻 DIVIDER -->
                        <div class="my-4 border-t-2 border-gray-200"></div>

                        {{-- Form Review Usulan --}}
                        <form method="POST" action="{{ route('superadmin.usulankegiatan.reviewUpload', $usulankegiatans->id) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="catatan_verifikasiusulankegiatan" class="block text-sm font-semibold text-[#5A5A5A] mb-2">Catatan Review (Opsional)</label>
                                <textarea
                                    name="catatan_verifikasiusulankegiatan"
                                    id="catatan_verifikasiusulankegiatan"
                                    class="overflow-hidden smart-textarea block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                    placeholder="Tuliskan catatan review untuk OPD"></textarea>
                            </div>

                            {{-- Preview Laporan --}}
                            <div
                                x-show="showPreview"
                                x-transition
                                class="mt-4 border border-gray-200 rounded-lg overflow-hidden">

                                <template x-if="showPreview">
                                    <iframe
                                        src="{{ route('superadmin.usulankegiatan.previewFile', $usulankegiatans->id) }}"
                                        width="100%"
                                        height="700">
                                    </iframe>
                                </template>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                                <button
                                    type="button"
                                    @click="showPreview = !showPreview"
                                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">

                                    <span x-show="!showPreview">
                                        Tinjau Laporan
                                    </span>

                                    <span x-show="showPreview">
                                        Sembunyikan Preview
                                    </span>

                                </button>
                                <button
                                    type="submit"
                                    name="actionusulan_kegiatan"
                                    value="accepted"
                                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold transition">
                                    Setujui Usulan
                                </button>
                                <button
                                    type="submit"
                                    name="actionusulan_kegiatan"
                                    value="rejected"
                                    class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                                    Tolak Usulan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>