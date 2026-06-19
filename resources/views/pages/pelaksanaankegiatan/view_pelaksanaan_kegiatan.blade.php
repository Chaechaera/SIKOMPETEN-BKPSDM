<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

            <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight mb-4">
                Ringkasan Data Kegiatan Pengembangan Kompetensi ASN
            </h2>

            <!-- 🔻 DIVIDER -->
            <div class="my-4 border-t-2 border-gray-200"></div>

            <!-- content grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">

                <!-- Nama Kegiatan -->
                <div>
                    <p class="text-gray-400 text-xs mb-1">Nama Kegiatan</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                    </p>
                </div>

                <!-- Diajukan Oleh -->
                <div>
                    <p class="text-gray-400 text-xs mb-1">Diajukan Oleh</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulankegiatans->subunitkerjas->sub_unitkerja ?? '-' }}
                    </p>
                </div>

                <!-- Lokasi -->
                <div>
                    <p class="text-gray-400 text-xs mb-1">Lokasi Kegiatan</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulankegiatans->lokasi_kegiatan }}
                    </p>
                </div>

                <!-- Tanggal -->
                <div>
                    <p class="text-gray-400 text-xs mb-1">Tanggal Pelaksanaan</p>
                    <p class="font-semibold text-[#5A5A5A]">
                        {{ $usulankegiatans->tanggalmulai_kegiatan && $usulankegiatans->tanggalselesai_kegiatan ? \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                    \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}
                        </p>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="text-base font-semibold text-[#5A5A5A] mb-2">Catatan Pelaksanaan</h3>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700 w-full break-words">
                            {{ $usulankegiatans->inputusulankegiatans?->pelaksanaankegiatans?->catatan_pelaksanaan ?? '-' }}
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="text-base font-semibold text-[#5A5A5A] mb-2">Hambatan Pelaksanaan</h3>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700 w-full break-words">
                            {{ $usulankegiatans->inputusulankegiatans?->pelaksanaankegiatans?->hambatan_pelaksanaan ?? '-' }}
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <h3 class="text-base font-semibold text-[#5A5A5A] mb-2">Solusi Hambatan</h3>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 text-sm text-gray-700 w-full break-words">
                            {{ $usulankegiatans->inputusulankegiatans?->pelaksanaankegiatans?->solusi_hambatan_pelaksanaan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <h2 class="text-lg font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">
                    Detail Gambar Bukti Pelaksanaan Kegiatan Pengembangan Kompetensi ASN
                </h2>

                </div>
                <!-- 🔻 DIVIDER -->
                <div class="my-4 border-t-2 border-gray-200"></div>

                {{-- List Gambar yang Ditampilkan dalam Grid Kotak --}}
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
               {{-- ✅ PAGINATION --}}
@if($buktipelaksanaan_kegiatanFiles instanceof \Illuminate\Pagination\LengthAwarePaginator && $buktipelaksanaan_kegiatanFiles->hasPages())
<div class="mt-6">
    {{ $buktipelaksanaan_kegiatanFiles->links() }}
</div>
@endif
@else
<p class="text-gray-500 text-center py-10">
    Belum Ada Gambar Bukti Pelaksanaan Kegiatan yang Diunggah
</p>
@endif

<div class="mt-12"> {{-- jarak dari atas --}}
    <a href="{{ auth()->user()->role == 'admin' ? route('admin.usulankegiatan.index') : route('superadmin.usulankegiatan.pending')}}"
        class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm font-semibold transition">
        Kembali
    </a>
</div>
            </div>


        </main>
    </div>
</x-app-layout>
