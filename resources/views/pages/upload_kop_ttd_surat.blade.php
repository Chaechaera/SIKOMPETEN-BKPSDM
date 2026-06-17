<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Card Informasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">
                LENGKAPI DATA KOP, TANDA TANGAN, DAN STEMPEL SUB UNIT KERJA OPD ANDA
            </h1>
            <p class="text-sm text-abuabuCerah max-w-5xl">
                Silakan lengkapi data kop surat, tanda tangan, dan stempel sub unit kerja OPD Anda sebagai bagian dari kelengkapan administrasi dokumen kegiatan
            </p>
        </div>

        <!-- Card -->
        <div class="w-full max-w-7xl relative">

            <form method="POST" action="{{ $kopunitkerjas ? route('admin.kopunitkerja.update', $kopunitkerjas->id) : route('admin.kopunitkerja.store') }}" enctype="multipart/form-data">
                @csrf
                @if($kopunitkerjas)
                @method('PUT')
                @endif

                {{-- ====================================================== --}}
                {{-- ============= BAGIAN 1: DATA TERKAIT OPD ============= --}}
                {{-- ====================================================== --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-6">
                    <h2 class="text-lg font-bold bg-primary-gradient bg-clip-text text-transparent leading-tight mb-4">Data Terkait OPD</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-abuabuCerah/70"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Unit Kerja</label>
                            <div class="relative">
                                <input type="text" value="{{ $unitkerjas }}" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                                <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id }}">
                            </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Sub Unit Kerja</label>
                            <div class="relative">
                                <input type="text" value="{{ $subunitkerjas }}" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                                <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id }}">
                            </div>
                        </div>

                        {{-- Nama OPD --}}
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">Nama OPD</label>
                            <div class="relative">
                                <input type="text" value="{{ $nama_opd }}" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruGelap focus:ring-2 focus:outline-none p-2" readonly>
                                <input type="hidden" name="nama_opd" value="{{ $nama_opd }}">
                            </div>
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
                        'jabatanpenanggungjawab_opd' => 'Jabatan Penanggung Jawab OPD',
                        'pangkatpenanggungjawab_opd' => 'Pangkat Penanggung Jawab OPD',
                        'namakepala_opd' => 'Nama Kepala OPD',
                        'nipkepala_opd' => 'NIP Kepala OPD',
                        ];
                        @endphp

                        @foreach($fields as $name => $label)
                        <div>
                            <label class="block text-sm font-medium text-abuabuDark mb-2">{{ $label }}</label>
                            <div class="relative">
                                <input type="text" name="{{ $name }}" value="{{ old($name, $ttdunitkerjas?->$name ?? $kopunitkerjas?->$name) }}" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer bg-biruMuda focus:ring-2 focus:outline-none p-2" required>
                                @error($name)
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ========================================================= --}}
                {{-- =========== BAGIAN 2: DATA GAMBAR TERKAIT OPD =========== --}}
                {{-- ========================================================= --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-6">
                    <h2 class="text-lg font-bold bg-primary-gradient bg-clip-text text-transparent leading-tight mb-4">Data Gambar Terkait OPD</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-abuabuCerah/70"></div>

                    {{-- Upload Gambar Kop --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-abuabuDark mb-2">
                            Unggah File Kop OPD
                            <span class="text-abuabuCerah text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="font-normal text-xs text-abuabuBesi mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="font-normal text-xs text-abuabuBesi">Contoh nama file: kop_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarkop_opd" id="gambarkop_opd" accept=".png,.jpg,.jpeg" class="block w-full font-medium text-sm text-abuabuDark 
                                    border border-abuabuMuda rounded-lg cursor-pointer bg-biruMuda focus:ring-2 file:text-xs file:font-medium file:bg-abuabuMuda file:py-2 file:px-3 file:rounded-md file:border-[0.5px] focus:outline-none p-2" {{ $kopunitkerjas ? '' : 'required' }}>
                            @if($kopunitkerjas?->gambarkop_opd)
                            <div class="mt-2">
                                <span>
                                    <p class="text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/'.$kopunitkerjas->gambarkop_opd) }}" target="_blank" class="text-blue-600">
                                            {{ basename($kopunitkerjas->gambarkop_opd) }}
                                        </a>
                                    </p>
                                    <img src="{{ asset('storage/'.$kopunitkerjas->gambarkop_opd) }}"
                                        class="h-16 rounded border">
                                </span>
                            </div>
                            @endif
                            @error('gambarkop_opd')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar Tanda Tangan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-abuabuDark mb-2">
                            Unggah File TTD PenanggungJawab OPD
                            <span class="text-abuabuCerah text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="font-normal text-xs text-abuabuBesi mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="font-normal text-xs text-abuabuBesi">Contoh nama file: ttd_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarttd_opd" id="gambarttd_opd" accept=".png,.jpg,.jpeg" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer
                                    bg-biruMuda focus:ring-2 file:text-xs file:font-medium file:bg-abuabuMuda file:py-2 file:px-3 file:rounded-md file:border-[0.5px] focus:outline-none p-2" {{ $ttdunitkerjas ? '' : 'required' }}>
                            @if($ttdunitkerjas?->gambarttd_opd)
                            <div class="mt-2">
                                <span>
                                    <p class="text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/'.$ttdunitkerjas->gambarttd_opd) }}" target="_blank" class="text-blue-600">
                                            {{ basename($ttdunitkerjas->gambarttd_opd) }}
                                        </a>
                                    </p>
                                    <img src="{{ asset('storage/'.$ttdunitkerjas->gambarttd_opd) }}"
                                        class="h-16 rounded border">
                                </span>
                            </div>
                            @endif
                            @error('gambarttd_opd')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar Stempel --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-abuabuDark mb-2">
                            File Stempel OPD
                            <span class="text-abuabuCerah text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="text-xs text-abuabuBesi mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="text-xs text-abuabuBesi">Contoh nama file: stempel_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarstempel_opd" id="gambarstempel_opd" accept=".png,.jpg,.jpeg" class="block w-full font-medium text-sm text-abuabuDark border border-abuabuMuda rounded-lg cursor-pointer
                                    bg-biruMuda focus:ring-2 file:text-xs file:font-medium file:bg-abuabuMuda file:py-2 file:px-3 file:rounded-md file:border-[0.5px] focus:outline-none p-2" {{ $stempelunitkerjas ? '' : 'required' }}>
                            @if($stempelunitkerjas?->gambarstempel_opd)
                            <div class="mt-2">
                                <span>
                                    <p class="text-xs text-gray-500">File saat ini:
                                        <a href="{{ asset('storage/'.$stempelunitkerjas->gambarstempel_opd) }}" target="_blank" class="text-blue-600">
                                            {{ basename($stempelunitkerjas->gambarstempel_opd) }}
                                        </a>
                                    </p>
                                    <img src="{{ asset('storage/'.$stempelunitkerjas->gambarstempel_opd) }}"
                                        class="h-16 rounded border">
                                </span>
                            </div>
                            @endif
                            @error('gambarstempel_opd')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.usulankegiatan.index') }}"
                        class="w-2/12 text-center py-2.5 bg-abuabuMuda rounded-lg font-semibold hover:bg-abuabuMuda/60 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-2/12 py-2.5 bg-orangeMuda text-white rounded-lg font-semibold hover:bg-orangeMuda/80 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>