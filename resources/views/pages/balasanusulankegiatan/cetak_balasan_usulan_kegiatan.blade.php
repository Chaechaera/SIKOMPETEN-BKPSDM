<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> FORMULIR CETAK SURAT BALASAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan lengkapi data identitas surat balasan laporan kegiatan dan pastikan data yang diisikan telah sesuai sebelum mencetak surat balasan.
            </p>
        </div>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        {{-- 📝 FORM CETAK USULAN KEGIATAN --}}
        <form id="balasanForm"
            action="{{ route('superadmin.balasanusulankegiatan.cetak.store', $usulankegiatans->id) }}"
            method="POST">
            @csrf

            <input type="hidden"
                name="usulankegiatan_id"
                value="{{ $usulankegiatans->id }}">


            {{-- ================================================== --}}
            {{-- ======== BAGIAN 1: UPLOAD IDENTITAS SURAT ======== --}}
            {{-- ================================================== --}}
            <div x-data="previewBalasan()" class="bg-white shadow-lg rounded-lg p-6 mb-10">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Nomor Surat --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Surat</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="nomor_surat"
                                value="{{ $nomorSurat }}"
                                readonly
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg bg-gray-100 p-2">
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

                {{-- ================================================== --}}
                {{-- PENGATURAN DOKUMEN --}}
                {{-- ================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">

                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent mb-4">
                        Pengaturan Dokumen
                    </h2>

                    <div class="space-y-4">

                        {{-- Toggle TTD --}}
                        <label class="flex items-center justify-between border rounded-lg p-4">

                            <div>
                                <p class="font-semibold text-gray-700">
                                    Tampilkan TTD OPD
                                </p>

                                <p class="text-sm text-gray-400">
                                    Menampilkan tanda tangan pejabat pada dokumen.
                                </p>
                            </div>

                            <input
                                type="checkbox"
                                name="show_ttd"
                                value="1"
                                checked
                                class="w-5 h-5 text-purple-600 rounded">
                        </label>

                        {{-- Toggle Stempel --}}
                        <label class="flex items-center justify-between border rounded-lg p-4">

                            <div>
                                <p class="font-semibold text-gray-700">
                                    Tampilkan Stempel OPD
                                </p>

                                <p class="text-sm text-gray-400">
                                    Menampilkan stempel OPD pada dokumen.
                                </p>
                            </div>

                            <input
                                type="checkbox"
                                name="show_stempel"
                                value="1"
                                checked
                                class="w-5 h-5 text-purple-600 rounded">
                        </label>

                        {{-- Toggle NIP --}}
                        <label class="flex items-center justify-between border rounded-lg p-4">

                            <div>
                                <p class="font-semibold text-gray-700">
                                    Tampilkan NIP
                                </p>

                                <p class="text-sm text-gray-400">
                                    Menampilkan NIP pejabat pada dokumen.
                                </p>
                            </div>

                            <input
                                type="checkbox"
                                name="show_nip"
                                value="1"
                                checked
                                class="w-5 h-5 text-purple-600 rounded">
                        </label>

                        {{-- Toggle Jabatan --}}
                        <label class="flex items-center justify-between border rounded-lg p-4">

                            <div>
                                <p class="font-semibold text-gray-700">
                                    Tampilkan Jabatan
                                </p>

                                <p class="text-sm text-gray-400">
                                    Menampilkan jabatan pejabat pada dokumen.
                                </p>
                            </div>

                            <input
                                type="checkbox"
                                name="show_jabatan"
                                value="1"
                                checked
                                class="w-5 h-5 text-purple-600 rounded">
                        </label>
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
                        <button
                            type="button"
                            onclick="downloadBalasanUsulan()"
                            class="px-6 py-2.5 bg-[#FFA41B] text-white rounded-lg font-semibold">
                            Cetak Balasan
                        </button>
                    </div>
                </div>
        </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
                        "{{ route('superadmin.balasanusulankegiatan.preview', $usulankegiatans->id) }}", {
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

    <script>
        async function downloadBalasanUsulan() {

            const form = document.getElementById('balasanForm');

            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            if (!response.ok) {
                alert('Gagal membuat laporan.');
                return;
            }

            // Ambil nama file dari header Content-Disposition
            let fileName = "BalasanUsulan.pdf";

            const disposition = response.headers.get("Content-Disposition");

            if (disposition) {
                const match = disposition.match(/filename="?([^"]+)"?/);
                if (match && match[1]) {
                    fileName = decodeURIComponent(match[1]);
                }
            }

            const blob = await response.blob();

            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');

            a.href = url;
            a.download = fileName;

            document.body.appendChild(a);
            a.click();
            a.remove();

            window.URL.revokeObjectURL(url);

            window.location.href = "{{ route('superadmin.usulankegiatan.pending') }}";
        }
    </script>

</x-app-layout>