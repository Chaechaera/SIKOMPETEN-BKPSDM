<x-app-layout>
    <div class="p-6 space-y-6">

        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold mb-4">Daftar Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN</h1>

        <!-- Bagian Progress Stepper -->
        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border">
            <h2 class="text-lg font-semibold mb-3">Progress Pengajuan</h2>
            {{-- Komponen Stepper (bisa dijadikan partial blade include) --}}
            @include('components.proggres-stepper', ['statususulan_kegiatanSaatini' => $usulankegiatans[0]->statususulan_kegiatan ?? 'pending'])
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-3 mt-4">
            <a href="{{ route('admin.usulankegiatan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Buat Usulan Baru
            </a>

            <a href="{{ route('admin.usulankegiatan.createTTD') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Kop dan TTD
            </a>
        </div>

        <!-- Tabel Daftar Usulan -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg mt-4 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 text-left w-10">No</th>
                        <th class="p-2 text-left">Nomor Surat</th>
                        <th class="p-2 text-left">Perihal Surat</th>
                        <th class="p-2 text-left">Nama Kegiatan</th>
                        <th class="p-2 text-left">Tanggal Pelaksanaan Kegiatan</th>
                        <th class="p-2 text-left">Status Usulan Kegiatan</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $u)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <!-- Nomor Otomatis -->
                        <td class="p-2 text-center">{{ $loop->iteration }}</td>

                        <!-- Nomor Surat -->
                        <td class="p-2">{{ $u->identitassurats->nomor_surat ?? '-' }}</td>

                        <!-- Perihal Surat -->
                        <td class="p-2">{{ $u->identitassurats->perihal_surat ?? '-' }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="p-2 font-medium">{{ $u->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="p-2">{{ $u->tanggalpelaksanaan_kegiatan ?? '-' }}</td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="p-2 capitalize font-semibold">
                            @php
                            $statususulan_kegiatans = $u->statususulan_kegiatan ?? '-';
                            $statususulan_kegiatanClass = match($statususulan_kegiatans) {
                            'pending' => 'text-yellow-600',
                            'approved' => 'text-green-600',
                            'in_progress' => 'text-blue-600',
                            'completed' => 'text-purple-600',
                            'draft' => 'text-gray-500',
                            'rejected' => 'text-red-600',
                            default => 'text-gray-500'
                            };
                            @endphp
                            <span class="{{ $statususulan_kegiatanClass }}">
                                {{ str_replace('_', ' ', $statususulan_kegiatans) }}
                            </span>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="p-2 space-x-2" x-data="{ open: false }">
                            <!-- Tombol Lihat Detail -->
                            <button @click="open = !open" class="text-indigo-600 hover:underline font-medium">
                                Lihat Detail
                            </button>

                            <!-- Dropdown Detail -->
                            <div x-show="open" @click.outside="open = false"
                                class="absolute mt-2 bg-white border rounded shadow-md p-3 text-sm z-10">
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('admin.usulankegiatan.download', $u->id) }}" target="_blank" class="text-green-600 hover:text-green-700 underline">
                                        Lihat Surat Usulan
                                    </a>
                                    <a href="#" target="_blank" class="text-green-600 hover:text-green-700 underline">
                                        Lihat Laporan
                                    </a>
                                    <a href="#" target="_blank" class="text-green-600 hover:text-green-700 underline">
                                        Lihat Surat Balasan Laporan
                                    </a>

                                    @if(auth()->user()->role === 'admin')
                                    @if($u->statususulan_kegiatan === 'accepted')
                                    <!-- Tahap Pelaksanaan -->
                                    <a href="{{ route('admin.pelaksanaankegiatan.create', $u->id) }}" target="_blank"
                                        class="text-indigo-600 hover:underline font-medium">
                                        Update Pelaksanaan Kegiatan
                                    </a>
                                    @elseif($u->statususulan_kegiatan === 'in_progress')
                                    <!-- Tahap Laporan Hasil -->
                                    <a href="{{ route('admin.laporankegiatan.create', $u->id) }}" target="_blank"
                                        class="text-indigo-600 hover:underline font-medium">
                                        Update Laporan Hasil Kegiatan
                                    </a>
                                    @endif
                                    @endif
                                </div>
                            </div>

                            <!-- Edit -->
                            <a href="#" class="text-indigo-600 hover:underline font-medium">
                                Edit
                            </a>

                            <!-- Hapus -->
                            <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus usulan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">
                                    Hapus
                                </button>
                            </form>

                            <!-- Download Sertifikat -->
                            <a href="#" target="_blank" class="text-green-600 hover:underline font-medium">
                                Download Sertifikat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 p-4">
                            Tidak ada data usulan kegiatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>