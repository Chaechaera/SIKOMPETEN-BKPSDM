<x-app-layout>
    @php
        $usulan = (object)[
            'id' => 'USL-004',
            'namaKegiatan' => 'Pelatihan SPBE dan Transformasi Digital',
            'opd' => 'Diskominfo',
            'status' => 'approved',

            // Surat
            'nomorSurat' => '023/KOMINFO/2025',
            'tanggalPengajuan' => '8 November 2025',
            'perihal' => 'Permohonan Izin Pelatihan SPBE bagi Operator IT OPD',

            // OPD
            'subUnit' => 'Bidang Aplikasi Informatika',
            'pengirim' => 'Ir. Rahmat Hidayat, M.T',

            // Kegiatan
            'tanggalPelaksanaan' => '18–20 November 2025',
            'lokasi' => 'Online via Zoom',
            'caraPelatihan' => 'Daring',
            'anggaran' => 'Rp 15.000.000'
        ];
    @endphp

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <a href="{{ url('usulan-masuk') }}"
                   class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>

                @if($usulan->status === 'approved')
                    <span class="bg-green-100 text-green-700 text-sm px-4 py-2 rounded-lg">
                        Disetujui
                    </span>
                @elseif($usulan->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-700 text-sm px-4 py-2 rounded-lg">
                        Menunggu Verifikasi
                    </span>
                @else
                    <span class="bg-red-100 text-red-700 text-sm px-4 py-2 rounded-lg">
                        Ditolak
                    </span>
                @endif
            </div>

            {{-- JUDUL --}}
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    Detail Usulan Kegiatan
                </h2>
                <p class="text-sm text-gray-500">{{ $usulan->id }}</p>
            </div>

            {{-- CARD --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">

                {{-- HEADER KEGIATAN --}}
                <div class="bg-blue-50 p-5">
                    <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6l4 2M4 6h16M4 18h16"/>
                        </svg>
                        {{ $usulan->namaKegiatan }}
                    </h3>
                    <p class="text-sm text-gray-600">{{ $usulan->opd }}</p>
                </div>

                <div class="p-6 space-y-8">

                    {{-- INFORMASI SURAT --}}
                    <section>
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Surat</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500">Nomor Surat</p>
                                <p class="text-sm font-medium">{{ $usulan->nomorSurat }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Pengajuan</p>
                                <p class="text-sm font-medium">{{ $usulan->tanggalPengajuan }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500">Perihal</p>
                                <p class="text-sm font-medium">{{ $usulan->perihal }}</p>
                            </div>
                        </div>
                    </section>

                    {{-- INFORMASI OPD --}}
                    <section class="pt-6 border-t">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi OPD</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500">OPD Pengusul</p>
                                <p class="text-sm font-medium">{{ $usulan->opd }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Sub Unit Kerja</p>
                                <p class="text-sm font-medium">{{ $usulan->subUnit }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Pengirim</p>
                                <p class="text-sm font-medium">{{ $usulan->pengirim }}</p>
                            </div>
                        </div>
                    </section>

                    {{-- INFORMASI KEGIATAN --}}
                    <section class="pt-6 border-t">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Kegiatan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Pelaksanaan</p>
                                <p class="text-sm font-medium">{{ $usulan->tanggalPelaksanaan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Lokasi Kegiatan</p>
                                <p class="text-sm font-medium">{{ $usulan->lokasi }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Cara Pelatihan</p>
                                <span class="inline-block bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">
                                    {{ $usulan->caraPelatihan }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Alokasi Anggaran</p>
                                <p class="text-sm font-medium">{{ $usulan->anggaran }}</p>
                            </div>
                        </div>
                    </section>

                    {{-- ACTION --}}
                    <section class="pt-6 border-t">
                        <div class="flex justify-center mt-6">
                <a href="{{ url('surat-balasan-usulan') }}">
                <a href="{{ url('balasan-usulan') }}">
            <button
                class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-medium hover:bg-[#ff9600] transition">
                Buat Surat Balasan
            </button>
                </a>
</div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
