<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- 📝 FORM PENGAJUAN USULAN --}}
        <form method="POST" action="{{ route('admin.usulankegiatan.storeAwal') }}" enctype="multipart/form-data">
            @csrf

            <div class="bg-white rounded-xl shadow p-6 mb-4">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Silahkan ajukan nama usulan kegiatan pada form ini dan pastikan data nama usulan kegiatan yang diisikan telah sesuai sebelum diajukan.
                </p>
            </div>

            {{-- Step Progress --}}
            <x-step-progress />

            {{-- ===================================================== --}}
            {{-- ======= BAGIAN 1: AJUKAN NAMA USULAN KEGIATAN ======= --}}
            {{-- ===================================================== --}}
            <div class="bg-white rounded-xl shadow p-6 mb-10">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Unit Kerja yang Mengajukan</label>
                    <div class="relative">
                        <input type="text" value="{{ $unitkerjas ?? '' }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                        <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja yang Mengajukan</label>
                    <div class="relative">
                        <input type="text" value="{{ $subunitkerjas ?? '' }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                        <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan yang Diajukan</label>
                    <div class="relative">
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#F9FAFF] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                        @error('nama_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Perwakilan yang Mengajukan</label>
                    <div class="relative">
                        <input type="text" value="{{ auth()->user()->nama }}" class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-[#e8ecff] focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" readonly>
                        <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                    </div>
                </div>
            </div>

            {{-- ==================================================== --}}
            {{-- === BAGIAN 2: BUTTON AJUKAN NAMA USULAN KEGIATAN === --}}
            {{-- ==================================================== --}}
            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.usulankegiatan.index') }}"
                    class="w-2/12 text-center py-2.5 bg-gray-300 text-gray-700 px-6 rounded-lg text-sm hover:bg-gray-200 transition font-semibold">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="submit" name="statususulan_kegiatan" value="draft"
                    class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                    Ajukan Usulan<i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</x-app-layout>