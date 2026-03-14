<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Laporan Peserta - SIKOMPETEN</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans antialiased">

    {{-- Navbar --}}
    @include('components.izin-navbar')

    {{-- Main Content --}}
    <div class="min-h-screen bg-gray-100 pt-24 pb-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Card --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">
                    UPLOAD LAPORAN PESERTA KEGIATAN
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    Silahkan upload laporan peserta sebelum mengunduh sertifikat
                </p>
            </div>

            {{-- Alert --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-red-800 text-sm mb-1">Error</h3>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Informasi Kegiatan --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-lg font-bold text-[#2B3674] mb-4">📋 Informasi Kegiatan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 font-semibold">Nama Kegiatan</label>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $sertifikat->laporankegiatans?->inputlaporankegiatans?->inputusulankegiatans?->nama_kegiatan ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 font-semibold">Nama Peserta</label>
                        <p class="font-semibold text-gray-800 mt-1">{{ $peserta->nama_peserta }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 font-semibold">NIP/NIK</label>
                        <p class="font-semibold text-gray-800 mt-1">{{ $peserta->nip_nik_peserta }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 font-semibold">Nomor Sertifikat</label>
                        <p class="font-semibold text-gray-800 mt-1">{{ $peserta->nomorsertifikatpeserta_kegiatan }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Upload Laporan --}}
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="text-lg font-bold text-[#2B3674] mb-4">📝 Form Upload Laporan</h2>

                <form action="{{ route('user.laporanpeserta.store', $sertifikat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Deskripsi Laporan --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Deskripsi Laporan
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="filelaporan_pesertakegiatan"
                            rows="5"
                            class="w-full border border-[#E0E7FF] rounded-lg focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-3 text-sm"
                            placeholder="Jelaskan hasil dan pembelajaran dari kegiatan ini, materi yang dikuasai, dan kontribusi Anda..."
                            required>{{ old('filelaporan_pesertakegiatan', $laporanPeserta->deskripsi_laporan ?? '') }}</textarea>
                        @error('filelaporan_pesertakegiatan')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Upload File Laporan
                            <span class="text-red-500">*</span>
                            <span class="text-gray-400 text-xs">(PDF/DOC/DOCX, Max 5MB)</span>
                        </label>

                        @if($laporanPeserta?->filelaporan_pesertakegiatan)
                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-700 font-medium">
                                    ✓ File saat ini tersimpan:
                                </p>
                                <a href="{{ asset('storage/' . $laporanPeserta->filelaporan_pesertakegiatan) }}"
                                   target="_blank"
                                   class="text-sm text-blue-600 underline hover:text-blue-800">
                                    {{ basename($laporanPeserta->filelaporan_pesertakegiatan) }}
                                </a>
                            </div>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Uploaded</span>
                        </div>
                        @endif

                        <div class="border-2 border-dashed border-[#E0E7FF] rounded-lg p-6 bg-[#F9FAFF] hover:bg-[#F0F1FF] transition text-center cursor-pointer" id="dropZone">
                            <input
                                type="file"
                                name="filelaporan_pesertakegiatan"
                                id="file_laporan"
                                accept=".pdf,.doc,.docx"
                                class="hidden"
                                required>

                            <label for="file_laporan" class="cursor-pointer">
                                <svg class="w-10 h-10 text-[#A5B4FC] mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700 mb-1">
                                    Klik untuk upload atau drag & drop
                                </p>
                                <p class="text-xs text-gray-500">
                                    PDF, DOC, DOCX (Max 5MB)
                                </p>
                            </label>

                            <div id="fileName" class="mt-2 text-sm text-green-600 font-medium hidden"></div>
                        </div>
                        @error('filelaporan_pesertakegiatan')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('user.sertifikat') }}"
                            class="px-6 py-2.5 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 bg-[#FFA41B] text-white rounded-lg font-semibold hover:bg-[#ff9600] transition">
                            Upload Laporan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info Card --}}
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-sm text-blue-800">
                <strong>ℹ️ Informasi:</strong> Setelah upload laporan ini, Anda dapat mengunduh sertifikat Anda. Laporan ini digunakan untuk verifikasi kehadiran dan partisipasi dalam kegiatan.
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('components.izin-footer')

    <script>
        const fileInput = document.getElementById('file_laporan');
        const fileNameDisplay = document.getElementById('fileName');
        const dropZone = document.getElementById('dropZone');

        // Handle file selection
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                fileNameDisplay.textContent = '✓ File dipilih: ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileNameDisplay.classList.remove('hidden');
            }
        });

        // Handle drag & drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-[#E0E7FF]', 'border-[#A5B4FC]');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-[#E0E7FF]', 'border-[#A5B4FC]');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-[#E0E7FF]', 'border-[#A5B4FC]');
            fileInput.files = e.dataTransfer.files;
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        });
    </script>
</body>

</html>
