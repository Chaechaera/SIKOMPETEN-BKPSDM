<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR PENGAJUAN USULAN KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar usulan kegiatan yang diajukan oleh OPD yang saat ini perlu untuk diproses dan diverifikasi.
            </p>
        </div>

        {{-- Search and Filtering --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                </form>
            </div>

            {{-- Status Filter --}}
            <form method="GET">
                <select name="statususulan_kegiatan" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option class="text-black" value="">Status Usulan</option>
                    <option class="text-black" value="pending" {{ request('statususulan_kegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option class="text-black" value="accepted" {{ request('statususulan_kegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                    <option class="text-black" value="rejected" {{ request('statususulan_kegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">Nomor Surat</th>
                        <th class="py-3 px-4">OPD</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Status Usulan</th>
                        <th class="py-3 px-4">Update Progress</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Surat -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{ $u->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}
                        </td>

                        <!-- OPD -->
                        <td class="py-3 px-4 font-semibold">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Update Progress -->
                        <td class="py-3 px-4" x-data="{ openProgress: false }">
                            <div class="flex justify-center gap-2">
                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if($u->boleh_cetak)
                                <form method="POST"
                                    action="{{ route('superadmin.balasanusulankegiatan.cetak', $u->id) }}"
                                    onsubmit="return confirm('Yakin cetak?')">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-md bg-biruBlue text-white hover:bg-biruBlue/80 transition">
                                        Cetak
                                    </button>
                                </form>
                                @else
                                <button
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->boleh_kirim)
                                <a href="{{ route('superadmin.balasanusulankegiatan.kirim', $u->id) }}"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-unguSedang text-white hover:bg-unguSedang/80 transition">
                                    Kirim
                                </a>
                                @else
                                <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- ===================== REVIEW DOKUMEN ===================== --}}
                                @if($u->isReviewUsulan())
                                <button onclick="openReviewModal('{{ $u->id }}', 'usulankegiatans')"
                                    class="px-3 py-1.5 text-xs font-semibold rounded-md bg-hijauGreen text-white hover:bg-hijauGreen/80 transition">
                                    Review
                                </button>
                                @else
                                <button class="px-3 py-1.5 text-xs font-semibold rounded-md bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">Review</button>
                                @endif
                            </div>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="py-3 px-4" x-data="{ openDokumen: false }">
                            <div class="flex justify-center gap-4">

                                {{-- ===================== LIHAT DOKUMEN ===================== --}}
                                <a @click="openDokumen = true" class="cursor-pointer">
                                    <i class="inline" data-lucide="file-text"></i>
                                </a>

                                <!-- MODAL DETAIL -->
                                <div x-show="openDokumen" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                    <div @click.outside="openDokumen = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

            <!-- Tabel Daftar Usulan -->
            <div class="bg-white rounded-xl shadow p-6">
                {{-- Filters --}}
                <form method="GET" class="flex flex-col md:flex-row gap-4 mb-4 items-end">
                    {{-- Search --}}
                    <div class="flex-1 relative">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari nama kegiatan, nomor surat, atau OPD..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg" />
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                        </svg>
                    </div>

                    {{-- Tanggal Pengajuan --}}
                    <div class="w-full md:w-52">
                        <label class="block text-sm text-gray-500 mb-1" for="tanggal_pengajuan">Tanggal Pengajuan</label>
                        <input type="date" id="tanggal_pengajuan" name="tanggal_pengajuan"
                            value="{{ request('tanggal_pengajuan') }}"
                            class="w-full border rounded-lg px-3 py-2" />
                    </div>

                    {{-- Status Filter --}}
                    <div class="w-full md:w-52">
                        <label class="block text-sm text-gray-500 mb-1" for="statususulan_kegiatan">Status Usulan</label>
                        <select id="statususulan_kegiatan" name="statususulan_kegiatan" onchange="this.form.submit()"
                            class="w-full border rounded-lg px-3 py-2">
                            <option value="">Semua Status Usulan</option>
                            <option value="pending" {{ request('statususulan_kegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('statususulan_kegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('statususulan_kegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="flex gap-3 md:items-center">
                        <button type="submit"
                            class="w-full md:w-auto px-4 py-2 rounded-lg bg-[#5B2C89] text-white font-medium hover:bg-[#9868c7] transition">
                            Terapkan
                        </button>
                        <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                            class="w-full md:w-auto px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition text-center">
                            Reset
                        </a>
                    </div>
                </form>
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-32">Nomor Surat</th>
                                <th class="py-3 px-4 w-24">OPD</th>
                                <th class="py-3 px-4 w-60">Nama Kegiatan</th>
                                <th class="py-3 px-4 w-48">Tanggal Pelaksanaan</th>
                                <th class="py-3 px-4 w-28">Status Usulan</th>
                                <th class="py-3 px-4 w-48">Update Progress</th>
                                <th class="py-3 px-4 w-20">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($usulankegiatans as $index => $u)
                            <tr class="border-b hover:bg-gray-50">

                                <!-- Nomor Surat -->
                                <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                    {{ $u->inputusulankegiatans->kirimusulankegiatans->identitassurats->nomor_surat ?? '-' }}
                                </td>

                                <!-- OPD -->
                                <td class="py-3 px-4 text-center font-medium text-gray-800">{{ $u->subunitkerjas->singkatan ?? '-' }}</td>

                                <!-- Nama Kegiatan -->
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                                <!-- Tanggal Pelaksanaan Kegiatan -->
                                <td class="py-3 px-4 text-gray-600 text-center whitespace-nowrap">
                                    {{$u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                                </td>

                                <!-- Status Usulan Kegiatan -->
                                <td class="py-3 px-4 text-center">
                                    <span class="{{ $u->status_ui_class }}">
                                        {{ str_replace('_', ' ', $u->status_ui) }}
                                    </span>
                                </td>

                                <!-- Update Progress -->
                                <td class="py-3 px-4 text-center" x-data="{ openProgress: false }">
                                    <div class="flex justify-center gap-2">
                                        {{-- ===================== CETAK DOKUMEN ===================== --}}
                                        @if($u->boleh_cetak)
                                        <form method="POST"
                                            action="{{ route('superadmin.balasanusulankegiatan.cetak', $u->id) }}"
                                            onsubmit="return confirm('Yakin cetak?')">
                                            @csrf
                                            <button type="submit"
                                                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#4361EE] text-white hover:bg-[#3651d4] transition">
                                                Cetak
                                            </button>
                                        </form>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                                            Cetak
                                        </button>
                                        @endif

                                        {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                        @if($u->boleh_kirim)
                                        <a href="{{ route('superadmin.balasanusulankegiatan.kirim', $u->id) }}"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                                            Kirim
                                        </a>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Kirim</button>
                                        @endif

                                        {{-- ===================== REVIEW DOKUMEN ===================== --}}
                                        @if($u->isReviewUsulan())
                                        <button onclick="openReviewModal('{{ $u->id }}', 'usulankegiatans')"
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-[#216e7f] text-white hover:bg-[#398c9f] transition">
                                            Review
                                        </button>

                                        <h2 class="text-2xl font-semibold bg-primary-gradient bg-clip-text text-transparent leading-tight">
                                            DAFTAR DOKUMEN
                                        </h2>

                                        <p class="text-sm font-normal text-abuabuCerah mb-6">
                                            Pilih dokumen terkait usulan kegiatan yang ingin dilihat.
                                        </p>

                                        <div class="flex flex-col space-y-3 font-semibold text-sm">
                                            {{-- Lihat Surat dan KAK Usulan --}}
                                            <a href="{{ route('superadmin.usulankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguTransparan text-unguTua hover:bg-unguTua/60 transition">
                                                Lihat Surat dan KAK Usulan
                                            </a>

                                            {{-- Lihat Surat Balasan Usulan --}}
                                            <a href="{{ route('superadmin.usulankegiatan.downloadBalasan', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-coklatMuda/25 text-coklatGelap hover:bg-coklatGelap/60 transition">
                                                Lihat Surat Balasan Usulan
                                            </a>

                                            {{-- Lihat Pelaksanaan Kegiatan --}}
                                            <a href="{{ route('superadmin.pelaksanaankegiatan.show', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahMaroon/60 transition">
                                                Lihat Pelaksanaan Kegiatan
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- TOMBOL HAPUS --}}
                                <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin hapus usulan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-merahCabai">
                                        <i alt="Hapus" class="inline" data-lucide="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-abuabuMuda">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $usulankegiatans->appends(request()->query())->links() }}
        </div>

        {{-- Empty State --}}
        <div id="emptyState" class="hidden text-center py-12 text-abuabuSedang">
            Tidak ada data yang sesuai dengan pencarian
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