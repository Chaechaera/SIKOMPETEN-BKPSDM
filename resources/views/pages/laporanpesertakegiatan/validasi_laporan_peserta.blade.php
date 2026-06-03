<x-app-layout>
    <div x-data="modalHandler()" class="space-y-4 px-6 py-4">

        {{-- Card Informasi Rekapitulasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">VALIDASI LAPORAN PESERTA KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Lakukan validasi laporan peserta kegiatan Pengembangan Kompetensi yang berstatus Pending agar sertifikat dapat diunduh. 
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

            {{-- Sub Unit Kerja Filter --}}
            <form method="GET">
                <select name="statuslaporan_pesertakegiatan" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option class="text-black" value="">Status Laporan Peserta</option>
                    <option class="text-black" value="pending" {{ request('statuslaporan_pesertakegiatan') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option class="text-black" value="accepted" {{ request('statuslaporan_pesertakegiatan') == 'accepted' ? 'selected' : '' }}>Disetujui</option>
                    <option class="text-black" value="rejected" {{ request('statuslaporan_pesertakegiatan') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
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

        {{-- Table --}}
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm table-auto">
                    <thead>
                        <tr class="bg-abuabuMuda font-semibold border-b text-center">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Peserta</th>
                            <th class="py-3 px-4">Kegiatan</th>
                            <th class="py-3 px-4">Tanggal Upload</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">File</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($laporans as $index => $laporan)
                        <tr class="border-b text-center hover:bg-abuabuCerah/30 table-row">

                            {{-- Nomor --}}
                            <td class="py-3 px-4">
                                {{ $laporans->firstItem() 
                                            ? $laporans->firstItem() + $index 
                                            : $index + 1 }}
                            </td>

                            {{-- Nama Peserta --}}
                            <td class="py-3 px-4 text-left font-semibold">
                                {{ $laporan->pesertakegiatans->nama_peserta ?? '-' }}
                            </td>

                            {{-- Nama Kegiatan --}}
                            <td class="py-3 px-4 text-left font-semibold">
                                {{ $laporan->pesertakegiatans->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="py-3 px-4 whitespace-nowrap">
                                {{ optional($laporan->created_at)->format('d M Y') }}
                            </td>

                            {{-- Status --}}
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($laporan->statuslaporan_pesertakegiatan === 'pending')
                                <span class="px-3 py-1 text-xs rounded-full bg-unguMuda text-unguSedang font-medium">
                                    Pending
                                </span>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'revisi')
                                <span class="px-3 py-1 text-xs rounded-full bg-orangeBening text-orange font-medium">
                                    Revisi
                                </span>
                                @elseif($laporan->statuslaporan_pesertakegiatan === 'approved')
                                <span class="px-3 py-1 text-xs rounded-full bg-hijauBening text-hijauTua font-medium">
                                    Approved
                                </span>
                                @else
                                <span class="px-3 py-1 text-xs rounded-full bg-merahBening text-merahCabai font-medium">
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

                                    @if($laporan->statuslaporan_pesertakegiatan === 'pending' || $laporan->statuslaporan_pesertakegiatan === 'revisi')

                                    {{-- Approve --}}
                                    <form method="POST"
                                        action="{{ route('superadmin.laporan.approve', $laporan->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <!--<button type="submit" @click="openModal"
                                            class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauTua text-white hover:bg-hijauTua/60">
                                            Approve
                                        </button>-->
                                        <button 
    type="button"
    @click="openModal('approve', {{ $laporan->id }})"
    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauTua text-white hover:bg-hijauTua/60">
                                            Approve
</button>

                                    </form>

                                    {{-- Reject --}}
                                    <form method="POST"
                                        action="{{ route('superadmin.laporan.reject', $laporan->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <!--<button type="submit" @click="openModal"
                                            class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahMaroon text-white hover:bg-merahMaroon/60">
                                            Reject
                                        </button>-->
                                        <button 
    type="button"
    @click="openModal('reject', {{ $laporan->id }})"
    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahMaroon text-white hover:bg-merahMaroon/60">
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
                        <td colspan="8" class="text-center py-6 text-abuabuMuda">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                    <div 
    x-show="show"
    x-transition
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    style="display:none;"
>
    <div class="bg-white rounded-xl w-[400px] p-6">

        <h2 class="text-lg font-semibold mb-3 text-center">
            <span x-text="type === 'approve' ? 'Approve' : 'Reject'"></span> Laporan
        </h2>

        <textarea 
            x-model="catatan"
            placeholder="Tulis catatan..."
            class="w-full border rounded p-2 text-sm mb-4"
            rows="4"
        ></textarea>

        <div class="flex justify-end gap-2">
            <button @click="closeModal()" class="px-3 py-2 text-sm bg-gray-300 rounded">
                Batal
            </button>

            <form :action="formAction" method="POST">
                @csrf
                @method('PATCH')

                <!-- 🔥 FIX NAMA -->
                <input type="hidden" name="catatanlaporan_pesertakegiatan" :value="catatan">

                <button type="submit"
                    :class="type === 'approve' ? 'bg-green-600' : 'bg-red-600'"
                    class="px-4 py-2 text-white rounded text-sm">
                    Submit
                </button>
            </form>
        </div>

    </div>
</div>
                </table>
            </div>

        {{-- Footer Pagination --}}
        <div class="mt-4">
            {{ $laporans->links() }}
        </div>

        <div id="emptyState" class="hidden text-center py-12 text-gray-500">
            Tidak ada data yang sesuai dengan pencarian
        </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ================================
                // 🔍 SEARCH RESET HANDLER
                // ================================
                const searchInput = document.getElementById('searchInput');

                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        if (this.value.trim() === '') {
                            const url = new URL(window.location.href);
                            url.searchParams.delete('search');
                            url.searchParams.delete('page'); // reset pagination
                            window.location.href = url.toString();
                        }
                    });
                }

                // ================================
                // 🏢 SUBUNIT DROPDOWN HANDLER
                // ================================
                const select = document.querySelector('select[name="subunitkerja"]');

                if (select) {

                    const updateSelectedText = () => {
                        const selectedOption = select.options[select.selectedIndex];

                        if (selectedOption && selectedOption.dataset.singkatan) {
                            selectedOption.text = selectedOption.dataset.singkatan;
                        }
                    };

                    // saat pertama load
                    updateSelectedText();

                    // saat user pilih
                    select.addEventListener('change', function() {
                        updateSelectedText();
                        this.form.submit();
                    });
                }

            });

function modalHandler() {
    return {
        show: false,
        type: '',
        id: null,
        catatan: '',
        formAction: '',

        openModal(type, id) {
            this.type = type;
            this.id = id;
            this.catatan = '';

            if (type === 'approve') {
                this.formAction = `/superadmin/laporanpeserta/${id}/approve`;
            } else {
                this.formAction = `/superadmin/laporanpeserta/${id}/reject`;
            }

            this.show = true;
        },

        closeModal() {
            this.show = false;
        }
    }
}
        </script>
    </div>
</x-app-layout>