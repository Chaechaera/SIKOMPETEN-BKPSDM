<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Detail Pelaksanaan Kegiatan Pengembangan Kompetensi ASN</h1>

        <div class="bg-white shadow-md rounded-lg p-6">

            {{-- Header Judul Pelaksanaan Kegiatan yang Dilihat --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold mb-4">{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}</h2>
                <p class="text-gray-600">
                    Dilaksanakan oleh: {{ $usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }} <br>
                    Lokasi Kegiatan: {{ $usulankegiatans->lokasi_kegiatan }} <br>
                    Tanggal Pelaksanaan: {{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                    \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}
                </p>
            </div>

            {{-- Garis Pembatas Header dengan Gambar --}}
            <hr class="my-4">

            {{-- List Gambar yang Ditampilkan dalam Grid Kotak --}}
            <h2 class="text-lg font-semibold mb-2">Gambar Bukti Pelaksanaan Kegiatan</h2>
            @if(!empty($buktipelaksanaan_kegiatanFiles) && count($buktipelaksanaan_kegiatanFiles))
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($buktipelaksanaan_kegiatanFiles as $file)
                <div class="border rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <a href="{{ Storage::url($file) }}" target="_blank">
                        <img
                            src="{{ Storage::url($file) }}"
                            class="w-full h-full object-cover"
                            alt="Bukti Pelaksanaan Kegiatan">
                    </a>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500">Belum Ada Gambar Bukti Pelaksanaan Kegiatan yang Diunggah</p>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-6">
                <a href="{{ auth()->user()->role == 'admin' ? route('admin.usulankegiatan.index') : route('superadmin.usulankegiatan.pending')}}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>