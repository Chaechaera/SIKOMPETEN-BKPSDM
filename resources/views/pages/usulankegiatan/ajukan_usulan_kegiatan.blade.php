<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Buat Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.usulankegiatan.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- ===================================================== --}}
                {{-- BAGIAN 1: IDENTITAS SURAT --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Identitas Surat</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Nomor Surat</label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan nomor surat">
                        @error('nomor_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                            class="border rounded w-full p-2">
                        @error('tanggal_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perihal Surat</label>
                        <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan perihal">
                        @error('perihal_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lampiran Surat</label>
                        <input type="text" name="lampiran_surat" value="1 Bendel" class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: USULAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Usulan Kegiatan</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Sub Unit Kerja Pengajuan Kegiatan</label>
                        <input type="text" value="{{ $subunitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="border p-2 w-full" required>
                        @error('nama_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lokasi Kegiatan</label>
                        <input type="text" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}" class="border p-2 w-full" required>
                        @error('lokasi_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Cara Pelatihan Kegiatan</label>
                        <select name="carapelatihan_id" class="border p-2 w-full" required>
                            <option value="">-- Pilih Cara Pelatihan Kegiatan --</option>
                            @foreach($carapelatihans as $c)
                            <option value="{{ $c->id }}">{{ $c->cara_pelatihan }}</option>
                            @endforeach
                        </select>
                        @error('carapelatihan_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Pelaksanaan Kegiatan</label>
                        <input type="date" name="tanggalpelaksanaan_kegiatan" value="{{ old('tanggalpelaksanaan_kegiatan') }}"
                            class="border p-2 w-full" required>
                        @error('tanggalpelaksanaan_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Diajukan Oleh</label>
                        <input type="text" value="{{ auth()->user()->nama }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 3: DETAIL KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Detail Kegiatan</h2>

                    {{-- Form Detail --}}
                    <div class="p-4 border rounded">
                        <h3 class="font-semibold mb-2">Detail Kegiatan</h3>

                        @php
                        $fields = [
                        'latarbelakang_kegiatan' => 'Latar Belakang Kegiatan',
                        'dasarhukum_kegiatan' => 'Dasar Hukum Kegiatan',
                        'uraian_kegiatan' => 'Uraian Kegiatan',
                        'maksud_kegiatan' => 'Maksud Kegiatan',
                        'tujuan_kegiatan' => 'Tujuan Kegiatan',
                        'hasil_kegiatan' => 'Hasil Kegiatan'
                        ];
                        @endphp

                        @foreach($fields as $name => $label)
                        <div class="mt-4">
                            <label class="block font-medium">{{ $label }}</label>
                            <textarea name="{{ $name }}" class="mt-1 w-full border p-2 rounded">{{ old($name) }}</textarea>
                            @error($name)
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @endforeach

                        <div class="mt-4">
                            <label class="block font-medium">Narasumber Kegiatan</label>
                            <input type="text" name="narasumber_kegiatan" value="{{ old('narasumber_kegiatan') }}"
                                class="border p-2 w-full">
                            @error('narasumber_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium">Peserta Kegiatan</label>
                            <input type="text" name="peserta_kegiatan" value="{{ old('peserta_kegiatan') }}"
                                class="border p-2 w-full">
                            @error('peserta_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium">Alokasi Anggaran</label>
                            <input type="text" name="alokasianggaran_kegiatan" value="{{ old('alokasianggaran_kegiatan') }}"
                                class="border p-2 w-full">
                            @error('alokasianggaran_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium">Metode Pelatihan</label>
                            <select name="metodepelatihan_id" class="border p-2 w-full" required>
                                <option value="">-- Pilih Metode Pelatihan Kegiatan --</option>
                                @foreach($metodepelatihans as $m)
                                <option value="{{ $m->id }}">{{ $m->metode_pelatihan }}</option>
                                @endforeach
                            </select>
                            @error('metodepelatihan_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label class="block font-medium">Unggah Jadwal Pelaksanaan Kegiatan (Excel)</label>
                            <input type="file" name="jadwalpelaksanaan_kegiatan" accept=".xls,.xlsx"
                                class="border p-2 w-full">
                            @error('jadwalpelaksanaan_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="submit" name="statususulan_kegiatan" value="draft"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Simpan Draft
                            </button>
                            <button type="submit" name="statususulan_kegiatan" value="pending"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Kirim Usulan
                            </button>
                        </div>
            </form>
        </div>
    </div>
</x-app-layout>