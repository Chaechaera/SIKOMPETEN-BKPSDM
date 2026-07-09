@php
$identitas = $usulankegiatan
    ->inputusulankegiatans
    ?->kirimbalasanusulankegiatans
    ?->identitassurats;
@endphp

<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- 📝 FORM KIRIM BALASAN USULAN KEGIATAN --}}
        <form method="POST" action="{{ route('superadmin.balasanusulankegiatan.kirim', $usulankegiatan->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="usulankegiatan_id" value="{{ $usulankegiatan->id }}">
            <input type="hidden" name="next_route" value="superadmin.balasanusulankegiatan.kirim">

            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR KIRIM BALASAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Silahkan lengkapi data kirim balasan usulan kegiatan pada form ini dan pastikan data yang diisikan telah sesuai sebelum dikirim.
                </p>
            </div>

            {{-- ================================================== --}}
            {{-- ======== BAGIAN 1: HIDDEN IDENTITAS SURAT ======== --}}
            {{-- ================================================== --}}
            <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Nomor Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Nomor Surat
                        </label>

                        {{-- Ditampilkan ke user --}}
                        <input
                            type="text"
                            value="{{ $identitas?->nomor_surat }}"
                            readonly
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2">

                        {{-- Tetap dikirim saat submit --}}
                        <input
                            type="hidden"
                            name="nomor_surat"
                            value="{{ $identitas?->nomor_surat }}">
                    </div>

                    {{-- Tanggal Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Surat</label>

                        <input
                            type="date"
                            value="{{ $identitas?->tanggal_surat }}"
                            readonly
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2">

                        <input
                            type="hidden"
                            name="tanggal_surat"
                            value="{{ $identitas?->tanggal_surat }}">
                    </div>

                    {{-- Lampiran Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lampiran Surat</label>

                        <input
                            type="text"
                            value="{{ $identitas?->lampiran_surat }}"
                            readonly
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2">

                        <input
                            type="hidden"
                            name="lampiran_surat"
                            value="{{ $identitas?->lampiran_surat }}">
                    </div>

                    {{-- Sifat Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sifat Surat</label>

                        <select
                            disabled
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2">

                            <option selected>
                                {{ $identitas?->sifat_surat }}
                            </option>
                        </select>

                        <input
                            type="hidden"
                            name="sifat_surat"
                            value="{{ $identitas?->sifat_surat }}">
                    </div>

                    {{-- Perihal Surat --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perihal Surat</label>

                        <input
                            type="text"
                            value="{{ $identitas?->perihal_surat }}"
                            readonly
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-[#e8ecff] p-2">

                        <input
                            type="hidden"
                            name="perihal_surat"
                            value="{{ $identitas?->perihal_surat }}">
                    </div>

                    {{-- ===================================================== --}}
                    {{-- === BAGIAN 2: UPLOAD FILE BALASAN USULAN KEGIATAN === --}}
                    {{-- ===================================================== --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Upload File Balasan Usulan Kegiatan Final
                            <span class="text-gray-400 text-sm">(PDF/DOC/DOCX)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .pdf / .doc / .docx</p>
                        <p class="text-xs text-gray-500">Contoh nama file: file_balasan_usulan_kegiatan.pdf</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="filekirim_balasanusulankegiatan" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" required>
                            @error('filekirim_balasanusulankegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- =========================================== --}}
                {{-- ========== BAGIAN 3: TOMBOL AKSI ========== --}}
                {{-- =========================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                        class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                        Batal Kirim
                    </a>
                    <button type="submit"
                        class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                        Kirim Balasan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>