<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> CETAK LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan periksa dan pastikan data laporan sebelum mencetak.
            </p>
        </div>

        {{-- Header --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


        {{-- STEP --}}
        <x-step-progress :usulan="$usulan" :is-laporan="true" />

        {{-- ================================================== --}}
        {{-- RINGKASAN DATA --}}
        {{-- ================================================== --}}
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">

            <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent mb-4">
                Ringkasan Data Laporan Hasil Kegiatan
            </h2>

            <div class="my-4 border-t-2 border-gray-200"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">

                <div>
                    <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulan->inputusulankegiatans->nama_kegiatan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulan->subunitkerjas->sub_unitkerja ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-1">Lokasi</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulan->lokasi_kegiatan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400 text-xs mb-1">Tanggal</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{
                        $usulan->tanggalmulai_kegiatan && $usulan->tanggalselesai_kegiatan
                        ? \Carbon\Carbon::parse($usulan->tanggalmulai_kegiatan)->format('d F Y')
                          . ' s/d ' .
                          \Carbon\Carbon::parse($usulan->tanggalselesai_kegiatan)->format('d F Y')
                        : '-'
                    }}
                    </p>
                </div>

            </div>
        </div>

        {{-- ================================================== --}}
        {{-- FORM IDENTITAS SURAT --}}
        {{-- ================================================== --}}
        <div id="laporanWrapper">

            <form id="laporanForm"
                method="POST"
                action="{{ route('admin.laporankegiatan.cetak.download', $usulan->id) }}">
                <iframe name="downloadFrame" class="hidden"></iframe>
                @csrf
                <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nomor Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Nomor Surat
                            </label>

                            <input type="text"
                                name="nomor_surat"
                                x-model="nomor_surat"
                                value="{{ old('nomor_surat') }}"
                                class="w-full text-sm border border-[#E0E7FF] rounded-lg bg-gray-50 p-2"
                                placeholder="12/X/BKPSDM/001"
                                required>

                            @error('nomor_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Tanggal Surat
                            </label>

                            <input type="text"
                                id="tanggal_surat"
                                name="tanggal_surat"
                                value="{{ old('tanggal_surat') }}"
                                class="w-full text-sm border border-[#E0E7FF] rounded-lg bg-gray-50 p-2"
                                placeholder="dd-mm-yyyy"
                                required>

                            @error('tanggal_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Lampiran --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Lampiran Surat
                            </label>

                            <input type="text"
                                name="lampiran_surat"
                                value="1 Bendel"
                                readonly
                                class="w-full text-sm border border-gray-300 rounded-lg bg-gray-200 p-2 cursor-not-allowed">
                        </div>

                        {{-- Sifat Surat --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Sifat Surat
                            </label>

                            <select name="sifat_surat"
                                class="w-full text-sm border border-[#E0E7FF] rounded-lg bg-gray-50 p-2"
                                required>

                                <option value="" disabled selected>-- Pilih sifat surat --</option>
                                <option value="Penting" {{ old('sifat_surat') == 'Penting' ? 'selected' : '' }}>penting</option>
                                <option value="Rahasia" {{ old('sifat_surat') == 'Rahasia' ? 'selected' : '' }}>rahasia</option>
                            </select>

                            @error('sifat_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Perihal --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Perihal Surat
                            </label>

                            <input type="text"
                                name="perihal_surat"
                                value="{{ old('perihal_surat') }}"
                                class="w-full text-sm border border-[#E0E7FF] rounded-lg bg-gray-50 p-2"
                                placeholder="Permohonan Rekomendasi Kegiatan Workshop"
                                required>

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

                {{-- ================================================== --}}
                {{-- PREVIEW PDF --}}
                {{-- ================================================== --}}
                <div x-data="previewLaporan()" class="rounded-lg p-4 mb-6">

                    {{-- PREVIEW --}}
                    <div x-show="showPreview" x-transition class="mt-4">

                        <h3 class="text-lg font-semibold text-gray-700 mb-4">
                            Preview Dokumen Laporan
                        </h3>

                        <iframe
                            :src="pdfUrl"
                            class="w-full h-[1200px] border rounded">
                        </iframe>

                    </div>

                    {{-- ================================================== --}}
                    {{-- BUTTON ACTION --}}
                    {{-- ================================================== --}}
                    <div class="mt-6 flex justify-between items-center relative">

                        {{-- Kiri --}}
                        <button
                            type="button"
                            @click="togglePreview()"
                            class="px-6 py-2.5 rounded-lg bg-[#FFA41B] text-white font-semibold">
                            <span x-text="showPreview ? 'Sembunyikan Preview' : 'Tinjau Laporan'"></span>
                        </button>

                        {{-- Tengah --}}
                        <div class="absolute left-1/2 -translate-x-1/2 text-sm font-semibold text-gray-500">
                            Step <span class="text-[#FFA41B] font-bold">3</span> dari 4
                        </div>

                        {{-- Kanan 
                        <div class="flex gap-3">
                            <form
                                action="{{ route('admin.laporankegiatan.download', $usulan->id) }}"
                        method="POST"
                        target="downloadFrame"
                        id="formCetak">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-[#FFA41B] text-white font-semibold" onclick="redirectAfterDownload()">
                            Cetak Laporan
                        </button>
                    </div>--}}
                    <button
                        type="button"
                        onclick="downloadLaporan()"
                        class="px-6 py-2.5 rounded-lg bg-[#FFA41B] text-white font-semibold">
                        Cetak Laporan
                    </button>
                </div>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#tanggal_surat", {
                    dateFormat: "d-m-Y",
                    allowInput: true
                });
            });
        </script>
        <script>
            document.getElementById('laporanForm').addEventListener('submit', function(e) {
                console.log('FORM SUBMIT');
                console.log('Method:', this.method);
                console.log('Action:', this.action);
            });
        </script>

        <script>
            function previewLaporan() {
                return {
                    showPreview: false,
                    pdfUrl: '',

                    nomor_surat: '',
                    tanggal_surat: '',
                    sifat_surat: '',
                    perihal_surat: '',
                    exists: false,

                    // 🔥 CHECK NOMOR SURAT
                    async checkNomor() {
                        if (!this.nomor_surat) return false;

                        let res = await fetch('/admin/laporankegiatan/check-nomor-surat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                nomor_surat: this.nomor_surat
                            })
                        });

                        let data = await res.json();
                        this.exists = data.exists;

                        return data.exists;
                    },

                    // 🔥 TOGGLE PREVIEW
                    async togglePreview() {

                        // STEP 1: cek dulu
                        let exists = await this.checkNomor();

                        if (exists) {
                            alert('⚠ Nomor surat sudah digunakan!');
                            return; // STOP
                        }

                        // STEP 2: lanjut preview
                        this.showPreview = !this.showPreview;

                        if (this.showPreview) {
                            await this.generatePreview();
                        }
                    },

                    async generatePreview() {
                        const form = document.getElementById('laporanForm');
                        const formData = new FormData(form);

                        const res = await fetch("{{ route('admin.laporankegiatan.preview', $usulan->id) }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        });

                        const blob = await res.blob();
                        this.pdfUrl = URL.createObjectURL(blob);
                    }
                }
            }
        </script>

        <script>
            async function downloadLaporan() {

                const form = document.getElementById('laporanForm');

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
                let fileName = "Laporan.pdf";

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

                window.location.href = "{{ route('admin.laporankegiatan.index') }}";
            }
        </script>

</x-app-layout>