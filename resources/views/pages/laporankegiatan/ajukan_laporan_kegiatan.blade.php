<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight"> FORMULIR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Silahkan lengkapi data awal untuk laporan hasil kegiatan Pengembangan Kompetensi ASN yang telah diselenggarakan pada form ini.
            </p>
        </div>
          
        <form method="POST" action="{{ route('admin.laporankegiatan.store', $usulankegiatans->id) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="laporankegiatan_id" value="{{ $usulankegiatans->laporankegiatans->id ?? '' }}">

            {{-- Step Progress --}}
            <x-step-progress :usulan="$usulankegiatans" :is-laporan="true" />

                <div class="bg-white rounded-xl shadow p-6 mb-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Unit Kerja --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja</label>
                            <input type="text"
                                value="{{ $unitkerjas ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja</label>
                            <input type="text"
                                value="{{ $subunitkerjas ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                            <input type="text"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="nama_kegiatan"
                                value="{{ $usulankegiatans->inputusulankegiatans?->nama_kegiatan ?? '' }}">
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cara Pelatihan</label>
                            <select disabled
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-1000 cursor-not-allowed p-2">
                                @foreach($carapelatihans as $c)
                                    <option value="{{ $c->id }}"
                                        {{ $usulankegiatans?->carapelatihan_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->cara_pelatihan }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="carapelatihan_id"
                                value="{{ $usulankegiatans?->carapelatihan_id }}">
                        </div>

                        {{-- Perwakilan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Perwakilan yang Mengajukan
                            </label>
                            <input type="text"
                                value="{{ auth()->user()->nama }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-200 text-gray-600 cursor-not-allowed p-2"
                                readonly>
                            <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                        </div>

                        {{-- Lokasi --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lokasi Kegiatan</label>
                            <input type="text" name="lokasi_kegiatan"
                                value="{{ old('lokasi_kegiatan', $usulankegiatans?->lokasi_kegiatan) }}"
                                class="block w-full text-sm border border-gray-200 rounded-lg
                                bg-gray-50 text-gray-700 p-2" required>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Tanggal Kegiatan Mulai
                            </label>
                            <input type="text"
    id="tanggalmulai_kegiatan"
    name="tanggalmulai_kegiatan"
    value="{{ old('tanggalmulai_kegiatan', $laporankegiatans?->tanggalmulai_kegiatan) }}"
    class="flatpickr block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="dd-mm-yyyy"
    required>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Tanggal Kegiatan Selesai
                            </label>
                            <input type="text"
    id="tanggalselesai_kegiatan"
    name="tanggalselesai_kegiatan"
    value="{{ old('tanggalselesai_kegiatan', $laporankegiatans?->tanggalselesai_kegiatan) }}"
    class="flatpickr block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" placeholder="dd-mm-yyyy"
    required>
                        </div>

                        {{-- Waktu Mulai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Waktu Kegiatan Dimulai
                            </label>
                             <input type="text"
       id="waktumulai_kegiatan"
       name="waktumulai_kegiatan"
       value="{{ old('waktumulai_kegiatan', $laporankegiatans?->waktumulai_kegiatan) }}"
       class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 p-2" placeholder="-- : --"
       required>
                        </div>

                        {{-- Waktu Selesai --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">
                                Waktu Kegiatan Berakhir
                            </label>
                            <input type="text"
       id="waktuselesai_kegiatan"
       name="waktuselesai_kegiatan"
       value="{{ old('waktuselesai_kegiatan', $laporankegiatans?->waktuselesai_kegiatan) }}"
       class="block w-full text-sm text-gray-700 border border-gray-200 rounded-lg bg-gray-50 p-2" placeholder="-- : --"
       required>
                        </div>

                    </div>
                </div>

                {{-- Tombol --}}
                <div class="mt-6 relative flex items-center justify-between">

    {{-- Kiri --}}
    <a href="{{ route('admin.laporankegiatan.index') }}"
        class="w-40 text-center py-2.5 bg-gray-300 text-gray-700
        rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
        Batal
    </a>

    {{-- Step Tengah --}}
    <div class="absolute left-1/2 transform -translate-x-1/2">
        <span class="text-sm font-semibold text-gray-500">
            Step <span class="text-[#FFA41B] font-bold">1</span> dari 4
        </span>
    </div>

    {{-- Kanan --}}
    <button type="submit" name="statuslaporan_kegiatan" value="draft"
        class="w-40 text-center py-2.5 bg-[#FFA41B] text-white
        rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
        Ajukan Laporan
    </button>

</div>

            </form>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    flatpickr("#tanggalmulai_kegiatan", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

    flatpickr("#tanggalselesai_kegiatan", {
        locale: "id",
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d"
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr("#waktumulai_kegiatan", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});

flatpickr("#waktuselesai_kegiatan", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
});
</script>
</x-app-layout>
