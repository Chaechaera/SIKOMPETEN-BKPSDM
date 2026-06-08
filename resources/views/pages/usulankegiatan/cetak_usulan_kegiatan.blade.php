<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- 📝 FORM CETAK USULAN KEGIATAN --}}
            <form id="formCetakUsulan" method="POST" action="{{ route('admin.usulankegiatan.cetak', $usulan->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR CETAK PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan lengkapi data identitas surat sebelum mencetak usulan kegiatan.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulan" />

                {{-- ================================================== --}}
                {{-- ======= BAGIAN 1: DATA IDENTITAS SURAT ======= --}}
                {{-- ================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <h3 class="text-lg font-bold text-[#5A5A5A] mb-4">Data Identitas Surat</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat</label>
                            <div class="required">
                                <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->nomor_surat ?? '') }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="12/X/BKPSDM/001" required>
                                @error('nomor_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Surat</label>
                            <div class="relative">
                                <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->tanggal_surat ?? '') }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('tanggal_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Lampiran Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lampiran Surat</label>
                            <div class="relative">
                                <input type="text" name="lampiran_surat" value="{{ old('lampiran_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->lampiran_surat ?? '1 Bendel') }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                                @error('lampiran_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Sifat Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sifat Surat</label>
                            <div class="relative">
                                <select name="sifat_surat" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                    <option value="" disabled selected>-- Pilih sifat surat --</option>
                                    <option value="Penting" {{ old('sifat_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->sifat_surat ?? '') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="Rahasia" {{ old('sifat_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->sifat_surat ?? '') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
                                </select>
                                @error('sifat_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Perihal Surat --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perihal Surat</label>
                            <div class="relative">
                                <input type="text" name="perihal_surat" value="{{ old('perihal_surat', $usulan->cetakusulankegiatans?->inputusulankegiatans?->identitassurats?->perihal_surat ?? '') }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="Permohonan Rekomendasi Kegiatan Workshop" required>
                                @error('perihal_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- =========================================== --}}
                    {{-- ========== BAGIAN 2: TOMBOL AKSI ========== --}}
                    {{-- =========================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.usulankegiatan.index') }}"
                            class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                            Batal
                        </a>
                        <button
                            type="button"
                            id="btnPreview"
                            class="w-2/12 text-center py-2.5 bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white px-6 rounded-lg text-sm hover:opacity-90 transition font-semibold">
                            Tinjau Usulan
                        </button>
                        <button type="submit"
                            class="w-2/12 text-center py-2.5 bg-gradient-to-r from-[#5b78f8] to-[#3651d4] text-white px-6 rounded-lg text-sm hover:opacity-90 transition font-semibold">
                            Cetak Usulan
                        </button>
                    </div>
                </div>
                <div id="previewContainer"
                    class="hidden mt-8 bg-white shadow-lg rounded-lg border">

                    <div class="px-4 py-3 border-b">
                        <h3 class="font-semibold text-gray-700">
                            Preview Dokumen Usulan
                        </h3>
                    </div>

                    <iframe
                        id="pdfPreview"
                        class="w-full h-[900px]">
                    </iframe>

                </div>
            </form>
        </main>
    </div>

    <script>
    document.getElementById('btnPreview')
    .addEventListener('click', function () {

        const form = document.getElementById('formCetakUsulan');

        const formData = new FormData(form);

        fetch(
            "{{ route('admin.usulankegiatan.preview', $usulan->id) }}",
            {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            }
        )
        .then(response => response.blob())
        .then(blob => {

            const url = URL.createObjectURL(blob);

            document.getElementById('pdfPreview').src = url;

            document
                .getElementById('previewContainer')
                .classList
                .remove('hidden');
        });
    });

    </script>
</x-app-layout>
