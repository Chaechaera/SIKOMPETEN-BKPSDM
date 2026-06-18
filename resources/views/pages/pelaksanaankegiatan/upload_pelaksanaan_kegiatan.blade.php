<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- Form --}}
            <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">
                        FORMULIR UPLOAD BUKTI PELAKSANAAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN
                    </h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan upload gambar bukti pelaksanaan kegiatan pada form ini dan pastikan bahwa gambar yang diunggah sesuai dengan kegiatan yang dilaksanakan.
                    </p>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                        Ringkasan Data Kegiatan Pengembangan Kompetensi ASN yang Dilaksanakan
                    </h2>

                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>
                    </div>

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>
                    </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->lokasi_kegiatan }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2"
                                readonly>
                        </div>
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

                        {{-- Upload --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Unggah Bukti Pelaksanaan
                                <span class="text-gray-400 text-sm">(JPG, PNG, JPEG)</span>
                            </label>

                            <p class="text-xs text-gray-500 mt-1">Format: .jpg / .png / .jpeg | Maksimal 5 file</p>

                            <label id="dropArea"
                                class="mt-2 border border-gray-300 rounded-lg px-3 py-6 flex flex-col items-center text-sm text-gray-500 cursor-pointer hover:bg-gray-50 transition">

                                <i class="fa-solid fa-upload text-2xl mb-2"></i>
                                Klik untuk upload atau drag & drop

                                <input type="file"
                                    id="buktipelaksanaan_kegiatanFiles"
                                    name="buktipelaksanaan_kegiatan[]"
                                    class="hidden"
                                    accept=".jpg,.png,.jpeg"
                                    multiple required>
                            </label>

                            {{-- TABLE --}}
                            <div class="mt-4">
                                <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 text-gray-600">
                                        <tr>
                                            <th class="px-4 py-2 w-10">No</th>
                                            <th class="px-4 py-2">Nama File</th>
                                            <th class="px-4 py-2 w-32 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="fileList"></tbody>
                                </table>
                            </div>

                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Catatan Pelaksanaan</label>
                            <textarea name="catatan_pelaksanaan" rows="4"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg p-3"
                                placeholder="Tuliskan catatan penting selama pelaksanaan kegiatan...">{{ old('catatan_pelaksanaan') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Hambatan Pelaksanaan</label>
                            <textarea name="hambatan_pelaksanaan" rows="4"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg p-3"
                                placeholder="Tuliskan hambatan yang ditemukan selama pelaksanaan kegiatan...">{{ old('hambatan_pelaksanaan') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Solusi untuk Hambatan</label>
                            <textarea name="solusi_hambatan_pelaksanaan" rows="4"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg p-3"
                                placeholder="Tuliskan solusi yang dilakukan untuk mengatasi hambatan tersebut...">{{ old('solusi_hambatan_pelaksanaan') }}</textarea>
                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.usulankegiatan.index') }}"
                            class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                            Batal
                        </a>

                        <button type="submit"
                            class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                            Submit
                        </button>
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

        fileInput.addEventListener('change', function () {
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