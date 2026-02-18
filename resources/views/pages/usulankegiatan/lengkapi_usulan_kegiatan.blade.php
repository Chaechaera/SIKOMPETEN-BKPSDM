<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Lengkapi Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.usulankegiatan.update', $usulan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===================================================== --}}
                {{-- === BAGIAN 1: LENGKAPI DATA UTAMA USULAN KEGIATAN === --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Data Utama Usulan Kegiatan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Unit Kerja yang Mengajukan</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Sub Unit Kerja yang Mengajukan</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Nama Kegiatan yang Diajukan</label>
                            <input type="text"
                                value="{{ $nama_kegiatan ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="nama_kegiatan" value="{{ $nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Lokasi Kegiatan akan Dilaksanakan</label>
                            <input type="text" name="lokasi_kegiatan"
                                value="{{ old('lokasi_kegiatan', $usulan->lokasi_kegiatan) }}"
                                class="border p-2 w-full" required>
                            @error('lokasi_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Cara Pelatihan yang Digunakan</label>
                            <select name="carapelatihan_id" class="border p-2 w-full" required>
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulan->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                @endforeach
                            </select>
                            @error('carapelatihan_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan akan Dimulai</label>
                            <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulan->tanggalmulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                            @error('tanggalmulai_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block font-medium">Tanggal Kegiatan akan Berakhir</label>
                            <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulan->tanggalselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                            @error('tanggalselesai_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan akan Dimulai</label>
                            <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulan->waktumulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                            @error('waktumulai_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block font-medium">Waktu Kegiatan akan Selesai</label>
                            <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulan->waktuselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                            @error('waktuselesai_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
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

                {{-- ====================================================== --}}
                {{-- == BAGIAN 2: LENGKAPI DATA TAMBAHAN USULAN KEGIATAN == --}}
                {{-- ====================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Data Tambahan Usulan Kegiatan</h2>

                    {{-- Kop Surat --}}
                    <div class="mt-4">
                        <label class="block font-medium">Pilih Jenis Kop yang Digunakan</label>
                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="jeniskop_usulankegiatan"
                                value="kop_text"
                                {{ old('jeniskop_usulankegiatan', $detail?->jeniskop_usulankegiatan) == 'kop_text' ? 'checked' : '' }}>
                            Kop Text
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio"
                                name="jeniskop_usulankegiatan"
                                value="kop_gambar"
                                {{ old('jeniskop_usulankegiatan', $detail?->jeniskop_usulankegiatan) == 'kop_gambar' ? 'checked' : '' }}>
                            Kop Gambar
                        </label>
                        <input type="hidden" name="kopunitkerja_id" value="{{ old('kopunitkerja_id', $kopunitkerja_id) }}">
                    </div>

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
                        'penutup_kegiatan' => [
                            'label' => 'Penutup Kegiatan',
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
                            class="overflow-hidden smart-textarea mt-2 w-full border border-gray-300 rounded p-3 resize-none focus:ring focus:ring-blue-200">{{ old($name, $detail->$name ?? '') }}</textarea>
                        @error($name)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach

                    {{-- Alokasi Anggaran --}}
                    <div class="mt-4">
                        <label class="block font-medium">Alokasi Anggaran Kegiatan</label>
                        <input type="text" name="alokasianggaran_kegiatan" placeholder="2000000" value="{{ old('alokasianggaran_kegiatan', $detail->alokasianggaran_kegiatan) }}"
                            class="border p-2 w-full">
                        @error('alokasianggaran_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Metode Pelatihan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Metode Pelatihan yang Digunakan</label>
                        <select name="metodepelatihan_id" class="border p-2 w-full" required>
                            <option value="">-- Pilih Metode Pelatihan Kegiatan --</option>
                            @foreach($metodepelatihans as $m)
                            <option value="{{ $m->id }}" {{ old('metodepelatihan_id', $detail->metodepelatihan_id) == $m->id ? 'selected' : '' }}>{{ $m->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                        @error('metodepelatihan_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jadwal Pelaksanaan --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unggah Jadwal Pelaksanaan Kegiatan (File Excel)</label>
                        <p class="text-sm text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-sm text-gray-500">Contoh nama file: jadwal_pelaksanaan_kegiatan.xlsx</p>
                        <input type="file" name="jadwalpelaksanaan_kegiatan" accept=".xls,.xlsx" class="border p-2 w-full">
                        @if(!empty($detail?->jadwalpelaksanaan_kegiatan))
                        <p class="text-sm text-gray-600 mt-2">File Sebelumnya:
                            <a href="{{ asset('storage/'.$detail->jadwalpelaksanaan_kegiatan) }}" target="_blank" class="text-blue-600">
                                {{ basename($detail->jadwalpelaksanaan_kegiatan) }}
                            </a>
                        </p>
                        @endif
                        @error('jadwalpelaksanaan_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ===================================================== --}}
                    {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                    {{-- ===================================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit" 
                            class="g-gray-500 hover:bg-gray-600 transition text-white font-semibold px-4 py-2 rounded">
                            Simpan Draft
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                            Submit Usulan
                        </button>
                    </div>
            </form>
        </div>
    </div>

    <script>
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
        function resizeTextarea(el) {
            el.style.height = "auto";
            el.style.height = el.scrollHeight + "px";
        }
        function toggleSample(name) {
            document
                .getElementById('sample-' + name)
                .classList
                .toggle('hidden');
        }
    </script>
</x-app-layout>