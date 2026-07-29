<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        <!-- Card Judul -->
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">DAFTAR LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Daftar kegiatan yang saat ini telah proses pelaksanaan dan perlu menyertakan laporan hasil kegiatan pelaksanaan.
            </p>
        </div>

        <!-- Cards -->
        <section class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 sm:gap-4 mb-8">
    @foreach($counts as $status => $value)
        @php
            $bg = $colors[$status] ?? 'bg-gray-100';

            $url = $status === 'archive'
                ? route('admin.laporankegiatan.arsip')
                : request()->fullUrlWithQuery(['status' => $status]);
        @endphp

        <a href="{{ $url }}"
            class="block p-5 sm:p-6 rounded-xl {{ $bg }} shadow-sm hover:scale-[1.02] transition">
            <h2 class="text-gray-700 text-sm font-medium">
                {{ str_replace('_', ' ', ucfirst($status)) }}
            </h2>
            <p class="text-2xl font-bold text-[#2B3674] mt-2">
                {{ $value }}
            </p>
        </a>
    @endforeach
</section>

        {{-- Search and Filtering --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama kegiatan, tanggal pelaksanaan..."
                        class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-abuabuGelap">
                        <i data-lucide="search"></i>
                    </span>
                </form>
            </div>

            {{-- Tahun --}}
            <form method="GET">
                <select
                    name="tahun"
                    onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option value="">Semua Tahun</option>
                    @for ($year = 2021; $year <= 2026; $year++)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                        {{ $year }}
                        </option>
                        @endfor
                </select>
            </form>

            {{-- Status --}}
            <form method="GET">
                <select name="status" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">

                    <option value="">Semua Status</option>

                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        pending
                    </option>

                    <option value="need_review" {{ request('status') == 'need_review' ? 'selected' : '' }}>
                        need review
                    </option>

                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                        draft
                    </option>

                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>
                        accepted
                    </option>

                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                        rejected
                    </option>

                    <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>
                        finish
                    </option>

                </select>
            </form>

            {{-- Sort --}}
            <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort') == 'asc' ? 'desc' : 'asc']) }}"
                class="bg-white rounded-xl border border-abuabuMuda/60 shadow px-4 py-3 flex items-center justify-center">
                @if(request('sort','desc') == 'desc')
                <i data-lucide="list-sort-descending" class="w-5 h-5 text-abuabuSedang"></i>
                @else
                <i data-lucide="list-sort-ascending" class="w-5 h-5 text-abuabuSedang"></i>
                @endif
            </a>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm font-semibold table-auto">
                <thead>
                    <tr class="bg-abuabuMuda border-b text-center">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Status Laporan</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        <!-- Nomor Otomatis -->
                        <td class="py-3 px-4">{{ $usulankegiatans->firstItem() ? $usulankegiatans->firstItem() + $index : $index + 1 }}</td>

                        <!-- Nama Kegiatan -->
                        <td class="py-3 px-4 text-left font-semibold">
                            <button
                                type="button"
                                @click="$dispatch('show-catatan-' + {{ $index }})"
                                class="hover:underline text-left">
                                {{ $u->inputusulankegiatans->nama_kegiatan }}
                            </button>
                        </td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="py-3 px-4 whitespace-nowrap">
                            {{ $u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan && $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
                                        ? \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalmulai_kegiatan)->format('d/m/Y') . ' - ' .
                                        \Carbon\Carbon::parse(optional($u->inputlaporankegiatans?->laporankegiatans)->tanggalselesai_kegiatan)->format('d/m/Y') : '-'}}
                        </td>

                        <!-- Status Laporan Kegiatan -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <span class="{{ $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui_class }}">
                                {{ str_replace('_', ' ', $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui) }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="py-3 px-4 text-center"
                            x-data="{ openDokumen: false }">
                            <div class="flex items-center justify-center gap-2">
                                @php
                                $laporan = $u->inputlaporankegiatans?->laporankegiatans;
                                @endphp

                                {{-- ===================== CETAK DOKUMEN ===================== --}}
                                @if (
                                $laporan &&
                                in_array($laporan->status_laporan_ui, ['draft', 'rejected']) &&
                                is_null($laporan->cetakusulankegiatans)
                                )
                                <a href="{{ route('admin.laporankegiatan.cetak', $u->id) }}"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-[#4361EE] text-white hover:bg-[#3651d4] transition text-center block">
                                    Cetak
                                </a>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                                    Cetak
                                </button>
                                @endif

                                {{-- ===================== KIRIM DOKUMEN ===================== --}}
                                @if($u->isPendingLaporan())
                                <a href="{{ route('admin.laporankegiatan.kirim.form', $u->id) }}"
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-[#5B2C89] text-white hover:bg-[#9868c7] transition">
                                    Kirim
                                </a>
                                @else
                                <button class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">Kirim</button>
                                @endif

                                {{-- UPDATE --}}
                                @if($u->status_ui === 'in_progress')
                                <a href="{{ route('admin.laporankegiatan.create', $u->id) }}"
                                    class="flex items-center justify-center px-4 py-2 rounded-lg bg-[#e0f2fe] text-[#0369a1] font-medium hover:brightness-95 transition">
                                    Update
                                </a>
                                @else
                                <button
                                    class="w-20 px-3 py-2 text-xs font-medium rounded-md bg-[#dcddde] text-gray-600 italic cursor-not-allowed">
                                    Update
                                </button>
                                @endif

                                {{-- Open Dokumen --}}
                                <button
                                    type="button"
                                    @click="openDokumen = true"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-biruCerah/20 text-biruNavy/75 hover:bg-biruCerah/50 transition"
                                    title="Open Dokumen">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </button>

                                <!-- MODAL DETAIL -->
                                <div x-show="openDokumen" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">
                                    <div @click.outside="openDokumen = false" x-transition.scale class="relative bg-white w-[420px] max-w-full rounded-2xl shadow-2xl p-6 text-center border border-abuabuMuda/60">

                                        {{-- Button Close --}}
                                        <button @click="openDokumen = false"
                                            class="absolute top-3 right-3">
                                            <i data-lucide="x"></i>
                                        </button>

                                        <h2 class="text-2xl font-semibold bg-primary-gradient bg-clip-text text-transparent leading-tight">
                                            DAFTAR DOKUMEN
                                        </h2>

                                        <p class="text-sm font-normal text-abuabuCerah mb-6">
                                            Pilih dokumen terkait usulan kegiatan yang ingin dilihat.
                                        </p>

                                        <div class="flex flex-col space-y-3 font-semibold text-sm">
                                            {{-- Lihat Surat dan Laporan Kegiatan --}}
                                            <a href="{{ route('admin.laporankegiatan.download', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-hijauTransparan text-hijauTua hover:bg-hijauTua/60 transition">
                                                Lihat Surat dan Laporan Hasil
                                            </a>

                                            {{-- Lihat Surat Balasan Laporan Kegiatan --}}
                                            @if(
    $u->inputlaporankegiatans?->laporankegiatans?->sudah_cetak_balasan
    ||
    $u->inputlaporankegiatans?->laporankegiatans?->sudah_kirim_balasan
)
                                            <a href="{{ route('admin.balasanlaporankegiatan.download', optional($u->inputlaporankegiatans?->laporankegiatans)->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-unguBening text-unguSedang hover:bg-unguSedang/60 transition">
                                                Lihat Surat Balasan Laporan
                                            </a>
                                            @else

<button
    disabled
    class="block w-full px-4 py-3 rounded-lg bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">

    Lihat Surat Balasan Laporan

</button>

@endif

                                            {{-- Lihat Pelaksanaan Kegiatan --}}
                                            @if($u->inputusulankegiatans?->pelaksanaankegiatans)
                                            <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                                target="_blank"
                                                class="block px-4 py-3 rounded-lg bg-merahBata/25 text-merahMaroon hover:bg-merahMaroon/60 transition">
                                                Lihat Pelaksanaan Kegiatan
                                            </a>
                                            @else
                                            <button
                                                disabled
                                                class="block w-full px-4 py-3 rounded-lg bg-abuabuMuda text-abuabuSedang italic cursor-not-allowed">
                                                Lihat Pelaksanaan Kegiatan
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Laporan --}}
                                @if($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition"
                                    title="Edit Dokumen">
                                    <i data-lucide="square-pen" class="w-4 h-4"></i>
                                </a>
                                @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed"
                                    title="Edit Dokumen">
                                    <i data-lucide="square-pen" class="w-4 h-4"></i>
                                </span>
                                @endif

                                {{-- Arsipkan --}}
                                @if(
                                $u->inputlaporankegiatans?->laporankegiatans?->status_laporan_ui === 'finish'
                                && !$u->inputlaporankegiatans?->laporankegiatans?->is_archived
                                )
                                <form
                                    action="{{ route('admin.laporankegiatan.archive', $u->inputlaporankegiatans->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin arsipkan laporan ini?')">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg bg-purple-100 text-purple-700 hover:bg-purple-200 transition"
                                        title="Arsipkan">
                                        <i data-lucide="archive" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 cursor-not-allowed"
                                    title="Arsipkan">
                                    <i data-lucide="archive" class="w-4 h-4"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- ================= CATATAN REVIEW ================= --}}
                    @php
                    $verif = $u->inputlaporankegiatans?->laporankegiatans?->verifikasilaporankegiatanterakhir;
                    $catatan = $verif?->catatan_verifikasilaporankegiatan;
                    @endphp

                    @if(!empty($catatan))

                    <tr
                        x-data="{
        key: 'catatan-{{ $u->id }}',
        showCatatan: true,

        init() {
            this.showCatatan = localStorage.getItem(this.key) !== 'closed';

            window.addEventListener('show-catatan-{{ $index }}', () => {
                this.showCatatan = true;
                localStorage.removeItem(this.key);
            });
        },

        closeCatatan() {
            this.showCatatan = false;
            localStorage.setItem(this.key,'closed');
        }
    }"

                        x-init="init()"

                        x-show="showCatatan"
                        x-transition>
                        <td colspan="6" class="bg-blue-50 px-6 py-3 border-b">

                            <div class="flex justify-between items-start bg-blue-100 border-l-4 border-blue-500 rounded-lg p-4">

                                <div>

                                    <div class="font-semibold text-blue-800">
                                        📢 Catatan Review Laporan Kegiatan
                                    </div>

                                    <div class="mt-1 text-gray-700 text-sm">
                                        {{ $verif->status_verifikasilaporankegiatan }}
                                    </div>

                                    <div class="mt-1 text-gray-700 text-sm">
                                        {{ $catatan }}
                                    </div>

                                    <div class="mt-2 text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($verif->tanggalverifikasi_inputlaporankegiatan)->format('d/m/Y') }}
                                    </div>

                                </div>

                                <button
                                    type="button"
                                    @click="closeCatatan()"
                                    class="ml-4 text-gray-500 hover:text-red-600 font-bold text-lg">
                                    ✕
                                </button>

                            </div>

                        </td>
                    </tr>

                    @endif
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">
                            Tidak ada data laporan kegiatan.
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


</x-app-layout>