<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- 📝 FORM KIRIM USULAN KEGIATAN --}}
            <form method="POST" action="{{ route('admin.usulankegiatan.kirim', $usulankegiatan->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="usulankegiatan_id" value="{{ $usulankegiatan->id }}">
                <input type="hidden" name="next_route" value="admin.usulankegiatan.kirim">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR KIRIM PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan lengkapi data kirim usulan kegiatan pada form ini dan pastikan data yang diisikan telah sesuai sebelum dikirim.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulankegiatan" :is-laporan="false" />

                {{-- ================================================== --}}
                {{-- ======= BAGIAN 1: RINGKASAN DATA SURAT KIRIM ======= --}}
                {{-- ================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <h3 class="text-lg font-bold text-[#5A5A5A] mb-4">Ringkasan Data Identitas Surat</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat (Read Only) --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat</label>
                            <div class="relative">
                                <input type="text" value="{{ $usulankegiatan->cetakusulankegiatans?->identitassurats?->nomor_surat ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Tanggal Surat (Read Only) --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Surat</label>
                            <div class="relative">
                                <input type="text" value="{{ $usulankegiatan->cetakusulankegiatans?->identitassurats?->tanggal_surat? \Carbon\Carbon::parse($usulankegiatan->cetakusulankegiatans->identitassurats->tanggal_surat)->format('d-m-Y'): '-'}}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Lampiran Surat (Read Only) --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lampiran Surat</label>
                            <div class="relative">
                                <input type="text" value="{{ $usulankegiatan->cetakusulankegiatans?->identitassurats?->lampiran_surat ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Sifat Surat (Read Only) --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sifat Surat</label>
                            <div class="relative">
                                <input type="text" value="{{ $usulankegiatan->cetakusulankegiatans?->identitassurats?->sifat_surat ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Perihal Surat (Read Only) --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perihal Surat</label>
                            <div class="relative">
                                <input type="text" value="{{ $usulankegiatan->cetakusulankegiatans?->identitassurats?->perihal_surat ?? '-' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- ===================================================== --}}
                        {{-- ======= BAGIAN 2: UPLOAD FILE USULAN KEGIATAN ======= --}}
                        {{-- ===================================================== --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Upload File Usulan Kegiatan Final
                                <span class="text-gray-400 text-sm">(PDF/DOC/DOCX)</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Format: .pdf / .doc / .docx</p>
                            <p class="text-xs text-gray-500">Contoh nama file: file_usulan_kegiatan.pdf</p>
                            <div class="relative mb-3 mt-2">
                                <input type="file" name="filekirim_inputusulankegiatan" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" {{ $usulankegiatan && $usulankegiatan?->inputusulankegiatans?->kirimusulankegiatans?->filekirim_inputusulankegiatan ? '' : 'required' }}>
                                @if($usulankegiatan?->inputusulankegiatans?->kirimusulankegiatans?->filekirim_inputusulankegiatan)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/'.$usulankegiatan?->inputusulankegiatans?->kirimusulankegiatans?->filekirim_inputusulankegiatan) }}" target="_blank" class="text-blue-600">
                                            {{ basename($usulankegiatan?->inputusulankegiatans?->kirimusulankegiatans?->filekirim_inputusulankegiatan) }}
                                        </a>
                                    </p>
                                </div>
                                @endif
                                @error('filekirim_inputusulankegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- =========================================== --}}
                    {{-- ========== BAGIAN 3: TOMBOL AKSI ========== --}}
                    {{-- =========================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('admin.usulankegiatan.index') }}"
                            class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                            Batal Kirim
                        </a>
                        <button type="submit"
                            class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                            Kirim Usulan
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>