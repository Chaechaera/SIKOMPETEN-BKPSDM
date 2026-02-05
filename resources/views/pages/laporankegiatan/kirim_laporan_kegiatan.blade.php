<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Kirim File Laporan Kegiatan Pengembangan Kompetensi ASN
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.laporankegiatan.kirim', $laporankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="laporankegiatan_id" value="{{ $laporankegiatans->id }}">
                <input type="hidden" name="next_route" value="admin.laporankegiatan.kirim">

                {{-- ===================================================== --}}
                {{-- BAGIAN 1: IDENTITAS SURAT --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Identitas Surat</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Nomor Surat</label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan nomor surat">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perihal Surat</label>
                        <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan perihal">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lampiran Surat</label>
                        <input type="text" name="lampiran_surat" value="1 Bendel"
                            class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Sifat Surat</label>
                        <select name="sifat_surat" class="border rounded w-full p-2">
                            <option value="" disabled selected>-- Pilih sifat surat --</option>
                            <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                            <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                        </select>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: FILE USULAN KEGIATAN --}}
                {{-- ===================================================== --}}

                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Input File Laporan Kegiatan</h2>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah File Laporan Kegiatan</label>
                        <input type="file" name="filekirim_inputlaporankegiatan" accept=".pdf,.doc,.docx" class="border p-2 w-full">
                        @error('filekirim_inputlaporankegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- TOMBOL AKSI --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit" name="statuslaporan_kegiatan" value="need_review"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>