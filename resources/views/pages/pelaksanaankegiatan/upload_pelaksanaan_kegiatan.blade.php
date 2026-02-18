<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Upload Bukti Pelaksanaan Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- =================================================================== --}}
                {{-- === BAGIAN 1: Preview Data Kegiatan Pengembangan Kompetensi ASN === --}}
                {{-- =================================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">

                    {{-- Nama Kegiatan --}}
                    <div class="mb-4">
                        <label class="block font-medium">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" value="{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan }}" class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>

                    {{-- Lokasi Kegiatan --}}
                    <div class="mb-4">
                        <label class="block font-medium">Lokasi Kegiatan</label>
                        <input type="text" name="lokasi_kegiatan" value="{{ $usulankegiatans->lokasi_kegiatan }}" class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>

                    {{-- Tanggal Pelaksanaan --}}
                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Pelaksanaan Kegiatan</label>
                        <input type="text" name="tanggalpelaksanaan_kegiatan" value="{{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                        \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}" class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>

                    {{-- ========================================================= --}}
                    {{-- ======= BAGIAN 2: UPLOAD GAMBAR BUKTI PELAKSANAAN ======= --}}
                    {{-- ========================================================= --}}
                    <div class="mt-4">
                        <label class="block font-medium">Upload Gambar Bukti Pelaksanaan Kegiatan</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .jpg / .png / .jpeg</p>
                        <p class="text-sm text-gray-500">Contoh nama file: gambar_kegiatan_1.jpg</p>
                        <input type="file" name="buktipelaksanaan_kegiatan[]" accept=".jpg,.png,.jpeg" class="border p-2 w-full" multiple id="buktipelaksanaan_kegiatanFiles" required>
                        @error('buktipelaksanaan_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>
                    </div>

                    {{-- ===================================================== --}}
                    {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                    {{-- ===================================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <button href="{{ route('admin.usulankegiatan.index') }}"
                            class="bg-gray-500 hover:bg-gray-600 transition text-white font-semibold px-4 py-2 rounded">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                            Submit
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script>
        // Ambil elemen input upload gambar dan daftar file gambar
        const fileInput = document.getElementById('buktipelaksanaan_kegiatanFiles');
        const fileList = document.getElementById('fileList');

        // Event ketika user pilih file
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = ''; // kosongkan dulu

            // Kalau ada file yang dipilih
            for (let i = 0; i < this.files.length; i++) {
                const li = document.createElement('li');
                li.textContent = `${i + 1}. ${this.files[i].name}`;
                fileList.appendChild(li);
            }
        });
    </script>

</x-app-layout>