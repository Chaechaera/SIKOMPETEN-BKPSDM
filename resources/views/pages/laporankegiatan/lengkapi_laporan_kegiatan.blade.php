<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- 📝 FORM LAPORAN KEGIATAN --}}
            <form method="POST" action="{{ route('admin.laporankegiatan.update', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="laporankegiatan_id" value="{{ $laporankegiatans->id }}">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-6xl">
                        Silahkan lengkapi data untuk laporan hasil kegiatan Pengembangan Kompetensi ASN yang telah terselenggarakan pada form ini dan pastikan datatelah sesuai sebelum dicetak.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulankegiatans" :is-laporan="true" />

                {{-- =========================================================== --}}
                {{-- === BAGIAN 1: PREVIEW DATA UTAMA LAPORAN HASIL KEGIATAN === --}}
                {{-- =========================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Preview Data Utama Laporan Hasil Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja yang Menyelenggarakan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $unitkerjas ?? '' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                    readonly>
                                <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                            </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja yang Menyelenggarakan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $subunitkerjas ?? '' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                    readonly>
                                <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                            </div>
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan yang Diselenggarakan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                    readonly>
                                <input type="hidden" name="nama_kegiatan" value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}">
                            </div>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cara Pelatihan yang Digunakan</label>
                            <div class="relative">
                                <select name="carapelatihan_id" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" disabled>
                                    <option value="">-- Pilih Cara Pelatihan --</option>
                                    @foreach($carapelatihans as $c)
                                    <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulankegiatans?->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perwakilan yang Mengajukan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ auth()->user()->nama }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
                                    readonly>
                                <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                            </div>
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan Diselenggarakan</label>
                            <div class="relative">
                                <input type="text" name="lokasi_kegiatan"
                                    value="{{ old('lokasi_kegiatan', $laporankegiatans?->lokasi_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Mulai Diselenggarakan</label>
                            <div class="relative">
                                <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $laporankegiatans?->tanggalmulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Selesai Diselenggarakan</label>
                            <div class="relative">
                                <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $laporankegiatans?->tanggalselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Dimulai</label>
                            <div class="relative">
                                <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $laporankegiatans?->waktumulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Berakhir</label>
                            <div class="relative">
                                <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $laporankegiatans?->waktuselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- =============================================================================== --}}
                {{-- === BAGIAN 2: DATA KHUSUS LAPORAN HASIL KEGIATAN BERDASARKAN CARA PELATIHAN === --}}
                {{-- =============================================================================== --}}
                @php
                $carapelatihanId = $usulankegiatans->carapelatihans->id ?? null;
                $config = config('atribut_khusus');
                $atributKhusus = $carapelatihanId && isset($config[$carapelatihanId]['fields']) ? $config[$carapelatihanId]['fields'] : [];
                @endphp

                @if($atributKhusus)
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Lengkapi Data Khusus Laporan Hasil Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    @foreach($atributKhusus as $key => $field)
                    <div class="mt-3">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">{{ $field['label'] }}</label>
                        <div class="relative">
                        @if($field['type'] === 'textarea')
                        <textarea name="{{ $key }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="{{ $field['label'] }}">{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}</textarea>
                        @else
                        <input type="{{ $field['type'] }}" name="{{ $key }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/..." value="{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}">
                        @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- ============================================================= --}}
                {{-- === BAGIAN 3: LENGKAPI DATA DETAIL LAPORAN HASIL KEGIATAN === --}}
                {{-- ============================================================= --}}
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Lengkapi Data Tambahan Laporan Hasil Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    {{-- Kop Surat --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Pilih Jenis Kop yang Digunakan</label>
                        <div class="relative">
                        <label class="cursor-pointer items-center gap-6 block text-sm font-semibold text-[#5A5A5A] mb-2">
                            <input type="radio"
                                name="jeniskop_laporankegiatan"
                                value="kop_text"
                                {{ old('jeniskop_laporankegiatan', $laporankegiatans->detaillaporankegiatans?->jeniskop_laporankegiatan) == 'kop_text' ? 'checked' : '' }}>
                            Kop Text
                        </label>
                        <label class="cursor-pointer items-center gap-6 block text-sm font-semibold text-[#5A5A5A] mb-2">
                            <input type="radio"
                                name="jeniskop_laporankegiatan"
                                value="kop_gambar"
                                {{ old('jeniskop_laporankegiatan', $laporankegiatans->detaillaporankegiatans?->jeniskop_laporankegiatan) == 'kop_gambar' ? 'checked' : '' }}>
                            Kop Gambar
                        </label>
                    </div>
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
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                {{ $field['label'] }}
                            </label>
                        </div>
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
                    @endforeach

                    {{-- Rundown Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah Rundown Kegiatan
                            <span class="text-gray-400 text-sm">(Excel)</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-sm text-gray-500">Contoh nama file: rundown_kegiatan.xlsx</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="rundown_laporan" accept=".xls,.xlsx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2">
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
                    </div>

                    {{-- Peserta Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah Peserta Kegiatan
                            <span class="text-gray-400 text-sm">(Excel)</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Format: .xls / .xlsx</p>
                        <p class="text-sm text-gray-500">Contoh nama file: peserta_kegiatan.xlsx</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="peserta_laporan" accept=".xls,.xlsx" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2">
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
                    </div>

                    {{-- Link Undangan Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Undangan Kegiatan</label>
                        <input type="text" name="linkundangan_laporan" value="{{ old('linkundangan_laporan', $laporankegiatans->detaillaporankegiatans?->linkundangan_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkundangan_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Materi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Materi Kegiatan</label>
                        <input type="text" name="linkmateri_laporan" value="{{ old('linkmateri_laporan', $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkmateri_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Daftar Hadir Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Daftar Hadir Kegiatan</label>
                        <input type="text" name="linkdaftarhadir_laporan" value="{{ old('linkdaftarhadir_laporan', $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkdaftarhadir_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Dokumentasi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Dokumentasi Kegiatan</label>
                        <input type="text" name="linkdokumentasi_laporan" value="{{ old('linkdokumentasi_laporan', $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkdokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar Dokumentasi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah Gambar Dokumentasi Kegiatan
                            <span class="text-gray-400 text-sm">(JPG, PNG, JPEG)</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Format: .jpg / .png / .jpeg</p>
                        <p class="text-sm text-gray-500">Contoh nama file: gambar_kegiatan_1.jpg</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambardokumentasi_laporan[]" accept=".jpg,.png,.jpeg" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" multiple id="gambardokumentasi_laporanFiles" required>
                        @error('gambardokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>
                        </div>
                    </div>

                    {{-- Template Sertifikat --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            Unggah File Template Sertifikat Kegiatan
                            <span class="text-gray-400 text-sm">(JPG, PNG)</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1">Format: .jpg / .png</p>
                        <p class="text-sm text-gray-500">Contoh nama file: template_sertifikat.jpg</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="templatesertifikat_kegiatan" accept=".png,.jpg" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2">
                        @error('templatesertifikat_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 4: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="w-2/12 text-center py-2.5 rounded-lg  bg-gray-300 text-gray-700 font-semibold hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                        Submit Laporan
                    </button>
                </div>
            </form>
        </main>
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