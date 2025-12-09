<x-app-layout>
<div class="min-h-screen bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-full">

    <!-- SIDEBAR -->
    @include('pages.sidebar.admin')

    {{-- Main Content --}}
        <main 
        class="flex-1 p-6 space-y-6 transition-all duration-300"
        :class="sidebarOpen ? 'ml-64' : 'ml-0'"
        >

        <!-- JUDUL -->
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h1 class="text-2xl font-semibold text-[#2B3674]">
                DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN
            </h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan.
            </p>
        </div>

        <!-- PROGRES -->
        <div class="w-full bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-[#2B3674] mb-6">PROGRES PENGAJUAN</h2>

            @include('components.proggres-stepper', [
                'statususulan_kegiatanSaatini' => $usulankegiatans[0]->statususulan_kegiatan ?? 'pending'
            ])
        </div>

        <!-- BUTTON TAMBAH -->
        <div class="flex flex-wrap gap-2 w-full sm:w-auto justify-end mb-2">
            <a href="{{ route('admin.usulankegiatan.create') }}"
                class="bg-[#FFA41B] text-white px-4 py-2 rounded-lg hover:bg-[#ff9600] transition">
                + Buat Usulan Baru
            </a>

            <a href="{{ route('admin.usulankegiatan.createTTD') }}"
                class="bg-[#FFA41B] text-white px-4 py-2 rounded-lg hover:bg-[#ff9600] transition">
                + Tambah Kop dan TTD
            </a>
        </div>

        <!-- TABLE -->
        <section class="bg-white rounded-xl shadow p-4 sm:p-6">
            <div class="overflow-x-auto w-full">
                <table class="min-w-full text-sm text-gray-600">
                    <thead class="border-b text-gray-700 bg-[#FAFAFB]">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold">No</th>
                            <th class="py-3 px-4 text-left font-semibold">Nomor Surat</th>
                            <th class="py-3 px-4 text-left font-semibold">Perihal Surat</th>
                            <th class="py-3 px-4 text-left font-semibold">Nama Kegiatan</th>
                            <th class="py-3 px-4 text-left font-semibold">Tanggal Pelaksanaan</th>
                            <th class="py-3 px-4 text-left font-semibold">Status</th>
                            <th class="py-3 px-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($usulankegiatans as $u)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="py-3 px-4 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $u->identitassurats->nomor_surat ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $u->identitassurats->perihal_surat ?? '-' }}</td>
                            <td class="py-3 px-4 font-medium">{{ $u->nama_kegiatan }}</td>
                            <td class="py-3 px-4">{{ $u->tanggalpelaksanaan_kegiatan ?? '-' }}</td>

                            <!-- STATUS -->
                            <td class="py-3 px-4 capitalize font-semibold">
                                @php
                                    $status = $u->statususulan_kegiatan ?? '-';
                                    $color = match($status) {
                                        'pending' => 'text-yellow-600',
                                        'approved' => 'text-green-600',
                                        'in_progress' => 'text-blue-600',
                                        'completed' => 'text-purple-600',
                                        'draft' => 'text-gray-500',
                                        'rejected' => 'text-red-600',
                                        default => 'text-gray-500'
                                    };
                                @endphp

                                <span class="{{ $color }}">{{ str_replace('_', ' ', $status) }}</span>
                            </td>

                            <!-- AKSI -->
                            <td class="p-2 space-x-2 relative flex items-center" x-data="{ open: false }">

                                <!-- DETAIL -->
                                <button @click="open = !open"
                                    class="bg-[#4361EE] text-white text-xs px-4 py-1.5 rounded-md hover:bg-[#3651d4] transition">
                                    Detail
                                </button>

                                <!-- MODAL DETAIL (mengikuti backend) -->
                                <div 
                                    x-show="open"
                                    x-transition.opacity
                                    class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50"
                                >
                                    <div @click.outside="open = false"
                                        x-transition.scale
                                        class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-gray-100">

                                        <button @click="open = false"
                                            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition text-lg font-bold">
                                            ✖
                                        </button>

                                        <h2 class="text-lg font-bold text-gray-700 mb-4">
                                            Detail Usulan Kegiatan
                                        </h2>

                                        <p class="text-sm text-gray-500 mb-6">
                                            Pilih dokumen yang ingin kamu lihat:
                                        </p>

                                        <div class="flex flex-col space-y-3 font-bold">

                                            <a href="{{ route('admin.usulankegiatan.download', $u->id) }}" 
                                                target="_blank"
                                                class="block px-4 py-2 rounded-lg bg-[#edf2fb] text-[#3a0ca3]">
                                                Lihat Surat Usulan
                                            </a>

                                            <a href="#" target="_blank"
                                                class="block px-4 py-2 rounded-lg bg-[#e0fbfc] text-[#0077b6]">
                                                Lihat Laporan
                                            </a>

                                            <a href="#" target="_blank"
                                                class="block px-4 py-2 rounded-lg bg-[#ffe5ec] text-[#d00000]">
                                                Lihat Surat Balasan Laporan
                                            </a>

                                            @if(auth()->user()->role === 'admin')

                                                @if($u->statususulan_kegiatan === 'accepted')
                                                    <a href="{{ route('admin.pelaksanaankegiatan.create', $u->id) }}"
                                                        target="_blank"
                                                        class="block px-4 py-2 rounded-lg bg-[#ffedd5] text-[#9a3412]">
                                                        Update Pelaksanaan Kegiatan
                                                    </a>
                                                @elseif($u->statususulan_kegiatan === 'in_progress')
                                                    <a href="#" 
                                                        class="block px-4 py-2 rounded-lg bg-[#e0f2fe] text-[#0369a1]">
                                                        Update Laporan Hasil Kegiatan
                                                    </a>
                                                @endif

                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- EDIT -->
                                <a href="#">
                                    <img src="{{ asset('images/edit.png') }}" class="w-5 h-5">
                                </a>

                                <!-- DELETE -->
                                <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah kamu yakin ingin menghapus usulan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block">
                                        <img src="{{ asset('images/delete.png') }}" alt="Hapus" class="w-5 h-5 inline">
                                    </button>
                                </form>

                                <!-- LAPORAN -->
                                @if($u->statususulan_kegiatan === 'in_progress')
                                    <a href="#"
                                        class="bg-[#38bdf8] text-white text-xs px-3 py-1.5 rounded-md hover:bg-[#0ea5e9] transition inline-block">
                                        Laporan
                                    </a>
                                @endif

                            </td>

                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">
                                    Tidak ada data usulan kegiatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </main>

</div>
</x-app-layout>
