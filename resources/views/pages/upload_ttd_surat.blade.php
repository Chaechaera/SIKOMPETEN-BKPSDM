<x-app-layout>
    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
        <h1 class="text-2xl font-bold mb-4">Upload Tanda Tangan</h1>

        @if (session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
        @endif

        <form action="{{ route('admin.usulankegiatan.uploadTTD') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- === Upload Tanda Tangan === --}}
            <div class="mb-4">
                <label for="tandatangan_pjkegiatan" class="block font-medium mb-2">File Tanda Tangan (PNG/JPG)</label>
                <input type="file" name="tandatangan_pjkegiatan" id="tandatangan_pjkegiatan"
                    class="block w-full border rounded p-2" required>
                @error('tandatangan_pjkegiatan')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- === Tombol Submit === --}}
            <button type="submit"
                class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>