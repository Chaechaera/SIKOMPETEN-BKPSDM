<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIKOMPETEN</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans antialiased">

    {{-- Navbar --}}
    @include('components.izin-navbar')

    {{-- Background utama --}}
    <div class="min-h-screen pt-24">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-4 pb-12">

            {{-- Card Formulir --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">
                <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">FORMULIR UPLOAD LAPORAN KEIKUTSERTAAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-abuabuCerah max-w-6xl">
                    Silahkan upload laporan hasil keikutsertaan kegiatan Pengembangan Kompetensi ASN agar dapat segera divalidasi dan Anda bisa mengunduh sertifikat kegiatan
                </p>
            </div>

            <form action="{{ route('user.laporanpeserta.store', $sertifikat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- =================================================================== --}}
                {{-- === BAGIAN 1: Preview Data Kegiatan Pengembangan Kompetensi ASN === --}}
                {{-- =================================================================== --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8 mt-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Nama Kegiatan Pengembangan Kompetensi yang Diikuti</label>
                            <div class="relative">
                                <input type="text" name="nama_kegiatan" value="{{ $sertifikat->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}"
                                    class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Lokasi Kegiatan Pengembangan Kompetensi Berlangsung</label>
                            <div class="relative">
                                <input type="text" name="lokasi_kegiatan" value="{{ $sertifikat->laporankegiatans->lokasi_kegiatan ?? '-' }}"
                                    class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Tanggal Pelaksanaan Kegiatan Pengembangan Kompetensi</label>
                            <div class="relative">
                                <input type="text" name="tanggalpelaksanaan_kegiatan" value="{{ $sertifikat->laporankegiatans->tanggalmulai_kegiatan && $sertifikat->laporankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($sertifikat->laporankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                            \Carbon\Carbon::parse($sertifikat->laporankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}"
                                    class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- NIP/NIK Peserta Kegiatan --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">NIP/NIK Peserta Kegiatan</label>
                            <div class="relative">
                                <input type="text" name="nipnikpeserta_kegiatan" value="{{ $peserta->nip_nik_peserta ?? '-' }}"
                                    class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Nama Peserta Kegiatan --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Nama Peserta Kegiatan</label>
                            <div class="relative">
                                <input type="text" name="namapeserta_kegiatan" value="{{ $peserta->nama_peserta ?? '-' }}"
                                    class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Data Detail --}}
                        @php
                        $fields = [
                        'uraianpeserta_kegiatan' => [
                        'label' => 'Uraian Kegiatan',
                        'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                        'numbering' => false
                        ],
                        'tujuanpeserta_kegiatan' => [
                        'label' => 'Tujuan Kegiatan',
                        'placeholder' => '1. Mensejahterakan masyarakat&#10;2. Mendukung visi misi pemerintah&#10;3. dst',
                        'numbering' => true
                        ],
                        'rangkumanpeserta_kegiatan' => [
                        'label' => 'Rangkuman Kegiatan',
                        'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                        'numbering' => false
                        ],
                        'kesimpulanpeserta_kegiatan' => [
                        'label' => 'Kesimpulan Kegiatan',
                        'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                        'numbering' => false
                        ],
                        'hambatanpeserta_kegiatan' => [
                        'label' => 'Hambatan Kegiatan',
                        'placeholder' => 'Tuliskan hambatan yang dialami selama mengikuti kegiatan (Opsional)',
                        'numbering' => false,
                        'optional' => true,
                        ],
                        'solusipeserta_kegiatan' => [
                        'label' => 'Solusi atas Hambatan',
                        'placeholder' => 'Tuliskan solusi terhadap hambatan yang dialami (Opsional)',
                        'numbering' => false,
                        'optional' => true,
                        ],
                        ];
                        @endphp

                        @foreach($fields as $name => $field)
                        <div class="md:col-span-2">
                            <div class="flex justify-between items-center">
                                <label class="block text-sm font-medium text-abuabuDark mb-2">
                                    {{ $field['label'] }}

                                    @if(!empty($field['optional']))
                                    <span class="text-xs text-abuabuBesi">(Opsional)</span>
                                    @endif
                                </label>
                            </div>
                            <div class="relative">
                                @if($field['placeholder'])
                                <pre id="sample-{{ $name }}"
                                    class="hidden bg-gray-50 border-gray-300 rounded-lg px-3 py-2 mt-2 w-full text-sm whitespace-pre-wrap">
                                {{ $field['placeholder'] }}
                                </pre>
                                @endif
                                <textarea
                                    name="{{ $name }}"
                                    placeholder="{!! $field['placeholder'] !!}"
                                    data-numbering="{{ $field['numbering'] ? 'true' : 'false' }}"
                                    class="overflow-hidden smart-textarea block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruMuda placeholder:font-normal placeholder:text-abuabuBesi focus:ring-2 focus:outline-none p-2 resize-none">{{ old($name, $laporanpesertakegiatans->$name ?? '') }}</textarea>
                                @error($name)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @endforeach

                        {{-- Gambar Dokumentasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-abuabuDark mb-2">
                                Unggah Gambar Dokumentasi Kegiatan
                                <span class="text-abuabuCerah text-sm">(JPG, PNG, JPEG)</span>
                            </label>
                            <p class="font-normal text-xs text-abuabuBesi mt-1">Format: .jpg / .png / .jpeg</p>
                            <p class="font-normal text-xs text-abuabuBesi">Contoh nama file: gambar_kegiatan_1.jpg</p>
                            <div id="dropArea" class="relative mb-3 mt-2">
                                <input type="file" id="fileInput" name="dokumentasipeserta_kegiatan[]" accept=".jpg,.png,.jpeg" class="block w-full font-medium text-sm text-abuabuDark 
                                  border border-abuabuMuda rounded-lg cursor-pointer
                                  bg-biruMuda focus:ring-2 file:text-xs file:font-medium file:bg-abuabuMuda file:py-2 file:px-3 file:rounded-md file:border-[0.5px]
                                  focus:outline-none p-2" multiple required>
                                @if($laporanpesertakegiatans?->dokumentasipeserta_kegiatan)
                                <div class="mt-2">
                                    <span>
                                        <p class="text-xs text-gray-500">File saat ini:
                                            {{-- <a href="{{ asset('storage/'.$laporanpesertakegiatans->dokumentasipeserta_kegiatan) }}" target="_blank" class="text-blue-600">
                                            {{ basename($laporanpesertakegiatans->dokumentasipeserta_kegiatan) }}
                                            </a> --}}
                                        </p>
                                        {{-- <img src="{{ asset('storage/'.$laporanpesertakegiatans->dokumentasipeserta_kegiatan) }}"
                                        class="h-16 rounded border"> --}}
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            @foreach($laporanpesertakegiatans->dokumentasipeserta_kegiatan as $index => $img)
                                            <div class="relative">
                                                <img src="{{ asset('storage/'.$img) }}"
                                                    class="h-24 w-full object-cover rounded border">

                                                {{-- tombol hapus --}}
                                                <label class="absolute top-1 right-1 bg-white px-1 text-xs rounded shadow">
                                                    <input type="checkbox" name="hapus_gambar[]" value="{{ $index }}">
                                                    ✕
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </span>
                                </div>
                                @endif
                                @error('dokumentasipeserta_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <ul id="fileList" class="mt-2 list-disc list-inside font-normal text-xs text-abuabuBesi"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-3 text-base text-center mb-6">
                    <a href="{{ route('user.sertifikat') }}"
                        class="px-4 py-4 w-60 bg-abuabuMuda rounded-lg font-semibold hover:bg-abuabuMuda/60 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-4 w-60 bg-orangeMuda text-white rounded-lg font-semibold hover:bg-orangeMuda/80 transition">
                        Upload Laporan
                    </button>
                </div>
            </form>
            </main>
        </div>
    </div>

    <script>
        /* Untuk Eksekusi Ukuran Textarea */
        // Event untuk textarea 
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.smart-textarea').forEach(textarea => {
                resizeTextarea(textarea);
                textarea.addEventListener('input', function() {
                    resizeTextarea(this);
                });
                textarea.addEventListener('paste', function() {
                    setTimeout(() => resizeTextarea(this), 50);
                });
                textarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && this.dataset.numbering === 'true') {
                        e.preventDefault();
                        let lines = this.value.split("\n");
                        let lastLine = lines[lines.length - 1];
                        let match = lastLine.match(/^(\d+)\./);
                        let nextNumber = match ?
                            parseInt(match[1]) + 1 :
                            lines.length + 1;
                        this.value += "\n" + nextNumber + ". ";
                        resizeTextarea(this);
                    }
                });
            });
        });

        // Fungsi untuk resize textarea
        function resizeTextarea(el) {
            el.style.height = "auto";
            el.style.height = el.scrollHeight + "px";
        }

        // Fungsi untuk menampilkan list sample
        function toggleSample(name) {
            document
                .getElementById('sample-' + name)
                .classList
                .toggle('hidden');
        }
        // Event untuk drag and drop dan pilih gambar
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        let allFiles = new DataTransfer(); // 🔥 penampung semua file

        // klik area = buka file picker
        dropArea.addEventListener('click', () => fileInput.click());

        // drag over
        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('border-orange-400');
        });

        // drag leave
        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('border-orange-400');
        });

        // drop file
        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('border-orange-400');

            addFiles(e.dataTransfer.files);
        });

        // pilih manual
        fileInput.addEventListener('change', () => {
            addFiles(fileInput.files);
        });

        fileInput.addEventListener('click', (e) => {
            e.stopPropagation();
        });

        function addFiles(files) {
            [...files].forEach(file => {
                allFiles.items.add(file); // ✅ nambah, bukan replace
            });

            fileInput.files = allFiles.files; // update ke input
            displayFiles();
        }

        function displayFiles() {
            fileList.innerHTML = '';

            [...allFiles.files].forEach((file, index) => {
                const li = document.createElement('li');
                li.className = "flex justify-between items-center";

                li.innerHTML = `
                <span>${file.name}</span>
                <button type="button" class="text-red-500 text-xs" onclick="removeFile(${index})">Hapus</button>
            `;

                fileList.appendChild(li);
            });
        }

        function removeFile(index) {
            let newFiles = new DataTransfer();

            [...allFiles.files].forEach((file, i) => {
                if (i !== index) newFiles.items.add(file);
            });

            allFiles = newFiles;
            fileInput.files = allFiles.files;
            displayFiles();
        }
    </script>

    {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>