<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Card Informasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">
                FORMULIR UPLOAD BUKTI PELAKSANAAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN
            </h1>
            <p class="text-sm text-abuabuCerah max-w-5xl">
                Silahkan upload gambar bukti pelaksanaan kegiatan pada form ini dan pastikan bahwa gambar yang diunggah sesuai dengan kegiatan yang dilaksanakan.
            </p>
        </div>

        <!-- Card
        <div class="w-full max-w-7xl relative">-->

            {{-- Form --}}
            <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ====================================================== --}}
                {{-- ============= BAGIAN 1: RINGKASAN DATA OPD ============= --}}
                {{-- ====================================================== --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-6">
                    <h2 class="text-lg font-bold bg-primary-gradient bg-clip-text text-transparent leading-tight mb-4">Ringkasan Data Kegiatan Pengembangan Kompetensi ASN yang Dilaksanakan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-abuabuCerah/70"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->lokasi_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>

                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Pelaksanaan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan
                                ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                                  \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y')
                                : '-' }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>
                    </div>
                </div>

                {{-- Upload --}}
                <div class="md:col-span-2 mt-2">

                    <label class="block text-sm font-medium text-gray-700">
                        Unggah Bukti Pelaksanaan
                    </label>

                    <p class="text-xs text-gray-500 mt-1">
                        Format: .jpg / .png / .jpeg | Maksimal 5 file
                    </p>

                    <label id="dropArea"
                        class="mt-3 flex flex-col items-center justify-center h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition">

                        <i class="fa-solid fa-upload text-2xl text-gray-500 mb-2"></i>

                        <span class="text-sm text-gray-500">
                            Klik untuk upload atau drag & drop
                        </span>

                        <input type="file"
                            id="buktipelaksanaan_kegiatanFiles"
                            name="buktipelaksanaan_kegiatan[]"
                            class="hidden"
                            accept=".jpg,.jpeg,.png"
                            multiple
                            required>
                    </label>

                    {{-- Table --}}
                    <div class="mt-4 overflow-hidden rounded-xl border border-gray-200">
                        <table class="w-full text-sm">

                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left w-16">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Nama File
                                    </th>

                                    <th class="px-4 py-3 text-center w-40">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="fileList" class="divide-y divide-gray-200">
                            </tbody>

                        </table>
                    </div>

                </div>

                {{-- Textarea --}}
                <div class="space-y-5 mt-6">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Pelaksanaan
                        </label>

                        <textarea
                            name="catatan_pelaksanaan"
                            rows="4"
                            class="w-full rounded-lg border border-[#E0E7FF] p-3 text-sm"
                            placeholder="Tuliskan catatan penting selama pelaksanaan kegiatan...">{{ old('catatan_pelaksanaan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Hambatan Pelaksanaan
                        </label>

                        <textarea
                            name="hambatan_pelaksanaan"
                            rows="4"
                            class="w-full rounded-lg border border-[#E0E7FF] p-3 text-sm"
                            placeholder="Tuliskan hambatan yang ditemukan selama pelaksanaan kegiatan...">{{ old('hambatan_pelaksanaan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Solusi untuk Hambatan
                        </label>

                        <textarea
                            name="solusi_hambatan_pelaksanaan"
                            rows="4"
                            class="w-full rounded-lg border border-[#E0E7FF] p-3 text-sm"
                            placeholder="Tuliskan solusi yang dilakukan untuk mengatasi hambatan tersebut...">{{ old('solusi_hambatan_pelaksanaan') }}</textarea>
                    </div>

                </div>

        </div>

        {{-- ===================================================== --}}
        {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
        {{-- ===================================================== --}}
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.usulankegiatan.index') }}"
                class="w-2/12 text-center py-2.5 bg-abuabuMuda rounded-lg font-semibold hover:bg-abuabuMuda/60 transition">
                Batal
            </a>
            <button type="submit"
                class="w-2/12 py-2.5 bg-orangeMuda text-white rounded-lg font-semibold hover:bg-orangeMuda/80 transition">
                Simpan
            </button>
        </div>

        </form>

    </div>

    {{-- SCRIPT --}}
    <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('buktipelaksanaan_kegiatanFiles');
        const fileList = document.getElementById('fileList');

        let selectedFiles = [];

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('bg-blue-50');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('bg-blue-50');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('bg-blue-50');
            handleFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        function handleFiles(files) {
            const allowed = ['image/jpeg', 'image/png', 'image/jpg'];

            for (let file of files) {
                if (!allowed.includes(file.type)) {
                    alert(file.name + ' bukan gambar!');
                    continue;
                }

                if (selectedFiles.length >= 5) {
                    alert('Maksimal 5 file!');
                    break;
                }

                selectedFiles.push(file);
            }

            updateInput();
            tampilkanFile();
        }

        function updateInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
        }

        function tampilkanFile() {
            fileList.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const url = URL.createObjectURL(file);

                const tr = document.createElement('tr');
                tr.className = "border-t";

                tr.innerHTML = `
                    <td class="px-4 py-2">${index + 1}</td>
                    <td class="px-4 py-2">
                        ${file.name}
                        <div class="text-xs text-gray-400">${(file.size / 1024).toFixed(1)} KB</div>
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex justify-center items-center gap-2">
                            <button type="button"
                                onclick="previewFile('${url}')"
                                class="px-3 py-1 text-xs font-medium bg-blue-500 text-white rounded-md hover:bg-blue-600 transition whitespace-nowrap">
                                Preview
                            </button>

                            <button type="button"
                                onclick="hapusFile(${index})"
                                class="px-3 py-1 text-xs font-medium bg-red-500 text-white rounded-md hover:bg-red-600 transition whitespace-nowrap">
                                Hapus
                            </button>
                        </div>
                    </td>
                `;

                fileList.appendChild(tr);
            });
        }

        function hapusFile(index) {
            selectedFiles.splice(index, 1);
            updateInput();
            tampilkanFile();
        }

        function previewFile(url) {
            window.open(url, '_blank');
        }
    </script>
</x-app-layout>