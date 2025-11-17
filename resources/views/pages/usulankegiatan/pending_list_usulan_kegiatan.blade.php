<x-app-layout>

    <div class="p-6 space-y-8">

        <!-- ===== HEADER ===== -->
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-semibold text-[#2B3674]">
                DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN
            </h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                Daftar usulan kegiatan yang saat ini sedang dalam proses pengajuan.
            </p>
        </div>

        <!-- ===== FILTER ===== -->
        <div class="bg-white rounded-xl shadow p-6">
            <form method="GET" class="flex items-center gap-4">

        <!-- Label -->
        <label class="font-semibold text-gray-700 flex items-center gap-2">
            <i class="fa-solid fa-filter text-indigo-600"></i>
            Filter Status
        </label>

        <!-- Select -->
        <div class="relative">
            <select 
                name="statususulan_kegiatan"
                onchange="this.form.submit()"
                class="appearance-none border border-gray-300 rounded-lg py-2 pl-4 pr-10
                       text-gray-700 bg-gray-50 hover:bg-gray-100 transition focus:ring-2 
                       focus:ring-indigo-400 focus:border-indigo-400"
            >
                <option value="">-- Semua Status Usulan Kegiatan --</option>

                <option value="pending" 
                    {{ request('statususulan_kegiatan') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="accepted" 
                    {{ request('statususulan_kegiatan') == 'accepted' ? 'selected' : '' }}>
                    Disetujui
                </option>

                <option value="rejected" 
                    {{ request('statususulan_kegiatan') == 'rejected' ? 'selected' : '' }}>
                    Ditolak
                </option>
            </select>

            <!-- Dropdown Icon -->
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
        </div>
    </form>

            <!-- ===== TABLE ===== -->
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full text-sm text-gray-700 border rounded-lg">
                    <thead class="bg-[#FAFAFB] border-b">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold w-10">No</th>
                            <th class="py-3 px-4 text-left font-semibold">Nomor Surat</th>
                            <th class="py-3 px-4 text-left font-semibold">Perihal Surat</th>
                            <th class="py-3 px-4 text-left font-semibold">Nama Kegiatan</th>
                            <th class="py-3 px-4 text-left font-semibold">Tanggal Pelaksanaan</th>
                            <th class="py-3 px-4 text-left font-semibold">Lokasi</th>
                            <th class="py-3 px-4 text-left font-semibold">Status</th>
                            <th class="py-3 px-4 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($usulankegiatans as $u)
                        <tr class="border-b hover:bg-gray-50">

                            <td class="py-3 px-4 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $u->identitassurats->nomor_surat ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $u->identitassurats->perihal_surat ?? '-' }}</td>
                            <td class="py-3 px-4 font-medium">{{ $u->nama_kegiatan }}</td>
                            <td class="py-3 px-4">{{ $u->tanggalpelaksanaan_kegiatan ?? '-' }}</td>
                            <td class="py-3 px-4">{{ $u->lokasi_kegiatan ?? '-' }}</td>

                            <!-- STATUS -->
                            <td class="py-3 px-4 capitalize font-semibold">
                                @php
                                    $status = $u->statususulan_kegiatan;
                                    $color = match($status) {
                                        'pending' => 'text-yellow-600 bg-yellow-100',
                                        'accepted' => 'text-green-600 bg-green-100',
                                        'rejected' => 'text-red-600 bg-red-100',
                                        'in_progress' => 'text-blue-600 bg-blue-100',
                                        'completed' => 'text-purple-600 bg-purple-100',
                                        default => 'text-gray-600 bg-gray-100'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs {{ $color }}">
                                    {{ str_replace('_',' ', $status) }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="py-3 px-4" x-data="{ open:false }">

                                <!-- CHECK DOKUMEN (ubah jadi tombol Detail) -->
<a href="#" 
   @click.prevent="open = true"
   class="bg-[#4361EE] text-white text-xs px-3 py-1.5 rounded-md hover:bg-[#3651d4] transition">
    Cek Dokumen
</a>

<!-- Popup Modal -->
<div 
    x-show="open"
    x-transition
    class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50"
>
    <!-- Modal Card -->
    <div 
        @click.away="open = false"
        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative"
    >
        <!-- Tombol Close -->
        <button 
            @click="open = false"
            class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-lg font-bold"
        >
            ✕
        </button>

        <!-- Judul -->
        <h2 class="text-lg font-semibold text-gray-800 mb-2 text-center">
            Cek Dokumen Usulan
        </h2>

        <!-- Deskripsi -->
        <p class="text-sm text-gray-500 mb-6 text-center">
            Pilih dokumen yang ingin kamu lihat:
        </p>

        <!-- Tombol Pilihan -->
        <div class="space-y-3">
            <button 
                class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 rounded-lg transition">
                Lihat Surat Usulan
            </button>

            <button 
                class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 rounded-lg transition">
                Lihat Keberjalanan
            </button>

            <button 
                class="w-full bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 rounded-lg transition">
                Lihat Laporan
            </button>
        </div>

    </div>
</div>

                                <!-- REVIEW -->
                                @if($u->statususulan_kegiatan === 'pending')
                                <button
                                    onclick="openReviewModal('{{ $u->id }}')"
                                    class="bg-[#FFA41B] hover:bg-[#ff9600] text-white px-3 py-1.5 rounded text-xs ml-3">
                                    Review
                                </button>
                                @endif

                                <!-- HAPUS -->
                                <form 
    action="{{ route('admin.usulankegiatan.destroy', $u->id) }}" 
    method="POST"
    class="inline-block ml-3"
    onsubmit="return confirm('Apakah yakin ingin menghapus?')"
>
    @csrf
    @method('DELETE')

    <button type="submit" class="inline-flex items-center">
        <img 
            src="{{ asset('images/delete.png') }}" 
            alt="Delete"
            class="w-5 h-5 hover:opacity-70 transition"
        >
    </button>
</form>


                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                Tidak ada data usulan kegiatan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Container Modal Review -->
        <div id="reviewModalContainer"></div>

        <script>
            async function openReviewModal(usulanId) {
                const container = document.getElementById('reviewModalContainer');
                container.innerHTML = `
                    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                        <div class="text-white animate-pulse text-lg">
                            Memuat form review...
                        </div>
                    </div>
                `;

                try {
                    const res = await fetch(`/superadmin/usulankegiatan/${usulanId}/review`);
                    if (!res.ok) throw new Error("Gagal memuat form review");
                    const html = await res.text();
                    container.innerHTML = html;

                } catch (e) {
                    container.innerHTML = `
                        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                            <div class="bg-red-600 p-4 rounded text-white shadow">
                                ${e.message}
                            </div>
                        </div>
                    `;
                }
            }
        </script>
    </div>

</x-app-layout>
