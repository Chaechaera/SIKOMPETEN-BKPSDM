<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Form Upload Data Tambahan OPD 
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.kopunitkerja.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- ====================================================== --}}
                {{-- ============= BAGIAN 1: DATA TERKAIT OPD ============= --}}
                {{-- ====================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Data Terkait OPD</h2>

                    {{-- Unit Kerja --}}
                    <div class="mt-4">
                        <label class="block font-medium">Unit Kerja</label>
                        <input type="text"
                            value="{{ $unitkerjas }}"
                            class="border p-2 w-full bg-gray-100"
                            readonly>
                        <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id }}">
                    </div>

                    {{-- Sub Unit Kerja --}}
                    <div class="mt-4">
                        <label class="block font-medium">Sub Unit Kerja</label>
                        <input type="text"
                            value="{{ $subunitkerjas }}"
                            class="border p-2 w-full bg-gray-100"
                            readonly>
                        <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id }}">
                    </div>

                    {{-- Nama OPD --}}
                    <div class="mt-4">
                        <label class="block font-medium mb-1">Nama OPD</label>
                        <input type="text"
                            value="{{ $nama_opd }}"
                            class="w-full border rounded p-2 bg-gray-100"
                            readonly>
                        <input type="hidden" name="nama_opd" value="{{ $nama_opd }}">
                    </div>

                    {{-- Data Lainnya --}}
                    @php
                    $fields = [
                    'lokasi_opd' => 'Lokasi OPD',
                    'telepon_opd' => 'Telepon OPD',
                    'faxmile_opd' => 'Faxmile OPD',
                    'website_opd' => 'Website OPD',
                    'email_opd' => 'Email OPD',
                    'kodepos_opd' => 'Kode Pos OPD',
                    ];
                    @endphp

                    @foreach($fields as $name => $label)
                    <div class="mt-4">
                        <label class="block font-medium">{{ $label }}</label>
                        <input type="text" name="{{ $name }}" value="{{ old($name, $kopunitkerjas?->$name) }}" class="mt-1 w-full border p-2 rounded bg-white">
                        @error($name)
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endforeach
                </div>

                {{-- ========================================================= --}}
                {{-- =========== BAGIAN 2: DATA GAMBAR TERKAIT OPD =========== --}}
                {{-- ========================================================= --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Data Gambar Terkait OPD</h2>

                    {{-- Upload Gambar Kop --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-2">File Kop OPD (PNG/JPG/JPEG)</label>
                        <input type="file" name="gambarkop_opd" id="gambarkop_opd" accept=".png,.jpg,.jpeg" class="border p-2 w-full">
                        @error('gambarkop_opd')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Gambar Tanda Tangan --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-2">File TTD PenanggungJawab OPD (PNG/JPG/JPEG)</label>
                        <input type="file" name="gambarttd_opd" id="gambarttd_opd" accept=".png,.jpg,.jpeg" class="border p-2 w-full">
                        @error('gambarttd_opd')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Upload Gambar Stempel --}}
                    <div class="mb-4">
                        <label class="block font-medium mb-2">File Stempel OPD (PNG/JPG/JPEG)</label>
                        <input type="file" name="gambarstempel_opd" id="gambarstempel_opd" accept=".png,.jpg,.jpeg" class="border p-2 w-full">
                        @error('gambarstempel_opd')
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
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>