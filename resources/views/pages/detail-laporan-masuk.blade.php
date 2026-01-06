<x-app-layout>
    @php
        $report = (object)[
            'id' => 'LAP-001',
            'proposalId' => 'USL-015',
            'namaKegiatan' => 'Pelatihan Leadership untuk Kepala Sekolah',
            'opd' => 'Dinas Pendidikan',
            'pengirim' => 'Dr. Ahmad Suryadi, M.Pd',
            'tanggalPengajuan' => '10 November 2025',
            'tanggalPelaksanaan' => '5–7 November 2025',
            'lokasi' => 'Hotel Santika Kota',
            'status' => 'pending',
            'jumlahPeserta' => 45,
            'dokumentasi' => 12,
            'laporanFile' => 'Laporan_Pelatihan_Leadership_2025.pdf'
        ];
    @endphp

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <a href="{{ url('laporan-masuk') }}"
                   class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-gray-100 flex items-center gap-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>

                {{-- STATUS --}}
                @if($report->status === 'pending')
                    <span class="bg-yellow-100 text-yellow-700 text-sm px-4 py-2 rounded-lg">
                        Menunggu Verifikasi
                    </span>
                @elseif($report->status === 'approved')
                    <span class="bg-green-100 text-green-700 text-sm px-4 py-2 rounded-lg">
                        Disetujui
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
                    Detail Laporan Hasil Kegiatan
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $report->id }}
                </p>
            </div>

            {{-- DETAIL CARD --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">

                {{-- HEADER KEGIATAN --}}
                <div class="bg-purple-50 p-5">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 17v-6h6v6M3 3h18v18H3z"/>
                        </svg>
                        {{ $report->namaKegiatan }}
                    </h3>
                    <p class="text-sm text-gray-600">{{ $report->opd }}</p>
                </div>

                <div class="p-6 space-y-8">

                    {{-- INFORMASI LAPORAN --}}
                    <section>
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Laporan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <p class="text-xs text-gray-500">ID Laporan</p>
                                <p class="text-sm font-medium">{{ $report->id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">ID Usulan Terkait</p>
                                <p class="text-sm font-medium">{{ $report->proposalId }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Pengajuan</p>
                                <p class="text-sm font-medium">{{ $report->tanggalPengajuan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">File Laporan</p>
                                <a href="#" class="text-blue-600 text-sm font-medium hover:underline flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4v12m0 0l4-4m-4 4l-4-4M4 20h16"/>
                                    </svg>
                                    {{ $report->laporanFile }}
                                </a>
                            </div>
                        </div>
                    </section>

                    {{-- INFORMASI OPD --}}
                    <section class="pt-6 border-t">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi OPD</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <p class="text-sm font-medium">{{ $report->opd }}</p>
                            <p class="text-sm font-medium">{{ $report->pengirim }}</p>
                        </div>
                    </section>

                    {{-- INFORMASI PELAKSANAAN --}}
                    <section class="pt-6 border-t">
                        <h4 class="font-semibold text-gray-900 mb-4">Informasi Pelaksanaan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <p class="text-sm font-medium">{{ $report->tanggalPelaksanaan }}</p>
                            <p class="text-sm font-medium">{{ $report->lokasi }}</p>
                            <p class="text-sm font-medium">{{ $report->jumlahPeserta }} orang</p>
                            <p class="text-sm font-medium">{{ $report->dokumentasi }} foto</p>
                        </div>
                    </section>

                    {{-- ACTION --}}
                    <section class="pt-6 border-t">
                        @if($report->status === 'pending')
                            <div class="flex gap-4">
                                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium">
                                    Setujui Laporan
                                </button>
                                <button class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-lg font-medium">
                                    Tolak Laporan
                                </button>
                            </div>
                        @elseif($report->status === 'approved')
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">
                                Generate Sertifikat ({{ $report->jumlahPeserta }} peserta)
                            </button>
                        @endif
                    </section>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
