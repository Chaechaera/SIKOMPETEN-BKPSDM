<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Upload Bukti Pelaksanaan Kegiatan
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" value="{{ $usulankegiatans->nama_kegiatan }}" class="border rounded w-full p-2 bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Lokasi Kegiatan</label>
                    <input type="text" name="lokasi_kegiatan" value="{{ $usulankegiatans->lokasi_kegiatan }}" class="border rounded w-full p-2 bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Lokasi Kegiatan</label>
                    <input type="date" name="tanggalpelaksanaan_kegiatan" value="{{ $usulankegiatans->tanggalpelaksanaan_kegiatan }}" class="border rounded w-full p-2 bg-gray-100" readonly>
                </div>

                <div class="mt-4">
                    <label class="block font-medium">Unggah Bukti Pelaksanaan Kegiatan (JPG, PNG, JPEG)</label>
                    <input type="file" name="buktipelaksanaan_kegiatan[]" accept=".jpg,.png,.jpeg"
                        class="border p-2 w-full" multiple id="buktipelaksanaan_kegiatanFiles" required>
                    @error('buktipelaksanaan_kegiatan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Tempat munculnya daftar file -->
        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </button>
                    <button type="submit" name="statususulan_kegiatan" value="in_progress"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Ambil elemen input dan daftar file
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