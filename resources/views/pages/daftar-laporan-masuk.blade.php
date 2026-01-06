<x-app-layout>
    @php
        $reports = [
            (object)[
                'id' => 'LAP-001',
                'proposalId' => 'USL-015',
                'namaKegiatan' => 'Pelatihan Leadership untuk Kepala Sekolah',
                'opd' => 'Dinas Pendidikan',
                'pengirim' => 'Dr. Ahmad Suryadi, M.Pd',
                'tanggalPengajuan' => '10 November 2025',
                'tanggalPelaksanaan' => '5-7 November 2025',
                'lokasi' => 'Hotel Santika Kota',
                'status' => 'pending',
                'jumlahPeserta' => 45,
                'dokumentasi' => 12,
                'laporanFile' => 'Laporan_Pelatihan_Leadership_2025.pdf'
            ],
            (object)[
                'id' => 'LAP-002',
                'proposalId' => 'USL-018',
                'namaKegiatan' => 'Workshop Digital Marketing untuk UMKM',
                'opd' => 'Dinas Pariwisata',
                'pengirim' => 'Ir. Rina Kusuma, M.M',
                'tanggalPengajuan' => '9 November 2025',
                'tanggalPelaksanaan' => '3-5 November 2025',
                'lokasi' => 'Gedung Kreatif Hub',
                'status' => 'approved',
                'jumlahPeserta' => 60,
                'dokumentasi' => 18,
                'laporanFile' => 'Laporan_Workshop_Digital_Marketing.pdf'
            ],
            // Tambahkan laporan dummy lainnya jika mau
        ];

        $statusFilter = request('status', 'all');
        $searchQuery = request('search', '');
        $filteredReports = array_filter($reports, function($r) use ($statusFilter, $searchQuery){
            $matchesSearch = stripos($r->namaKegiatan, $searchQuery) !== false
                || stripos($r->id, $searchQuery) !== false
                || stripos($r->opd, $searchQuery) !== false;

            $matchesStatus = $statusFilter === 'all' || $r->status === $statusFilter;
            return $matchesSearch && $matchesStatus;
        });
    @endphp

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- Header --}}
            <div class="flex items-center gap-4">
                <a href="superadmin/dashboard"  
                    class="bg-white text-blue-600 px-6 py-2 rounded-lg text-medium hover:bg-gray-200 transition">
                    &larr; Kembali
                </a>
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-[#2B3674]">Daftar Laporan Hasil Kegiatan</h2>
                    <p class="text-sm text-gray-500">Kelola dan verifikasi laporan hasil kegiatan untuk penerbitan sertifikat</p>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white p-6 rounded-lg shadow flex flex-col md:flex-row gap-4">
                <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Cari nama kegiatan, ID laporan, atau OPD..." class="flex-1 border rounded-lg pl-3 pr-3 py-2">
                <select name="status" class="border rounded-lg px-3 py-2 md:w-48">
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="approved" {{ $statusFilter == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ $statusFilter == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Usulan</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">6</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE5B4] shadow-sm">
                <h2 class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</h2>
                <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#DFFFE0] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Usulan Disetujui</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">3</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Peserta</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">312</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="text-left py-3 px-4 text-sm text-gray-600">ID Laporan</th>
                            <th class="text-left py-3 px-4 text-sm text-gray-600">Nama Kegiatan</th>
                            <th class="text-left py-3 px-4 text-sm text-gray-600">OPD</th>
                            <th class="text-left py-3 px-4 text-sm text-gray-600">Peserta</th>
                            <th class="text-left py-3 px-4 text-sm text-gray-600">Status</th>
                            <th class="text-center py-3 px-4 text-sm text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filteredReports as $report)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-900">{{ $report->id }}</td>
                            <td class="py-3 px-4">
                                <p class="text-sm text-gray-900">{{ $report->namaKegiatan }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $report->tanggalPelaksanaan }}</p>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ $report->opd }}</td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ $report->jumlahPeserta }} orang</td>
                            <td class="py-3 px-4">
                                @if($report->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Menunggu Verifikasi</span>
                                @elseif($report->status == 'approved')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Disetujui</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('detail-laporan') }}" class="text-blue-600 hover:underline text-sm">Detail</a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
