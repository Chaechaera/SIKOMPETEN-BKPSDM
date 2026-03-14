<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.superadmin')

        {{-- Main Content --}}
        <main class="flex-1 p-6 space-y-6 transition-all duration-300"
              :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/rekap.png') }}" 
                     alt="Validasi" 
                     class="h-8 w-8 mt-1">
                <div>
                    <h1 class="text-2xl font-semibold text-[#2B3674]">
                        VALIDASI LAPORAN PESERTA
                    </h1>
                    <p class="text-sm text-gray-500 max-w-2xl">
                        Superadmin memverifikasi laporan sebelum sertifikat dapat diunduh
                    </p>
                </div>
            </div>

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="rounded-md bg-green-50 border border-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-md bg-red-50 border border-red-100 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-xl shadow p-6">

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Daftar Laporan Peserta
                    </h3>
                    <p class="text-sm text-gray-500">
                        Hanya laporan berstatus <span class="font-medium text-yellow-600">Pending</span> 
                        yang dapat diverifikasi
                    </p>
                </div>

                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-56">Nama Peserta</th>
                                <th class="py-3 px-4 w-56">Kegiatan</th>
                                <th class="py-3 px-4 w-40">Tanggal Upload</th>
                                <th class="py-3 px-4 w-28">Status</th>
                                <th class="py-3 px-4 w-40">File</th>
                                <th class="py-3 px-4 w-48">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($laporans as $index => $laporan)
                                <tr class="border-b hover:bg-gray-50">

                                    {{-- Nomor --}}
                                    <td class="py-3 px-4 text-center">
                                        {{ $laporans->firstItem() 
                                            ? $laporans->firstItem() + $index 
                                            : $index + 1 }}
                                    </td>

                                    {{-- Nama Peserta --}}
                                    <td class="py-3 px-4 font-medium text-gray-800">
                                        {{ $laporan->pesertakegiatans->nama_peserta ?? '-' }}
                                    </td>

                                    {{-- Nama Kegiatan --}}
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ $laporan->pesertakegiatans->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="py-3 px-4 text-center text-gray-600">
                                        {{ optional($laporan->created_at)->format('d M Y') }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-3 px-4 text-center">
                                        @if($laporan->statuslaporan_pesertakegiatan === 'pending')
                                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                                Pending
                                            </span>
                                        @elseif($laporan->statuslaporan_pesertakegiatan === 'approved')
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                                Approved
                                            </span>
                                        @else
                                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-medium">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>

                                    {{-- File --}}
                                    <td class="py-3 px-4 text-center">
                                        @if($laporan->filelaporan_pesertakegiatan)
                                            <a href="{{ asset('storage/' . $laporan->filelaporan_pesertakegiatan) }}"
                                               target="_blank"
                                               class="text-blue-600 hover:underline text-sm">
                                                Lihat File
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-sm">Tidak ada file</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center gap-2">

                                            @if($laporan->statuslaporan_pesertakegiatan === 'pending')

                                                {{-- Approve --}}
                                                <form method="POST"
                                                      action="{{ route('superadmin.laporan.approve', $laporan->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-green-600 text-white hover:bg-green-700">
                                                        Approve
                                                    </button>
                                                </form>

                                                {{-- Reject --}}
                                                <form method="POST"
                                                      action="{{ route('superadmin.laporan.reject', $laporan->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 text-xs font-medium rounded-md bg-red-600 text-white hover:bg-red-700">
                                                        Reject
                                                    </button>
                                                </form>

                                            @else
                                                <button
                                                    class="px-3 py-1.5 text-xs font-medium rounded-md bg-gray-200 text-gray-400 cursor-not-allowed">
                                                    Selesai
                                                </button>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500">
                                        Tidak ada data laporan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($laporans->hasPages())
                <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-3 text-sm text-gray-500">
                    <span>
                        {{ $laporans->firstItem() }}–{{ $laporans->lastItem() }}
                        dari {{ $laporans->total() }} data
                    </span>
                    <div>
                        {{ $laporans->links() }}
                    </div>
                </div>
                @endif

            </div>
        </main>
    </div>
</x-app-layout>