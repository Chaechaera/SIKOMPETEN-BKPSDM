<x-app-layout>
    <div class="p-6 space-y-6">

        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold mb-4">Daftar Usulan Kegiatan Pengembangan Kompetensi ASN Yang Diajukan OPD</h1>

        <!-- Tabel Daftar Usulan -->
        <div class="overflow-x-auto">
            <form method="GET" class="mb-4">
                <label class="font-semibold mr-2">Filter Status:</label>
                <select name="statususulan_kegiatan" onchange="this.form.submit()" class="border rounded p-1">
                    <option value="">-- Semua Status Usulan Kegiatan --</option>
                    <option value="pending" {{ request('statususulan_kegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="accepted" {{ request('statususulan_kegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('statususulan_kegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>

            <table class="w-full border border-gray-300 rounded-lg mt-4 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 text-left w-10">No</th>
                        <th class="p-2 text-left">Nomor Surat</th>
                        <th class="p-2 text-left">Perihal Surat</th>
                        <th class="p-2 text-left">Nama Kegiatan</th>
                        <th class="p-2 text-left">Tanggal Pelaksanaan Kegiatan</th>
                        <th class="p-2 text-left">Lokasi Kegiatan</th>
                        <th class="p-2 text-left">Status Usulan Kegiatan</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $u)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <!-- Nomor Otomatis -->
                        <td class="p-2 text-center">{{ $loop->iteration }}</td>

                        <!-- Nomor Surat 
                        <td class="p-2">{{ $u->identitassurats->nomor_surat ?? '-' }}</td>-->

                        <!-- Perihal Surat
                        <td class="p-2">{{ $u->identitassurats->perihal_surat ?? '-' }}</td>-->

                        <!-- Nama Kegiatan -->
                        <td class="p-2 font-medium">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="p-2">{{ $u->tanggalpelaksanaan_kegiatan ?? '-' }}</td>

                        <!-- Lokasi Kegiatan -->
                        <td class="p-2">{{ $u->lokasi_kegiatan ?? '-' }}</td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="p-2 capitalize font-semibold">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="p-2 relative space-x-2" x-data="{ open: false }">
                            <!-- Tombol Lihat Detail -->
                            <button @click="open = !open" class="text-indigo-600 hover:underline font-medium">
                                Cek Dokumen
                            </button>

                            <div x-show="open" @click.outside="open = false"
                                class="absolute mt-2 bg-white border rounded shadow-md p-3 text-sm z-10">
                                <div class="flex flex-col space-y-1">
                                    <a href="{{ route('superadmin.usulankegiatan.download', $u->id) }}" target="_blank"
                                        class="text-green-600 hover:text-green-700 underline">
                                        Lihat Surat Usulan
                                    </a>
                                    <a href="{{ route('superadmin.pelaksanaankegiatan.show', $u->id) }}" target="_blank"
                                        class="text-green-600 hover:text-green-700 underline">
                                        Lihat Keberjalanan
                                    </a>
                                    <a href="{{ route('superadmin.laporankegiatan.download', $u->id) }}" target="_blank"
                                        class="text-green-600 hover:text-green-700 underline">
                                        Lihat Laporan
                                    </a>
                                </div>
                            </div>

                            <!-- Review Usulan -->
                            @if($u->isReviewUsulan())
                            <button
                                onclick="openReviewModal('{{ $u->id }}', 'usulankegiatans')"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Review Usulan
                            </button>
                            @endif

                            <!-- Review Laporan -->
                            @if($u->isReviewLaporan())
                            <button
                                onclick="openReviewModal('{{ $u->inputlaporankegiatans->laporankegiatans->id }}', 'laporankegiatans')"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Review Laporan
                            </button>
                            @endif

                            {{-- ===================== AKSI ADMINISTRATIF ===================== --}}
                            <div class="border rounded p-2 bg-white">
                                <p class="text-xs font-semibold text-gray-500 mb-1">🛠 Administratif</p>

                                <div class="flex flex-wrap gap-2">
                                    {{-- CETAK --}}
                                    @if($u->boleh_cetak)
                                    <form method="POST"
                                        action="{{ route('superadmin.balasanusulankegiatan.cetak', $u->id) }}" onsubmit="return confirm('Yakin cetak?')">
                                        @csrf
                                        <button type="submit"
                                            class="text-indigo-600 hover:underline">
                                            Cetak
                                        </button>
                                    </form>
                                    @elseif($u->inputlaporankegiatans?->laporankegiatans?->boleh_cetak_laporan)
                                    <form method="POST"
                                        action="{{ route('superadmin.balasanlaporankegiatan.cetak', $u->id) }}" onsubmit="return confirm('Yakin cetak?')">
                                        @csrf
                                        <button type="submit"
                                            class="text-indigo-600 hover:underline">
                                            Cetak
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-gray-400 italic">Cetak</span>
                                    @endif


                                    {{-- KIRIM --}}
                                    {{--@if(in_array($u->status_ui, ['accepted']))
                                    <a href="{{ route('superadmin.balasanusulankegiatan.kirim', $u->id) }}"
                                    class="text-indigo-600 hover:underline">
                                    Kirim
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic">Kirim</span>
                                    @endif--}}

                                    @if($u->boleh_kirim)
                                    <a href="{{ route('superadmin.balasanusulankegiatan.kirim', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Kirim
                                    </a>
                                    @elseif($u->inputlaporankegiatans?->laporankegiatans?->boleh_kirim_laporan)
                                    <a href="{{ route('superadmin.balasanlaporankegiatan.kirim', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Kirim
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic">Kirim</span>
                                    @endif


                                    {{-- HAPUS --}}
                                    <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus usulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                                    </form>
                                </div>
                            </div>

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

    <!-- Modal Container -->
    <div id="reviewModalContainer"></div>

    <script>
        async function openReviewModal(id, type) {
            const container = document.getElementById('reviewModalContainer');
            container.innerHTML = `
                <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 text-white">
                    <div class="animate-pulse text-lg">Memuat form review...</div>
                </div>
            `;

            // Tentukan endpoint berdasarkan tipe
            let url = '';

            if (type === 'laporankegiatans') {
                url = `/superadmin/laporankegiatan/${id}/review`;
            } else {
                url = `/superadmin/usulankegiatan/${id}/review`;
            }

            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Gagal memuat form review.');
                const html = await response.text();
                container.innerHTML = html;
            } catch (error) {
                container.innerHTML = `
                    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 text-white">
                        <div class="bg-red-700 p-4 rounded shadow">
                            ${error.message}
                        </div>
                    </div>
                `;
            }
        }
    </script>

</x-app-layout>