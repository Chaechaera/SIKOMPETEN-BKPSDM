<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Form --}}
        <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR UPLOAD BUKTI PELAKSANAAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Silahkan upload gambar bukti pelaksanaan kegiatan pada form ini dan pastikan bahwa gambar yang diunggah sesuai dengan kegiatan yang dilaksanakan.
                </p>
            </div>

            {{-- =================================================================== --}}
            {{-- === BAGIAN 1: Preview Data Kegiatan Pengembangan Kompetensi ASN === --}}
            {{-- =================================================================== --}}
            <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                    Ringkasan Data Kegiatan Pengembangan Kompetensi ASN yang Dilaksanakan
                </h2>

                <!-- 🔻 DIVIDER -->
                <div class="my-4 border-t-2 border-gray-200"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Nomor Surat Kegiatan yang Dilaksanakan --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="nomor_surat" value="{{ $usulankegiatans->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            @error('nomor_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Nama Kegiatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="nama_kegiatan" value="{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            @error('nama_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Lokasi Kegiatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="lokasi_kegiatan" value="{{ $usulankegiatans->lokasi_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            @error('lokasi_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Lokasi Kegiatan --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Pelaksanaan Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="tanggalpelaksanaan_kegiatan" value="{{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                            \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            @error('tanggalpelaksanaan_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Bukti --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah Bukti Pelaksanaan
                            <span class="text-gray-400 text-sm">(JPG, PNG, JPEG)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .jpg / .png / .jpeg</p>
                        <p class="text-xs text-gray-500">Contoh nama file: bukti_pelaksanaan_kegiatan.jpg</p>
                        <label id="dropArea" class="mt-2 border border-gray-300 rounded-lg px-3 py-6 flex flex-col items-center text-sm text-gray-500 cursor-pointer hover:bg-gray-50 transition">
                            <i class="fa-solid fa-upload text-2xl mb-2"></i>
                            Klik untuk upload atau drag & drop
                            <input
                                type="file"
                                id="buktipelaksanaan_kegiatanFiles"
                                name="buktipelaksanaan_kegiatan[]"
                                class="hidden w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                accept=".jpg,.png,.jpeg"
                                multiple
                                required>
                        </label>

                        {{-- Daftar file --}}
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>

                        @error('buktipelaksanaan_kegiatan')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button href="{{ route('admin.usulankegiatan.index') }}"
                        class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Ambil elemen input upload gambar dan daftar file gambar
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('buktipelaksanaan_kegiatanFiles');
        const fileList = document.getElementById('fileList');

        // ====== DRAG OVER ======
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault(); // WAJIB
            dropArea.classList.add('bg-blue-50');
        });

        // ====== DRAG LEAVE ======
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('bg-blue-50');
        });

        // ====== DROP ======
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('bg-blue-50');

            const files = e.dataTransfer.files;
            fileInput.files = files;

            tampilkanFile(files);
        });

        // ====== CHANGE (klik upload) ======
        fileInput.addEventListener('change', function() {
            tampilkanFile(this.files);
        });

        // ====== fungsi tampilkan ======
        function tampilkanFile(files) {
            fileList.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const li = document.createElement('li');
                li.textContent = `${i + 1}. ${files[i].name}`;
                fileList.appendChild(li);
            }
        }
    </script>

</x-app-layout>