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

                {{-- ===================================================== --}}
                {{-- ======= BAGIAN 1: AJUKAN NAMA USULAN KEGIATAN ======= --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Ajukan Nama Usulan Kegiatan Pengembangan Kompetensi ASN</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Unit Kerja yang Mengajukan</label>
                        <input type="text" value="{{ $unitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="unitkerja_id" value="{{ $unitkerja_id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Sub Unit Kerja yang Mengajukan</label>
                        <input type="text" value="{{ $subunitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Nama Kegiatan yang Diajukan</label>
                        <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="border p-2 w-full" required>
                        @error('nama_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perwakilan yang Mengajukan</label>
                        <input type="text" value="{{ auth()->user()->nama }}" class="border p-2 w-full bg-gray-100" readonly>
                        <input type="hidden" name="dibuat_oleh" value="{{ auth()->id() }}">
                    </div>
                </div>

                {{-- ==================================================== --}}
                {{-- === BAGIAN 2: BUTTON AJUKAN NAMA USULAN KEGIATAN === --}}
                {{-- ==================================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button type="submit" name="statususulan_kegiatan" value="draft"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                        Submit
                    </button>
                </div>
            </form>
        </main>
    </div>
</x-app-layout>
