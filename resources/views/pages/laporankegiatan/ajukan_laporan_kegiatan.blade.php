<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            <form method="POST" action="{{ route('admin.laporankegiatan.store', $usulankegiatans->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="laporankegiatan_id" value="{{ $usulankegiatans->laporankegiatans->id ?? '' }}">

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-gray-500 max-w-6xl">
                        Silahkan lengkapi data awal untuk laporan hasil kegiatan Pengembangan Kompetensi ASN yang telah terselenggarakan pada form ini dan pastikan data yang diisikan telah sesuai.
                    </p>
                </div>

                {{-- Step Progress --}}
                <x-step-progress :usulan="$usulankegiatans" :is-laporan="true"/>

                {{-- ====================================================== --}}
                {{-- === BAGIAN 1: AJUKAN DATA UTAMA LAPORAN HASIL KEGIATAN --}}
                {{-- ====================================================== --}}
                <div class="bg-white rounded-xl shadow p-6 mb-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div>
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
                        <div>
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
                                <select name="carapelatihan_id" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
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
                                    value="{{ old('lokasi_kegiatan', $usulankegiatans?->lokasi_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Mulai Diselenggarakan</label>
                            <div class="relative">
                                <input type="date" name="tanggalmulai_kegiatan" value="{{ old('tanggalmulai_kegiatan', $usulankegiatans?->tanggalmulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan Selesai Diselenggarakan</label>
                            <div class="relative">
                                <input type="date" name="tanggalselesai_kegiatan" value="{{ old('tanggalselesai_kegiatan', $usulankegiatans?->tanggalselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Dimulai</label>
                            <div class="relative">
                                <input type="time" name="waktumulai_kegiatan" value="{{ old('waktumulai_kegiatan', $usulankegiatans?->waktumulai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Waktu Kegiatan Berakhir</label>
                            <div class="relative">
                                <input type="time" name="waktuselesai_kegiatan" value="{{ old('waktuselesai_kegiatan', $usulankegiatans?->waktuselesai_kegiatan) }}"
                                    class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- =============== BAGIAN 3: TOMBOL AKSI =============== --}}
                {{-- ===================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.laporankegiatan.index') }}"
                        class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Batal
                    </a>
                    <button type="submit" name="statuslaporan_kegiatan" value="completed"
                        class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                        Ajukan Laporan<i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>