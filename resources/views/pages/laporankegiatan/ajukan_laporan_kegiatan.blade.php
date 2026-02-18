<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Pengajuan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.laporankegiatan.store', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="laporankegiatan_id" value="{{ $usulankegiatans->laporankegiatans->id ?? '' }}">

                {{-- ====================================================== --}}
                {{-- === BAGIAN 1: AJUKAN DATA UTAMA LAPORAN HASIL KEGIATAN --}}
                {{-- ====================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Ajukan Data Utama Laporan Hasil Kegiatan Pengembangan Kompetensi ASN</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Unit Kerja yang Menyelenggarakan</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Sub Unit Kerja yang Menyelenggarakan</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Nama Kegiatan yang Diselenggarakan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="nama_kegiatan" value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Lokasi Kegiatan Diselenggarakan</label>
                            <input type="text" name="lokasi_kegiatan"
                                value="{{ old('lokasi_kegiatan', $usulankegiatans?->lokasi_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Cara Pelatihan yang Digunakan</label>
                            <select name="carapelatihan_id" class="border p-2 w-full" required>
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulankegiatans?->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan Mulai Diselenggarakan</label>
                            <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulankegiatans?->tanggalmulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan Selesai Diselenggarakan</label>
                            <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulankegiatans?->tanggalselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan Dimulai</label>
                            <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulankegiatans?->waktumulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan Berakhir</label>
                            <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulankegiatans?->waktuselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Perwakilan yang Mengajukan</label>
                            <input type="text"
                                value="{{ auth()->user()->nama }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>
                    </div>
                </div>
                    
                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Submit Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>