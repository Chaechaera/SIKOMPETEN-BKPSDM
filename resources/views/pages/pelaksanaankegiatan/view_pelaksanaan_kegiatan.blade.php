<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Detail Pelaksanaan Kegiatan</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold">{{ $usulankegiatans->nama_kegiatan }}</h2>
                <p class="text-gray-600">
                    Dilaksanakan oleh: {{ $usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }} <br>
                    Lokasi Kegiatan: {{ $usulankegiatans->lokasi_kegiatan }} <br>
                    Tanggal Pelaksanaan Kegiatan: {{ $usulankegiatans->tanggalmulai_kegiatan }}
                </p>
            </div>

            <hr class="my-4">

            <h3 class="text-lg font-semibold mb-2">Bukti Pelaksanaan Kegiatan</h3>

            @if(!empty($buktipelaksanaan_kegiatanFiles) && count($buktipelaksanaan_kegiatanFiles))
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($buktipelaksanaan_kegiatanFiles as $file)
                <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <a href="{{ Storage::url($file) }}" target="_blank">
                        <img
                            src="{{ Storage::url($file) }}"
                            class="w-full h-48 object-cover"
                            alt="Bukti Pelaksanaan Kegiatan">
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500">Belum ada bukti pelaksanaan yang diunggah.</p>
            @endif

            <div class="mt-6">
                <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>