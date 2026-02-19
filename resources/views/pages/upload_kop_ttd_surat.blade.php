<x-app-layout>
    <div class="h-full bg-white flex justify-center items-center">

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-6xl border border-[#f3f4f6] relative">

            <!-- Tombol Close -->
            <button onclick="window.history.back()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-all">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>

            <h1 class="text-2xl font-bold text-[#2B3674] mb-4 text-center">
                Form Upload Data Tambahan OPD
            </h1>

            <form method="POST" action="{{ route('admin.kopunitkerja.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- ====================================================== --}}
                {{-- ============= BAGIAN 1: DATA TERKAIT OPD ============= --}}
                {{-- ====================================================== --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-4">
                    <h2 class="text-xl font-semibold text-[#5A5A5A] mb-4">Data Terkait OPD</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja</label>
                            <div class="relative">
                                <input type="text" value="{{ $unitkerjas }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                                <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id }}">
                            </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja</label>
                            <div class="relative">
                                <input type="text" value="{{ $subunitkerjas }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                                <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id }}">
                            </div>
                        </div>

                        {{-- Nama OPD --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama OPD</label>
                            <div class="relative">
                                <input type="text" value="{{ $nama_opd }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
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
                        ];
                        @endphp

                        @foreach($fields as $name => $label)
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">{{ $label }}</label>
                            <div class="relative">
                                <input type="text" name="{{ $name }}" value="{{ old($name, $kopunitkerjas?->$name) }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" required>
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
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-[#5A5A5A] mb-4">Data Gambar Terkait OPD</h2>

                    {{-- Upload Gambar Kop --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            File Kop OPD
                            <span class="text-gray-400 text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="text-xs text-gray-500">Contoh nama file: kop_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarkop_opd" id="gambarkop_opd" accept=".png,.jpg,.jpeg" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" required>
                            @error('gambarkop_opd')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar Tanda Tangan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            File TTD PenanggungJawab OPD
                            <span class="text-gray-400 text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="text-xs text-gray-500">Contoh nama file: ttd_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarttd_opd" id="gambarttd_opd" accept=".png,.jpg,.jpeg" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" required>
                            @error('gambarttd_opd')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar Stempel --}}
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                            File Stempel OPD
                            <span class="text-gray-400 text-sm">(PNG/JPG/JPEG)</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Format: .png / .jpg/ .jpeg</p>
                        <p class="text-xs text-gray-500">Contoh nama file: stempel_opd.png</p>
                        <div class="relative mb-3 mt-2">
                            <input type="file" name="gambarstempel_opd" id="gambarstempel_opd" accept=".png,.jpg,.jpeg"
                                class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" required>
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
                    <button href="{{ route('admin.usulankegiatan.index') }}"
                        class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>