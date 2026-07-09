<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> FORMULIR CETAK SURAT BALASAN LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan lengkapi data identitas surat balasan laporan kegiatan dan pastikan data yang diisikan telah sesuai sebelum mencetak surat balasan.
             </p>
        </div>
          
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

            {{-- 📝 FORM CETAK BALASAN LAPORAN KEGIATAN --}}
            <form id="balasanForm"
                action="{{ route('superadmin.balasanlaporankegiatan.cetak.store', $laporankegiatans->id) }}"
                method="POST">
                @csrf
                <input type="hidden"
                    name="laporankegiatan_id"
                    value="{{ $laporankegiatans->id }}">


                {{-- ================================================== --}}
                {{-- ======== BAGIAN 1: UPLOAD IDENTITAS SURAT ======== --}}
                {{-- ================================================== --}}
                <div x-data="previewBalasan()" class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat</label>
                            <div class="required">
                                <input type="text" name="nomor_surat"
                                    value="{{ $nomorSurat }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Tanggal Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Surat</label>
                            <div class="relative">
                                <input type="text"
                                id="tanggal_surat"
                                name="tanggal_surat"
                                value="{{ old('tanggal_surat') }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="dd-mm-yyyy"
                                required>
                                @error('tanggal_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Lampiran Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lampiran Surat</label>
                            <div class="relative">
                                <input type="text" name="lampiran_surat" value="1 Bendel"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                                @error('lampiran_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Sifat Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sifat Surat</label>
                            <div class="relative">
                                <select name="sifat_surat" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                    <option value="" disabled selected>-- Pilih sifat surat --</option>
                                    <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
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
                                <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="Permohonan Rekomendasi Kegiatan Workshop" required>
                                @error('perihal_surat')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- PREVIEW PDF --}}
                    <div x-show="showPreview"
                        x-transition
                        class="mt-6">

                        <h3 class="text-lg font-semibold text-gray-700 mb-4">
                            Preview Surat Balasan
                        </h3>

                        <iframe
                            :src="pdfUrl"
                            class="w-full h-[1200px] border rounded-lg">
                        </iframe>

                    </div>

                    {{-- =========================================== --}}
                    {{-- ========== BAGIAN 2: TOMBOL AKSI ========== --}}
                    {{-- =========================================== --}}
                    <div class="mt-6 flex justify-between items-center relative">

                        {{-- Kiri --}}
                        <button
                            type="button"
                            @click="togglePreview()"
                            class="px-6 py-2.5 rounded-lg bg-[#FFA41B] text-white font-semibold">
                            <span x-text="showPreview ? 'Sembunyikan Preview' : 'Tinjau Balasan'"></span>
                        </button>

                        {{-- Kanan --}}
                        <div class="flex gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 bg-[#FFA41B] text-white rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                                Cetak Balasan
                            </button>

                            <a href="{{ route('superadmin.laporankegiatan.pending') }}"
                                class="px-6 py-2.5 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition">
                                Selanjutnya
                            </a>
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

<script>
function previewBalasan() {
    return {
        showPreview: false,
        pdfUrl: '',

        async togglePreview() {

            this.showPreview = !this.showPreview;

            if (this.showPreview) {
                await this.generatePreview();
            }
        },

        async generatePreview() {

            const form = document.getElementById('balasanForm');
            const formData = new FormData(form);

            const res = await fetch(
                "{{ route('superadmin.balasanlaporankegiatan.preview', $laporankegiatans->id) }}",
                {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                }
            );

            const blob = await res.blob();

            this.pdfUrl = URL.createObjectURL(blob);
        }
    }
}
</script>

</x-app-layout>