<x-app-layout>
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

    <!-- SIDEBAR -->
    @include('pages.sidebar.admin')

    {{-- Main Content --}}
        <main 
        class="flex-1 p-6 space-y-6 transition-all duration-300"
        :class="sidebarOpen ? 'ml-64' : 'ml-0'"
        >

            
            {{-- 📝 FORM PENGAJUAN USULAN --}}
            <form method="POST" action="{{ route('admin.usulankegiatan.store') }}" enctype="multipart/form-data">
                @csrf

                    <div class="bg-white rounded-xl shadow p-6 mb-10">
    <h1 class="text-2xl font-semibold text-[#2B3674]">
        FORMULIR PENGAJUAN USULAN
    </h1>
    <p class="text-sm text-gray-500 max-w-2xl">
        Silakan lengkapi data pada form ini untuk mengajukan usulan kegiatan. 
        Pastikan semua informasi yang dibutuhkan terisi dengan benar sebelum disimpan atau diajukan.
    </p>
</div>

                <!-- 🟦 IDENTITAS SURAT -->
                <div class="bg-white rounded-xl shadow p-6 mb-10">
                    <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Identitas Surat</h2>
                    <p class="text-gray-500 text-sm mb-6">Lengkapi informasi identitas usulan.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Nomor Surat</label>
                            <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                placeholder="Contoh: 01/OPD/2025"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            @error('nomor_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            @error('tanggal_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Perihal</label>
                            <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                                placeholder="Masukkan perihal surat"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            @error('perihal_surat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Lampiran Surat</label>
                            <input type="text" name="lampiran_surat" value="1 Bendel" readonly
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                        </div>
                    </div>
                </div>

                <!-- 🟨 USULAN KEGIATAN -->
                <div class="bg-white rounded-xl shadow p-6 mb-10">
                    <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Usulan Kegiatan</h2>
                    <p class="text-gray-500 text-sm mb-6">Lengkapi informasi usulan kegiatan.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Sub Unit Kerja</label>
                            <input type="text" value="{{ $subunitkerjas ?? '' }}" readonly
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                placeholder="Masukkan nama kegiatan"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            @error('nama_kegiatan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan" value="{{ old('lokasi_kegiatan') }}"
                                placeholder="Masukkan lokasi kegiatan"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Cara Pelatihan</label>
                            <select name="carapelatihan_id"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">-- Pilih Cara Pelatihan --</option>
                                @foreach($carapelatihans as $c)
                                    <option value="{{ $c->id }}" {{ old('carapelatihan_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->cara_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggalpelaksanaan_kegiatan" value="{{ old('tanggalpelaksanaan_kegiatan') }}"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Diajukan Oleh</label>
                            <input type="text" value="{{ auth()->user()->nama }}" readonly
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>
                    </div>
                </div>

                <!-- 🟩 DETAIL KEGIATAN -->
                <div class="bg-white rounded-xl shadow p-6 mb-10">
                    <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Detail Kegiatan</h2>
                    <p class="text-gray-500 text-sm mb-6">Lengkapi informasi detail kegiatan.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700">Narasumber Kegiatan</label>
                            <input type="text" name="narasumber_kegiatan" value="{{ old('narasumber_kegiatan') }}"
                                placeholder="Masukkan narasumber kegiatan"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Jumlah Peserta</label>
                            <input type="text" name="peserta_kegiatan" value="{{ old('peserta_kegiatan') }}"
                                placeholder="Masukkan jumlah peserta"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Alokasi Anggaran</label>
                            <input type="text" name="alokasianggaran_kegiatan" value="{{ old('alokasianggaran_kegiatan') }}"
                                placeholder="Masukkan anggaran"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700">Metode Pelatihan</label>
                            <select name="metodepelatihan_id"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="">-- Pilih Metode Pelatihan --</option>
                                @foreach($metodepelatihans as $m)
                                    <option value="{{ $m->id }}" {{ old('metodepelatihan_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->metode_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Unggah Jadwal Pelaksanaan (Excel)</label>
                            <input type="file" name="jadwalpelaksanaan_kegiatan" accept=".xls,.xlsx"
                                class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>

                        @php
                            $fields = [
                                'dasarhukum_kegiatan' => 'Dasar Hukum Kegiatan',
                                'latarbelakang_kegiatan' => 'Latar Belakang Kegiatan',
                                'maksud_kegiatan' => 'Maksud Kegiatan',
                                'tujuan_kegiatan' => 'Tujuan Kegiatan',
                                'uraian_kegiatan' => 'Uraian Kegiatan',
                                'hasil_kegiatan' => 'Hasil Kegiatan',
                            ];
                        @endphp

                        @foreach($fields as $name => $label)
                            <div class="sm:col-span-2">
                                <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
                                <textarea name="{{ $name }}" placeholder="Masukkan {{ strtolower($label) }}"
                                    class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm h-28">{{ old($name) }}</textarea>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 🔘 Tombol -->
                <div class="flex justify-between mt-10">
                    <a href="{{ url('admin/usulankegiatan/listusulankegiatan') }}"
                        class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                    </a>

                    <div class="flex gap-3">
                        <button type="submit" name="statususulan_kegiatan" value="draft"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
                            Simpan Draft
                        </button>
                        <button type="submit" name="statususulan_kegiatan" value="pending"
                            class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
                            Kirim Usulan<i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>
