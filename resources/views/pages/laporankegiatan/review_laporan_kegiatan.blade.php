<div class="p-6" x-data="{ open: true }">

    <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-transition>
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">

            {{-- Button Close --}}
            <button @click="open = false" class="absolute top-2 right-3 text-gray-500 hover:text-gray-700">✕</button>

            {{-- Header Judul Laporan yang Direview --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-4">
                    Review Laporan Kegiatan: "{{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '' }}"
                </h2>
                <p class="text-gray-600">
                    Diajukan Oleh: {{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }} <br>
                    Lokasi Kegiatan: {{ $laporankegiatans->lokasi_kegiatan }} <br>
                    Tanggal Pelaksanaan: {{ $laporankegiatans->tanggalmulai_kegiatan && $laporankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan)->format('d-m-Y') . ' s/d ' .
                    \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan)->format('d-m-Y') : '-'}}
                </p>
            </div>

            {{-- Form Review Laporan --}}
            <form method="POST" action="{{ route('superadmin.laporankegiatan.reviewUpload', $laporankegiatans->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="catatan_verifikasilaporankegiatan" class="font-semibold">Catatan Review (Opsional)</label>
                    <textarea
                        name="catatan_verifikasilaporankegiatan"
                        id="catatan_verifikasilaporankegiatan"
                        class="border rounded w-full mt-2 p-2"
                        placeholder="Tuliskan catatan review untuk OPD"></textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex gap-2 justify-end">
                    <button
                        type="submit"
                        name="actionlaporan_kegiatan"
                        value="accepted"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Setujui Laporan
                    </button>
                    <button
                        type="submit"
                        name="actionlaporan_kegiatan"
                        value="rejected"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>