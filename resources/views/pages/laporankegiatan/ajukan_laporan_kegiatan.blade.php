<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Laporan Hasil Kegiatan Pengembangan Kompetensi ASN
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.laporankegiatan.store', $usulankegiatans->id) }}" enctype="multipart/form-data">
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
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                            class="border rounded w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perihal Surat</label>
                        <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan perihal">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lampiran Surat</label>
                        <input type="text" name="lampiran_surat" value="1 Bendel"
                            class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: LAPORAN HASIL KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Laporan Hasil Kegiatan</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan"
                            value="{{ $usulankegiatans->nama_kegiatan ?? old('nama_kegiatan') }}"
                            class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="usulankegiatan_id" value="{{ $usulankegiatans->id }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Cara Pelatihan</label>
                        <input type="text"
                            value="{{ $usulankegiatans->carapelatihans->cara_pelatihan ?? 'Tidak Diketahui' }}"
                            class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="carapelatihan_id"
                            value="{{ $usulankegiatans->carapelatihans->id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Waktu Pelaksanaan Laporan</label>
                        <input type="text" name="waktupelaksanaan_laporan"
                            value="{{ old('waktupelaksanaan_laporan') }}"
                            class="border p-2 w-full" placeholder="Contoh: 09.00 WIB s.d. 15.00 WIB">
                    </div>

                    @php
                    $fields = [
                    'latarbelakang_laporan' => 'Latar Belakang',
                    'dasarhukum_laporan' => 'Dasar Hukum',
                    'maksud_laporan' => 'Maksud Kegiatan',
                    'tujuan_laporan' => 'Tujuan Kegiatan',
                    'ruanglingkup_laporan' => 'Ruang Lingkup Kegiatan'
                    ];
                    @endphp

                    @foreach($fields as $name => $label)
                    <div class="mt-4">
                        <label class="block font-medium">{{ $label }}</label>
                        <textarea name="{{ $name }}" class="mt-1 w-full border p-2 rounded">{{ old($name) }}</textarea>
                    </div>
                    @endforeach

                    <div class="mt-4">
                        <label class="block font-medium">Metode Pelatihan</label>
                        <select name="metodepelatihan_id" class="border p-2 w-full" required>
                            <option value="">-- Pilih Metode Pelatihan --</option>
                            @foreach($metodepelatihans as $m)
                            <option value="{{ $m->id }}">{{ $m->metode_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Narasumber Kegiatan</label>
                        <input type="text" name="narasumber_laporan" value="{{ old('narasumber_laporan') }}"
                            class="border p-2 w-full" placeholder="Nama narasumber kegiatan">
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Penutup</label>
                        <textarea name="penutup_laporan" class="border p-2 w-full"
                            placeholder="Tuliskan kesimpulan atau penutup laporan">{{ old('penutup_laporan') }}</textarea>
                    </div>

                    {{-- ===================================================== --}}
                    {{-- ATRIBUT KHUSUS OTOMATIS SESUAI CARA PELATIHAN --}}
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
                {{-- BAGIAN 3: DETAIL LAPORAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Detail Laporan Kegiatan</h2>

                    <div class="mt-4">
                        <label class="block font-medium">Rincian Laporan</label>
                        <textarea name="rincian_laporan" class="w-full border p-2 rounded">{{ old('rincian_laporan') }}</textarea>
                        @error('jadwalpelaksanaan_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Output Kegiatan</label>
                        <textarea name="outputkegiatan_laporan" class="w-full border p-2 rounded">{{ old('outputkegiatan_laporan') }}</textarea>
                        @error('outputkegiatan_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Rundown (Excel)</label>
                        <input type="file" name="rundown_laporan" accept=".xls,.xlsx" class="border p-2 w-full">
                        @error('rundown_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Peserta Kegiatan (Excel)</label>
                        <input type="file" name="peserta_laporan" accept=".xls,.xlsx" class="border p-2 w-full">
                        @error('peserta_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Undangan</label>
                        <input type="text" name="undangan_laporan" value="{{ old('undangan_laporan') }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('undangan_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Materi Kegiatan</label>
                        <input type="text" name="materi_laporan" value="{{ old('materi_laporan') }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('materi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Daftar Hadir</label>
                        <input type="text" name="daftarhadir_laporan" value="{{ old('daftarhadir_laporan') }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('daftarhadir_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Link Dokumentasi Kegiatan</label>
                        <input type="text" name="dokumentasi_laporan" value="{{ old('dokumentasi_laporan') }}"
                            class="border p-2 w-full" placeholder="https://docs.google.com/...">
                        @error('dokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block font-medium">Unggah Gambar Dokumentasi Kegiatan (JPG, PNG, JPEG)</label>
                        <input type="file" name="gambardokumentasi_laporan[]" accept=".jpg,.png,.jpeg"
                            class="border p-2 w-full" multiple id="gambardokumentasi_laporanFiles" required>
                        @error('gambardokumentasi_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Tempat munculnya daftar file -->
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- TOMBOL AKSI --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Batal
                    </a>
                    <button type="submit" name="statususulan_kegiatan" value="completed"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ambil elemen input dan daftar file
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