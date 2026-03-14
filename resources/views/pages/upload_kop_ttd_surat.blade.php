<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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
                        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                            <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Data Terkait OPD</h2>

                            <!-- 🔻 DIVIDER -->
                            <div class="my-4 border-t-2 border-gray-200"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                {{-- Unit Kerja --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja</label>
                                    <div class="relative">
                                        <input type="text" value="{{ $unitkerjas }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] 
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
                                  bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] 
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
                                  bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] 
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
                            <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">Data Gambar Terkait OPD</h2>

                            <!-- 🔻 DIVIDER -->
                            <div class="my-4 border-t-2 border-gray-200"></div>

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
                                  focus:outline-none p-2" {{ $kopunitkerjas ? '' : 'required' }}>
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
                                  focus:outline-none p-2" {{ $ttdunitkerjas ? '' : 'required' }}>
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
                                  focus:outline-none p-2" {{ $stempelunitkerjas ? '' : 'required' }}>
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
                                class="w-2/12 text-center py-2.5 rounded-lg  bg-gray-300 text-gray-700 font-semibold hover:bg-gray-200 transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="w-2/12 py-2.5 rounded-lg bg-gradient-to-r from-[#FFA41B] to-[#FFA41B] text-white font-semibold hover:opacity-90 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>