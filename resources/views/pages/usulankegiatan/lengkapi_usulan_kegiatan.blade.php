<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Buat Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.usulankegiatan.update', $usulan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: LENGKAPI USULAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Usulan Kegiatan</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Sub Unit Kerja --}}
                        <div>
                            <label class="block font-medium">Sub Unit Kerja</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Unit Kerja --}}
                        <div>
                            <label class="block font-medium">Unit Kerja</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Nama Kegiatan</label>
                            <input type="text"
                                value="{{ $nama_kegiatan ?? '' }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="nama_kegiatan" value="{{ $nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Lokasi Kegiatan --}}
                        <div>
                            <label class="block font-medium">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan"
                                value="{{ old('lokasi_kegiatan', $usulan->lokasi_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block font-medium">Cara Pelatihan</label>
                            <select name="carapelatihan_id" class="border p-2 w-full" required>
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulan->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block font-medium">Tanggal Mulai</label>
                            <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulan->tanggalmulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block font-medium">Tanggal Selesai</label>
                            <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulan->tanggalselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block font-medium">Waktu Mulai</label>
                            <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulan->waktumulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block font-medium">Waktu Selesai</label>
                            <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulan->waktuselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Diajukan Oleh --}}
                        <div class="md:col-span-2">
                            <label class="block font-medium">Diajukan Oleh</label>
                            <input type="text"
                                value="{{ auth()->user()->nama }}"
                                class="border p-2 w-full bg-gray-100"
                                readonly>
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>

                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 3: DETAIL KEGIATAN --}}
                {{-- ===================================================== --}}
                @php
                //$detail = $usulan->detailusulankegiatans;
                @endphp

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
                        'hasillangsung_kegiatan' => 'Hasil Langsung Kegiatan',
                        'hasilmenengah_kegiatan' => 'Hasil Menengah Kegiatan',
                        'hasilpanjang_kegiatan' => 'Hasil Panjang Kegiatan',
                        'narasumber_kegiatan' => 'Narasumber Kegiatan',
                        'sasaranpeserta_kegiatan' => 'Sasaran Peserta Kegiatan',
                        'detailhasil_kegiatan' => 'Detail Hasil Kegiatan',
                        'penyelenggara_kegiatan' => 'Penyelenggara Kegiatan',
                        'penutup_kegiatan' => 'Penutup Kegiatan',
                        ];
                        @endphp

                        @foreach($fields as $name => $label)
                        <div class="mt-4">
                            <label class="block font-medium">{{ $label }}</label>
                            <textarea name="{{ $name }}" class="mt-1 w-full border p-2 rounded">{{ old($name, $detail->$name) }}</textarea>
                            @error($name)
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @endforeach

                        <div class="mt-4">
                            <label class="block font-medium">Alokasi Anggaran Kegiatan</label>
                            <input type="text" name="alokasianggaran_kegiatan" value="{{ old('alokasianggaran_kegiatan', $detail->alokasianggaran_kegiatan) }}"
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
                                <option value="{{ $m->id }}" {{ old('metodepelatihan_id', $detail->metodepelatihan_id) == $m->id ? 'selected' : '' }}>{{ $m->metode_pelatihan }}</option>
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