<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Buat Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
        </h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('admin.usulankegiatan.storeAwal') }}">
                @csrf

                {{-- ===================================================== --}}
                {{-- BAGIAN 1: AJUKAN USULAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Ajukan Usulan Kegiatan</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Sub Unit Kerja Pengajuan Kegiatan</label>
                        <input type="text" value="{{ $subunitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Unit Kerja Pengajuan Kegiatan</label>
                        <input type="text" value="{{ $unitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Nama Kegiatan</label>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="border p-2 w-full" required>
                        @error('nama_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Diajukan Oleh</label>
                        <input type="text" value="{{ auth()->user()->nama }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: BUTTON AJUKAN USULAN KEGIATAN --}}
                {{-- ===================================================== --}}
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="submit" name="statususulan_kegiatan" value="draft"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Submit
                            </button>
                        </div>
            </form>
        </div>
    </div>
</x-app-layout>