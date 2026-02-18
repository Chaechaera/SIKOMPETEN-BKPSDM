<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Lengkapi Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.laporankegiatan.update', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="laporankegiatan_id" value="{{ $laporankegiatans->id }}">

                {{-- =========================================================== --}}
                {{-- === BAGIAN 1: PREVIEW DATA UTAMA LAPORAN HASIL KEGIATAN === --}}
                {{-- =========================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Detail Data Utama Laporan Hasil Kegiatan Pengembangan Kompetensi ASN</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Unit Kerja yang Menyelenggarakan</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Sub Unit Kerja yang Menyelenggarakan</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Nama Kegiatan yang Diselenggarakan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="nama_kegiatan" value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Lokasi Kegiatan Diselenggarakan</label>
                            <input type="text" name="lokasi_kegiatan"
                                value="{{ old('lokasi_kegiatan', $usulankegiatans?->lokasi_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Cara Pelatihan yang Digunakan</label>
                            <select name="carapelatihan_id" class="border p-2 w-full" disabled>
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulankegiatans?->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan Mulai Diselenggarakan</label>
                            <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulankegiatans?->tanggalmulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan Selesai Diselenggarakan</label>
                            <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulankegiatans?->tanggalselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan Dimulai</label>
                            <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulankegiatans?->waktumulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan Berakhir</label>
                            <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulankegiatans?->waktuselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Perwakilan yang Mengajukan</label>
                            <input type="text"
                                value="{{ auth()->user()->nama }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>
                    </div>
                </div>

                {{-- ============================================================== --}}
                {{-- === BAGIAN 2: PREVIEW DATA TAMBAHAN LAPORAN HASIL KEGIATAN === --}}
                {{-- ============================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Detail Data Tambahan Laporan Hasil Kegiatan Pengembangan Kompetensi ASN</h2>

                    {{-- Data Detail --}}
                    @php
                    $fields = [
                    'latarbelakang_kegiatan' => [
                    'label' => 'Latar Belakang Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                    'numbering' => false
                    ],
                    'dasarhukum_kegiatan' => [
                    'label' => 'Dasar Hukum Kegiatan',
                    'placeholder' => '1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => true
                    ],
                    'uraian_kegiatan' => [
                    'label' => 'Uraian Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => false
                    ],
                    'maksud_kegiatan' => [
                    'label' => 'Maksud Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                    'numbering' => false
                    ],
                    'tujuan_kegiatan' => [
                    'label' => 'Tujuan Kegiatan',
                    'placeholder' => '1. Mensejahterakan masyarakat&#10;2. Mendukung visi misi pemerintah&#10;3. dst',
                    'numbering' => true
                    ],
                    'hasillangsung_kegiatan' => [
                    'label' => 'Hasil Jangka Langsung dari Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => false
                    ],
                    'hasilmenengah_kegiatan' => [
                    'label' => 'Hasil Jangka Menengah dari Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => false
                    ],
                    'hasilpanjang_kegiatan' => [
                    'label' => 'Hasil Jangka Panjang dari Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => false
                    ],
                    'narasumber_kegiatan' => [
                    'label' => 'Narasumber Kegiatan',
                    'placeholder' => '1. Budi Mulyono - Kepala Staff Ahli IT&#10;2. Anisa Widyanti - Kepala Bidang&#10;3. dst',
                    'numbering' => true
                    ],
                    'sasaranpeserta_kegiatan' => [
                    'label' => 'Sasaran Peserta Kegiatan',
                    'placeholder' => '1. PNS di Lingkungan BKPSDM&#10;2. Masyarakat Umum&#10;3. dst',
                    'numbering' => true
                    ],
                    'detailhasil_kegiatan' => [
                    'label' => 'Detail yang Dihasilkan dari Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst&#10;1. UUD 1945&#10;2. Perpu No.3 Tahun 2014&#10;3. dst',
                    'numbering' => false
                    ],
                    'penyelenggara_kegiatan' => [
                    'label' => 'Penyelenggara Kegiatan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                    'numbering' => false
                    ],
                    ];
                    @endphp

                    @foreach($fields as $name => $field)
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-gray-800">
                                {{ $field['label'] }}
                            </label>
                        </div>
                        @if($field['placeholder'])
                        <pre id="sample-{{ $name }}"
                            class="hidden bg-gray-50 border p-3 rounded mt-2 text-sm whitespace-pre-wrap">
                        {{ $field['placeholder'] }}
                        </pre>
                        @endif
                        <textarea
                            name="{{ $name }}"
                            placeholder="{!! $field['placeholder'] !!}"
                            data-numbering="{{ $field['numbering'] ? 'true' : 'false' }}"
                            class="overflow-hidden smart-textarea mt-2 w-full border border-gray-300 rounded p-3 resize-none focus:ring focus:ring-blue-200" readonly>{{ old($name, $usulankegiatans->detailusulankegiatans?->$name ?? '') }}</textarea>
                        <input type="hidden" name="{{ $name }}" value="{{ $usulankegiatans->detailusulankegiatans?->$name ?? '' }}">
                        @error($name)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach

                    {{-- Metode Pelatihan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Metode Pelatihan</label>
                        <select class="border p-2 w-full bg-gray-100" disabled>
                            <option value="">-- Pilih Metode Pelatihan --</option>
                            @foreach($metodepelatihans as $m)
                            <option value="{{ $m->id }}" {{ old('metodepelatihan_id', $usulankegiatans->detailusulankegiatans?->metodepelatihan_id) == $m->id ? 'selected' : '' }}>{{ $m->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="metodepelatihan_id" value="{{ $usulankegiatans->detailusulankegiatans?->metodepelatihan_id }}">
                    </div>

                    {{-- =============================================================================== --}}
                    {{-- === BAGIAN 3: DATA KHUSUS LAPORAN HASIL KEGIATAN BERDASARKAN CARA PELATIHAN === --}}
                    {{-- =============================================================================== --}}
                    @php
                    $carapelatihanId = $usulankegiatans->carapelatihans->id ?? null;
                    $config = config('atribut_khusus');
                    $atributKhusus = $carapelatihanId && isset($config[$carapelatihanId]['fields']) ? $config[$carapelatihanId]['fields'] : [];
                    @endphp

                    @if($atributKhusus)
                    <div class="mt-6 border-t pt-4">
                        <h3 class="font-semibold text-lg mb-2">
                            Atribut Khusus untuk {{ $usulankegiatans->carapelatihans->cara_pelatihan }}
                        </h3>

                        @foreach($atributKhusus as $key => $field)
                        <div class="mt-3">
                            <label class="block font-medium">{{ $field['label'] }}</label>
                            @if($field['type'] === 'textarea')
                            <textarea name="{{ $key }}" class="border p-2 w-full" placeholder="{{ $field['label'] }}">{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}</textarea>
                            @else
                            <input type="{{ $field['type'] }}" name="{{ $key }}" class="border p-2 w-full" placeholder="https://docs.google.com/..." value="{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>

                {{-- ============================================================= --}}
                {{-- === BAGIAN 4: LENGKAPI DATA DETAIL LAPORAN HASIL KEGIATAN === --}}
                {{-- ============================================================= --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Data Detail Laporan Hasil Kegiatan Pengembangan Kompetensi ASN</h2>

                    {{-- Kop Surat --}}
                    <div class="mt-4">
                        <label class="block font-medium">Pilih Jenis Kop yang Digunakan</label>
                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="jeniskop_laporankegiatan"
                                value="kop_text"
                                {{ old('jeniskop_laporankegiatan', $laporankegiatans->detaillaporankegiatans?->jeniskop_laporankegiatan) == 'kop_text' ? 'checked' : '' }}>
                            Kop Text
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="jeniskop_laporankegiatan"
                                value="kop_gambar"
                                {{ old('jeniskop_laporankegiatan', $laporankegiatans->detaillaporankegiatans?->jeniskop_laporankegiatan) == 'kop_gambar' ? 'checked' : '' }}>
                            Kop Gambar
                        </label>
                    </div>

                    {{-- Data Detail --}}
                    @php
                    $fields = [
                    'rincian_laporan' => [
                    'label' => 'Rincian Laporan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                    'numbering' => false
                    ],
                    'penutup_laporan' => [
                    'label' => 'Penutup Laporan',
                    'placeholder' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book dst',
                    'numbering' => false
                    ],
                    ];
                    @endphp

                    @foreach($fields as $name => $field)
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-gray-800">
                                {{ $field['label'] }}
                            </label>
                        </div>
                        @if($field['placeholder'])
                        <pre id="sample-{{ $name }}"
                            class="hidden bg-gray-50 border p-3 rounded mt-2 text-sm whitespace-pre-wrap">
                        {{ $field['placeholder'] }}
                        </pre>
                        @endif
                        <textarea
                            name="{{ $name }}"
                            placeholder="{!! $field['placeholder'] !!}"
                            data-numbering="{{ $field['numbering'] ? 'true' : 'false' }}"
                            class="overflow-hidden smart-textarea mt-2 w-full border border-gray-300 rounded p-3 resize-none focus:ring focus:ring-blue-200">{{ old($name, $laporankegiatans->detaillaporankegiatans?->$name ?? '') }}</textarea>
                        @error($name)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach

                    {{-- Rundown Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Rundown Kegiatan (Excel)</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-sm text-gray-500">Contoh nama file: rundown_kegiatan.xlsx</p>
                        <input type="file" name="rundown_laporan" accept=".xls,.xlsx" class="border p-2 w-full">
                        @if(!empty($laporankegiatans->detaillaporankegiatans?->rundown_laporan))
                        <p class="text-sm text-gray-600 mt-2">File Sebelumnya:
                            <a href="{{ asset('storage/'.$laporankegiatans->detaillaporankegiatans?->rundown_laporan) }}" target="_blank" class="text-blue-600">
                                {{ basename($laporankegiatans->detaillaporankegiatans?->rundown_laporan) }}
                            </a>
                        </p>
                        @endif
                        @error('rundown_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Peserta Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Peserta Kegiatan (Excel)</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-sm text-gray-500">Contoh nama file: peserta_kegiatan.xlsx</p>
                        <input type="file" name="peserta_laporan" accept=".xls,.xlsx" class="border p-2 w-full">
                        @if(!empty($laporankegiatans->detaillaporankegiatans?->peserta_laporan))
                        <p class="text-sm text-gray-600 mt-2">File Sebelumnya:
                            <a href="{{ asset('storage/'.$laporankegiatans->detaillaporankegiatans?->peserta_laporan) }}" target="_blank" class="text-blue-600">
                                {{ basename($laporankegiatans->detaillaporankegiatans?->peserta_laporan) }}
                            </a>
                        </p>
                        @endif
                        @error('peserta_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Undangan Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Undangan Kegiatan</label>
                        <input type="text" name="linkundangan_laporan" value="{{ old('linkundangan_laporan', $laporankegiatans->detaillaporankegiatans?->linkundangan_laporan) }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('linkundangan_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Materi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Materi Kegiatan</label>
                        <input type="text" name="linkmateri_laporan" value="{{ old('linkmateri_laporan', $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan) }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('linkmateri_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Daftar Hadir Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Daftar Hadir Kegiatan</label>
                        <input type="text" name="linkdaftarhadir_laporan" value="{{ old('linkdaftarhadir_laporan', $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan) }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('linkdaftarhadir_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Dokumentasi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Dokumentasi Kegiatan</label>
                        <input type="text" name="linkdokumentasi_laporan" value="{{ old('linkdokumentasi_laporan', $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan) }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('linkdokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar Dokumentasi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Gambar Dokumentasi Kegiatan (JPG, PNG, JPEG)</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .jpg / .png / .jpeg</p>
                        <p class="text-sm text-gray-500">Contoh nama file: gambar_kegiatan_1.jpg</p>
                        <input type="file" name="gambardokumentasi_laporan[]" accept=".jpg,.png,.jpeg" class="border p-2 w-full" multiple id="gambardokumentasi_laporanFiles" required>
                        @error('gambardokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>
                    </div>

                    {{-- Template Sertifikat --}}
                    <div class="mt-4">
                        <label class="block font-medium">Upload File Template Sertifikat (Gambar)</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .jpg / .png</p>
                        <p class="text-sm text-gray-500">Contoh nama file: template_sertifikat.jpg</p>
                        <input type="file" name="templatesertifikat_kegiatan" accept=".png,.jpg" class="border p-2 w-full">
                        @error('templatesertifikat_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 transition text-white font-semibold px-4 py-2 rounded">
                        Batal
                    </button>
                    <button type="submit" name="statuslaporan_kegiatan" value="completed"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                        Submit Laporan
                    </button>
                </div>
            </form>
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
        };

        /* Untuk Eksekusi Gambar Dokumentasi Kegiatan */
        // Ambil elemen input upload gambar dan daftar file gambar
        const fileInput = document.getElementById('gambardokumentasi_laporanFiles');
        const fileList = document.getElementById('fileList');

        // Event ketika user pilih file
        fileInput.addEventListener('change', function() {
            fileList.innerHTML = ''; // kosongkan dulu

            // Kalau ada file yang dipilih
            for (let i = 0; i < this.files.length; i++) {
                const li = document.createElement('li');
                li.textContent = `${i + 1}. ${this.files[i].name}`;
                fileList.appendChild(li);
            }
        });
    </script>
</x-app-layout>