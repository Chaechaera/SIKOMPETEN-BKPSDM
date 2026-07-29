<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> FORMULIR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan lengkapi data untuk laporan hasil kegiatan Pengembangan Kompetensi ASN yang telah diselenggarakan pada form ini.
            </p>
        </div>

            {{-- Header --}}
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

            {{-- FORM LAPORAN KEGIATAN --}}
            <form method="POST" action="{{ route('admin.laporankegiatan.update', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="laporankegiatan_id" value="{{ $laporankegiatans->id }}">

            {{-- Step Progress --}}
            <x-step-progress :usulan="$usulankegiatans" :is-laporan="true" />

                {{-- =========================================================== --}}
                {{-- === BAGIAN 1: PREVIEW DATA UTAMA LAPORAN HASIL KEGIATAN === --}}
                {{-- =========================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-blue-600 mb-4">Preview Data Utama Laporan Hasil Kegiatan</h2>

                    <!-- DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="nama_kegiatan"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cara Pelatihan</label>
                            <select disabled
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-1000 cursor-not-allowed p-2">
                                @foreach($carapelatihans as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $usulankegiatans?->carapelatihan_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->cara_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="carapelatihan_id"
                                value="{{ $usulankegiatans?->carapelatihan_id }}">
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Perwakilan yang Mengajukan
                            </label>
                            <input type="text"
                                value="{{ auth()->user()->nama }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan Diselenggarakan</label>
                            <div class="relative">
                                <input type="text" name="lokasi_kegiatan"
                                    value="{{ old('lokasi_kegiatan', $laporankegiatans?->lokasi_kegiatan) }}"
                                    class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-50 text-gray-700 p-2" required>
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Mulai Diselenggarakan</label>
                            <div class="relative">
                                <input type="text"
    id="tanggalmulai_kegiatan"
    name="tanggalmulai_kegiatan"
    value="{{ old('tanggalmulai_kegiatan', $laporankegiatans?->tanggalmulai_kegiatan) }}"
    class="flatpickr block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
    required>
                            </div>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Selesai Diselenggarakan</label>
                            <div class="relative">
                                <input type="text"
    id="tanggalselesai_kegiatan"
    name="tanggalselesai_kegiatan"
    value="{{ old('tanggalselesai_kegiatan', $laporankegiatans?->tanggalselesai_kegiatan) }}"
    class="flatpickr block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2"
    required>
                            </div>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Dimulai</label>
                            <div class="relative">
                                <input type="text"
       id="waktumulai_kegiatan"
       name="waktumulai_kegiatan"
       value="{{ old('waktumulai_kegiatan', $laporankegiatans?->waktumulai_kegiatan) }}"
       class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 p-2"
       required>
                            </div>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Berakhir</label>
                            <div class="relative">
                                <input type="text"
       id="waktuselesai_kegiatan"
       name="waktuselesai_kegiatan"
       value="{{ old('waktuselesai_kegiatan', $laporankegiatans?->waktuselesai_kegiatan) }}"
       class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 p-2"
       required>
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
                    <h2 class="text-lg font-bold text-blue-600 mb-4">Lengkapi Data Khusus Laporan Hasil Kegiatan</h2>

                <!-- 🔻 DIVIDER -->
                <div class="my-4 border-t-2 border-gray-200"></div>

                @foreach($atributKhusus as $key => $field)
                <div class="mt-3">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">{{ $field['label'] }}</label>
                    <div class="relative">
                        @if($field['type'] === 'textarea')
                        <textarea name="{{ $key }}" class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="{{ $field['label'] }}">{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}</textarea>
                        @else
                        <input type="{{ $field['type'] }}" name="{{ $key }}" class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/..." value="{{ old($key, $laporankegiatans->detaillaporankegiatans->atribut_khusus[$key] ?? '') }}">
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
                    <h2 class="text-lg font-bold text-blue-600 mb-4">Lengkapi Data Tambahan Laporan Hasil Kegiatan</h2>

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
                            class="overflow-hidden smart-textarea block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2 resize-none">{{ old($name, $detail->$name ?? '') }}</textarea>
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
                                  bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC]
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

                    <div class="mt-2 rounded-lg border border-blue-200 bg-blue-50 p-3">
                        <p class="text-sm font-semibold text-blue-700">
                            Template Excel Peserta
                        </p>

                        <p class="text-sm text-gray-700 mt-1">
                            Baris pertama (header) wajib menggunakan urutan kolom berikut:
                        </p>

                        <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                            <li>Nama Peserta</li>
                            <li>NIP Peserta</li>
                            <li>Jabatan Peserta</li>
                            <li>Subunitkerja Peserta</li>
                        </ul>
                    </div>
                    <div class="relative mb-3 mt-2">
                        <input type="file" name="peserta_laporan" accept=".xls,.xlsx" class="block w-full text-sm text-gray-700
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC]
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
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkundangan_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Materi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Materi Kegiatan</label>
                        <input type="text" name="linkmateri_laporan" value="{{ old('linkmateri_laporan', $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkmateri_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Daftar Hadir Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Daftar Hadir Kegiatan</label>
                        <input type="text" name="linkdaftarhadir_laporan" value="{{ old('linkdaftarhadir_laporan', $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
                        @error('linkdaftarhadir_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link Dokumentasi Kegiatan --}}
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unggah Link Dokumentasi Kegiatan</label>
                        <input type="text" name="linkdokumentasi_laporan" value="{{ old('linkdokumentasi_laporan', $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan) }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="https://docs.google.com/...">
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

    {{-- INPUT UTAMA --}}
    <input type="file" id="fileInput"
        accept=".jpg,.png,.jpeg"
        class="block w-full text-sm text-gray-700
        border border-[#E0E7FF] rounded-lg cursor-pointer
        bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC]
        focus:outline-none p-2">

    {{-- ERROR --}}
    @error('gambardokumentasi_laporan')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror

    {{-- LIST FILE --}}
    <div id="fileList" class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"></div>

    {{-- TEMPAT FILE YANG DIKIRIM KE BACKEND --}}
    <div id="fileContainer"></div>
</div>

                    {{-- Pilih Jenis Template Sertifikat --}}
                <div class="mt-4">
    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
        Pilih Jenis Template Sertifikat
    </label>

    <label class="flex items-center gap-2 text-sm mb-2">
        <input type="radio" name="jenissertifikat_kegiatan" value="template_bkpsdm"
            {{ old('jenissertifikat_kegiatan', $laporankegiatans->jenissertifikat_kegiatan ?? '') == 'template_bkpsdm' ? 'checked' : '' }}>
        Template BKPSDM
    </label>

    <label class="flex items-center gap-2 text-sm">
        <input type="radio" name="jenissertifikat_kegiatan" value="template_opd"
            {{ old('jenissertifikat_kegiatan', $laporankegiatans->jenissertifikat_kegiatan ?? '') == 'template_opd' ? 'checked' : '' }}>
        Template OPD
    </label>

    @error('jenissertifikat_kegiatan')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                {{-- Template Sertifikat --}}
                <div class="mt-4" id="uploadTemplateWrapper">
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
<div class="mt-6 relative flex items-center justify-between">

    {{-- Tombol Batal (Kiri) --}}
    <a href="{{ route('admin.usulankegiatan.index') }}"
        class="w-40 text-center py-2.5 rounded-lg
        bg-gray-300 text-gray-700 font-semibold
        hover:bg-gray-200 transition">
        Batal
    </a>

    {{-- Step Tengah --}}
    <div class="absolute left-1/2 transform -translate-x-1/2">
        <span class="text-sm font-semibold text-gray-500">
            Step <span class="text-[#FFA41B] font-bold">2</span> dari 4
        </span>
    </div>

    {{-- Tombol Submit (Kanan) --}}
    <button type="submit"
        class="w-40 py-2.5 rounded-lg
        bg-[#FFA41B] text-white font-semibold
        hover:bg-[#ff9600] transition">
        Submit Laporan
    </button>

</div>
            </form>
        </main>
    </div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#tanggalmulai_kegiatan", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

    flatpickr("#tanggalselesai_kegiatan", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr("#waktumulai_kegiatan", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

flatpickr("#waktuselesai_kegiatan", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
</script>

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

            const radios = document.querySelectorAll('input[name="jenissertifikat_kegiatan"]');
    const uploadWrapper = document.getElementById('uploadTemplateWrapper');

    function toggleUpload() {
        const selected = document.querySelector('input[name="jenissertifikat_kegiatan"]:checked')?.value;

        if (selected === 'template_opd') {
            uploadWrapper.style.display = 'block';
        } else {
            uploadWrapper.style.display = 'none';
        }
    }

    radios.forEach(radio => {
        radio.addEventListener('change', toggleUpload);
    });

    toggleUpload(); // 🔥 initial load (penting buat edit mode)
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
    </script>

<script>
    const input = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    const fileContainer = document.getElementById('fileContainer');

    let filesArray = [];

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        // validasi sederhana (optional tapi bagus)
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
            alert('File harus JPG/PNG!');
            input.value = '';
            return;
        }

        filesArray.push(file);
        renderFiles();

        input.value = ''; // reset supaya bisa pilih lagi
    });

    function renderFiles() {
    fileList.innerHTML = '';
    fileContainer.innerHTML = '';

    filesArray.forEach((file, index) => {

        // CARD
        const card = document.createElement('div');
        card.className = `
            flex items-center justify-between
            bg-white border border-gray-200 rounded-lg
            px-3 py-2 shadow-sm hover:shadow-md transition
        `;

        // NAMA FILE
        const fileInfo = document.createElement('div');
        fileInfo.className = "flex items-center gap-2 overflow-hidden";

        const icon = document.createElement('span');

        const name = document.createElement('span');
        name.className = "text-sm text-gray-700 truncate max-w-[120px]";
        name.textContent = file.name;

        fileInfo.appendChild(icon);
        fileInfo.appendChild(name);

        // BUTTON HAPUS
        const btn = document.createElement('button');
        btn.innerHTML = '✖';
        btn.className = "text-red-500 hover:text-red-700 text-sm";

        btn.onclick = () => {
            filesArray.splice(index, 1);
            renderFiles();
        };

        card.appendChild(fileInfo);
        card.appendChild(btn);
        fileList.appendChild(card);

        // hidden input (tetap sama)
        const dt = new DataTransfer();
        dt.items.add(file);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'file';
        hiddenInput.name = 'gambardokumentasi_laporan[]';
        hiddenInput.files = dt.files;
        hiddenInput.style.display = 'none'; // WAJIB


        fileContainer.appendChild(hiddenInput);

        const preview = document.createElement('img');
preview.src = URL.createObjectURL(file);
preview.className = "w-10 h-10 object-cover rounded";

fileInfo.prepend(preview);
    });
}
</script>

<script>
function pilihTemplateDefault() {
    const hiddenInput = document.getElementById('pakaiTemplateDefault');
    const img = document.getElementById('defaultTemplate');

    if (hiddenInput.value == "1") {
        // ❌ kalau sudah dipilih → batalin
        hiddenInput.value = "0";
        img.classList.remove('border-blue-500');
    } else {
        // ✅ kalau belum → pilih
        hiddenInput.value = "1";
        img.classList.add('border-blue-500');

        // reset upload kalau pilih template default
        document.getElementById('uploadInput').value = "";
    }

    document.getElementById('uploadInput').addEventListener('change', function() {
    document.getElementById('pakaiTemplateDefault').value = "0";

    const img = document.getElementById('defaultTemplate');
    img.classList.remove('border-blue-500');
});
}


</script>

</x-app-layout>

