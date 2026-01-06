<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 space-y-6">

            {{-- Header --}}
            <div class="flex items-center gap-4">
                <a href="superadmin/dashboard"  
   class="bg-white text-blue-600 px-6 py-2 rounded-lg text-medium hover:bg-gray-200 transition">
    &larr; Kembali
</a>
                <div class="flex-1">
                    <h2 class="text-2xl font-semibold text-[#2B3674]">Daftar Usulan Kegiatan Masuk</h2>
                    <p class="text-sm text-gray-500">
                        Kelola dan verifikasi usulan kegiatan pengembangan kompetensi dari OPD
                    </p>
                </div>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <input type="text" placeholder="Cari nama kegiatan, nomor surat, atau OPD..." class="w-full pl-10 pr-4 py-2 border rounded-lg" />
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>

                    {{-- Status Filter --}}
                    <select class="w-full md:w-48 border rounded-lg px-3 py-2">
                        <option value="all">Semua Status</option>
                        <option value="pending">Menunggu Verifikasi</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
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
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Usulan (6)</h3>
                </div>
                <div class="overflow-x-auto p-6">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="border-b text-gray-600 text-sm">
                                <th class="py-3 px-4 text-left">No. Surat</th>
                                <th class="py-3 px-4 text-left">Nama Kegiatan</th>
                                <th class="py-3 px-4 text-left">OPD</th>
                                <th class="py-3 px-4 text-left">Tanggal</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= 6; $i++)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm text-gray-900">001/DIKNAS/2025</td>
                                <td class="py-3 px-4">
                                    <p class="text-sm text-gray-900">Pelatihan Manajemen Keuangan Sekolah</p>
                                    <span class="inline-block bg-purple-50 text-purple-700 text-xs px-2 py-1 rounded">Luring</span>
                                </td>
                                <td class="py-3 px-4 text-sm text-gray-900">Dinas Pendidikan</td>
                                <td class="py-3 px-4 text-sm text-gray-900">11 November 2025</td>
                                <td class="py-3 px-4">
                                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Menunggu Verifikasi</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <a href="detail-usulan" class="text-blue-600 hover:underline text-sm">
                                    Detail
                                    </a>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
