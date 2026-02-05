<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.laporankegiatan.store', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="laporankegiatan_id" value="{{ $usulankegiatans->laporankegiatans->id ?? '' }}">

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: LENGKAPI USULAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Laporan Hasil Kegiatan</h2>

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
                                value="{{ old('lokasi_kegiatan', $usulankegiatans?->lokasi_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block font-medium">Cara Pelatihan</label>
                            <select name="carapelatihan_id" class="border p-2 w-full" required>
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                <option value="{{ $c->id }}" {{ old('carapelatihan_id', $usulankegiatans?->carapelatihan_id) == $c->id ? 'selected' : '' }}>{{ $c->cara_pelatihan }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block font-medium">Tanggal Mulai</label>
                            <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulankegiatans?->tanggalmulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block font-medium">Tanggal Selesai</label>
                            <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulankegiatans?->tanggalselesai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block font-medium">Waktu Mulai</label>
                            <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulankegiatans?->waktumulai_kegiatan) }}"
                                class="border p-2 w-full" required>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block font-medium">Waktu Selesai</label>
                            <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulankegiatans?->waktuselesai_kegiatan) }}"
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
                {{-- BAGIAN 1: DETAIL LAPORAN HASIL KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Laporan Hasil Kegiatan</h2>

                    @php
                    $fields = [
                    'latarbelakang_laporan' => 'Latar Belakang',
                    'dasarhukum_laporan' => 'Dasar Hukum',
                    'maksud_laporan' => 'Maksud Kegiatan',
                    'tujuan_laporan' => 'Tujuan Kegiatan',
                        'uraian_kegiatan' => 'Uraian Kegiatan',
                        'hasillangsung_kegiatan' => 'Hasil Langsung Kegiatan',
                        'hasilmenengah_kegiatan' => 'Hasil Menengah Kegiatan',
                        'hasilpanjang_kegiatan' => 'Hasil Panjang Kegiatan',
                        'narasumber_kegiatan' => 'Narasumber Kegiatan',
                        'sasaranpeserta_kegiatan' => 'Sasaran Peserta Kegiatan',
                        'detailhasil_kegiatan' => 'Detail Hasil Kegiatan',
                        'penyelenggara_kegiatan' => 'Penyelenggara Kegiatan',
                    ];
                    @endphp

                    @foreach($fields as $name => $label)
                    <div class="mt-4">
                        <label class="block font-medium">{{ $label }}</label>
                        {{-- <textarea name="{{ $name }}" class="mt-1 w-full border p-2 rounded" readonly>{{ old($name, $usulankegiatans?->$name) }}</textarea> --}}
                        <textarea class="mt-1 w-full border p-2 rounded bg-gray-100" readonly>{{ $usulankegiatans?->$name }}</textarea>
                        <input type="hidden" name="{{ $name }}" value="{{ $usulankegiatans?->$name }}">
                    </div>
                    @endforeach

                    <div class="mt-4">
                        <label class="block font-medium">Metode Pelatihan</label>
                        {{-- <select name="metodepelatihan_id" class="border p-2 w-full" required> --}}
                        <select class="border p-2 w-full bg-gray-100" disabled>
                            <option value="">-- Pilih Metode Pelatihan --</option>
                            @foreach($metodepelatihans as $m)
                            <option value="{{ $m->id }}" {{ old('metodepelatihan_id', $usulankegiatans?->metodepelatihan_id) == $m->id ? 'selected' : '' }}>{{ $m->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="metodepelatihan_id" value="{{ $usulankegiatans?->metodepelatihan_id }}">
                    </div>

                    {{-- <div class="mt-4">
                        <label class="block font-medium">Narasumber Kegiatan</label>
                        <input type="text" name="narasumber_laporan" value="{{ old('narasumber_laporan', $usulankegiatans?->carapelatihan_id) }}"
                            class="border p-2 w-full" placeholder="Nama narasumber kegiatan">
                    </div> --}}

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: ATRIBUT KHUSUS --}}
                {{-- ===================================================== --}}
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
                            <textarea name="{{ $key }}" class="border p-2 w-full" placeholder="{{ $field['label'] }}">{{ old($key) }}</textarea>
                            @else
                            <input type="{{ $field['type'] }}" name="{{ $key }}" class="border p-2 w-full" placeholder="https://docs.google.com/..." value="{{ old($key) }}">
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>

                {{-- ===================================================== --}}
                {{-- TOMBOL AKSI --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit" name="statuslaporan_kegiatan" value="completed"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>