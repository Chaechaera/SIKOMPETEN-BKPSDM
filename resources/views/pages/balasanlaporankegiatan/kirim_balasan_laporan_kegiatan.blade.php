<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> FORMULIR KIRIM BALASAN LAPORAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan lengkapi data kirim balasan laporan kegiatan pada form ini dan pastikan data yang diisikan telah sesuai sebelum dikirim.
            </p>
        </div>
     
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        {{-- 📝 FORM KIRIM BALASAN LAPORAN KEGIATAN --}}
        <form method="POST" action="{{ route('superadmin.balasanlaporankegiatan.kirim', $laporankegiatans->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="laporankegiatan_id" value="{{ $laporankegiatans->id }}">
            <input type="hidden" name="next_route" value="superadmin.balasanlaporankegiatan.kirim">

                {{-- ================================================== --}}
                {{-- ======== BAGIAN 1: UPLOAD IDENTITAS SURAT ======== --}}
                {{-- ================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                        {{-- ====================================================== --}}
                        {{-- === BAGIAN 2: UPLOAD FILE BALASAN LAPORAN KEGIATAN === --}}
                        {{-- ====================================================== --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Upload File Balasan Laporan Kegiatan Final
                                <span class="text-gray-400 text-sm">(PDF/DOC/DOCX)</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1">Format: .pdf / .doc / .docx</p>
                            <p class="text-xs text-gray-500">Contoh nama file: file_balasan_laporan_kegiatan.pdf</p>
                            <div class="relative mb-3 mt-2">
                                <input type="file" name="filekirim_balasanlaporankegiatan" accept=".pdf,.doc,.docx" class="block w-full text-sm text-gray-700
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC]
                                  focus:outline-none p-2" required>
                            @error('filekirim_balasanlaporankegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                    {{-- =========================================== --}}
                    {{-- ========== BAGIAN 3: TOMBOL AKSI ========== --}}
                    {{-- =========================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit"
                            class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                            Kirim Balasan
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#tanggal_surat", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

});
</script>
</x-app-layout>
