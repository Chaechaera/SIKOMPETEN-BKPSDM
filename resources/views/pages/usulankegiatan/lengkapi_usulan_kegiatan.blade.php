<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- 📝 FORM PENGAJUAN USULAN --}}
            <form method="POST" action="{{ route('admin.usulankegiatan.update', $usulan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-4xl">
                        Silahkan lengkapi data usulan kegiatan pada form ini dan pastikan data usulan kegiatan yang diisikan telah sesuai sebelum dicetak.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulan" :is-laporan="false" />

                {{-- ===================================================== --}}
                {{-- === BAGIAN 1: LENGKAPI DATA UTAMA USULAN KEGIATAN === --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Lengkapi Data Utama Usulan Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja yang Mengajukan</label>
                            <div class="relative">
                                <input type="text" value="{{ $unitkerjas ?? '' }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                                <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                            </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja yang Mengajukan</label>
                            <div class="relative">
                                <input type="text" value="{{ $subunitkerjas ?? '' }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                                <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                            </div>
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan yang Diajukan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $nama_kegiatan ?? '' }}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2"
                                    readonly>
                                <input type="hidden" name="nama_kegiatan" value="{{ $nama_kegiatan ?? '' }}">
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan akan Dilaksanakan</label>
                            <div class="relative">
                                <input type="text" name="lokasi_kegiatan" placeholder="Hotel Alila Surakarta"
                                    value="{{ old('lokasi_kegiatan', $usulan->lokasi_kegiatan) }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('lokasi_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cara Pelatihan yang Digunakan</label>
                            <div class="relative">
                                <select name="carapelatihan_id" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                    <option value="">-- Pilih Cara Pelatihan --</option>
                                    @foreach($carapelatihans as $c)
                                    <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulan->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                    @endforeach
                                </select>
                                @error('carapelatihan_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan akan Dimulai</label>
                            <div class="relative">
                                <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulan->tanggalmulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('tanggalmulai_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan akan Berakhir</label>
                            <div class="relative">
                                <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulan->tanggalselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('tanggalselesai_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan akan Dimulai</label>
                            <div class="relative">
                                <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulan->waktumulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('waktumulai_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan akan Selesai</label>
                            <div class="relative">
                                <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulan->waktuselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                @error('waktuselesai_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perwakilan yang Mengajukan</label>
                            <div class="relative">
                                <input type="text" value="{{ auth()->user()->nama }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                                <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ====================================================== --}}
                {{-- == BAGIAN 2: LENGKAPI DATA TAMBAHAN USULAN KEGIATAN == --}}
                {{-- ====================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Lengkapi Data Tambahan Usulan Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    {{-- Kop Surat --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Pilih Jenis Kop yang Digunakan</label>
                        <div class="relative">
                            <label class="cursor-pointer items-center gap-6 block text-sm font-semibold text-[#5A5A5A] mb-2">
                                <input type="radio"
                                    name="jeniskop_usulankegiatan"
                                    value="kop_text"
                                    {{ old('jeniskop_usulankegiatan', $detail?->jeniskop_usulankegiatan) == 'kop_text' ? 'checked' : '' }}>
                                Kop Text
                            </label>
                            <label class="cursor-pointer items-center gap-6 block text-sm font-semibold text-[#5A5A5A] mb-2">
                                <input type="radio"
                                    name="jeniskop_usulankegiatan"
                                    value="kop_gambar"
                                    {{ old('jeniskop_usulankegiatan', $detail?->jeniskop_usulankegiatan) == 'kop_gambar' ? 'checked' : '' }}>
                                Kop Gambar
                            </label>
                            <input type="hidden" name="kopunitkerja_id" value="{{ old('kopunitkerja_id', $kopunitkerja_id) }}">
                        </div>
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
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                {{ $field['label'] }}
                            </label>
                        </div>
                        <div class="relative">
                            @if($field['placeholder'])
                            <pre id="sample-{{ $name }}"
                                class="hidden bg-gray-50 border-gray-300 rounded-lg px-3 py-2 mt-2 w-full text-sm whitespace-pre-wrap">
                            {{ $field['placeholder'] }}
                            </pre>
                            @endif
                            <textarea
                                name="{{ $name }}"
                                placeholder="{!! $field['placeholder'] !!}"
                                data-numbering="{{ $field['numbering'] ? 'true' : 'false' }}"
                                class="overflow-hidden smart-textarea block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2 resize-none">{{ old($name, $detail->$name ?? '') }}</textarea>
                            @error($name)
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @endforeach

                    {{-- Alokasi Anggaran --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Alokasi Anggaran Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="alokasianggaran_kegiatan" placeholder="2000000" value="{{ old('alokasianggaran_kegiatan', $detail->alokasianggaran_kegiatan) }}"
                                class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2">
                            @error('alokasianggaran_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Metode Pelatihan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Metode Pelatihan yang Digunakan</label>
                        <div class="relative">
                            <select name="metodepelatihan_id" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                                <option value="">-- Pilih Metode Pelatihan Kegiatan --</option>
                                @foreach($metodepelatihans as $m)
                                <option value="{{ $m->id }}" {{ old('metodepelatihan_id', $detail->metodepelatihan_id) == $m->id ? 'selected' : '' }}>{{ $m->metode_pelatihan }}</option>
                                @endforeach
                            </select>
                            @error('metodepelatihan_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Jadwal Pelaksanaan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah Jadwal Pelaksanaan Kegiatan
                            <span class="text-gray-400 text-sm">(Excel)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-xs text-gray-500">Contoh nama file: jadwal_pelaksanaan_kegiatan.xlsx</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="jadwalpelaksanaan_kegiatan" accept=".xls,.xlsx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" {{ $detail && $detail->jadwalpelaksanaan_kegiatan ? '' : 'required' }}>
                            @if($detail?->jadwalpelaksanaan_kegiatan)
                            <div class="mt-2">
                                <p class="text-xs text-gray-500">File saat ini:
                                    <a href="{{ asset('storage/'.$detail->jadwalpelaksanaan_kegiatan) }}" target="_blank" class="text-blue-600">
                                        {{ basename($detail->jadwalpelaksanaan_kegiatan) }}
                                    </a>
                                </p>
                            </div>
                            @endif
                            @error('jadwalpelaksanaan_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                    {{-- ===================================================== --}}
                    {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                    {{-- ===================================================== --}}
                    <div class="mt-6 flex justify-end gap-3">
                        <button type="submit"
                            class="w-2/12 text-center py-2.5 rounded-lg  bg-gray-300 text-gray-700 font-semibold hover:bg-gray-200 transition">
                            Simpan Draft
                        </button>
                        <button type="submit"
                            class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                            Submit Usulan
                        </button>
                    </div>
            </form>
        </main>
    </div>
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
        }
    </script>
</x-app-layout>