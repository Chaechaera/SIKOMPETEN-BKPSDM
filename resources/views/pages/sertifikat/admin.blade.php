<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Card Informasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">
                SERTIFIKAT KEGIATAN PENGEMBANGAN KOMPETENSI ASN
            </h1>
            <p class="text-sm text-abuabuCerah max-w-4xl">
                Berikut adalah daftar sertifikat kegiatan pengembangan kompetensi ASN milik peserta yang dimuat dalam bentuk file ZIP.
            </p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input
                        type="text"
                        id="searchInput"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search ....."
                        class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap">
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
                    <option value="">Tahun Anggaran</option>

                    @foreach ($tahuns as $tahun)
                    <option
                        value="{{ $tahun }}"
                        class="text-black"
                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
            </form>

        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm table-auto">

                <thead>
                    <tr class="bg-abuabuMuda font-semibold border-b text-center">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4">Nama Kegiatan</th>
                        <th class="py-3 px-4">Tanggal Pelaksanaan</th>
                        <th class="py-3 px-4">Jumlah Peserta</th>
                        <th class="py-3 px-4">Sertifikat Peserta (ZIP)</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $index => $u)
                    <tr class="border-b text-center text-sm font-normal hover:bg-abuabuCerah/30">

                        {{-- No --}}
                        <td class="py-3 px-4">
                            {{ $usulankegiatans->firstItem()
                                            ? $usulankegiatans->firstItem() + $index
                                            : $index + 1 }}
                        </td>

                        {{-- Nama --}}
                        <td class="py-3 px-4 text-left font-semibold">
                            {{ $u->inputusulankegiatans->nama_kegiatan }}
                        </td>

                        {{-- Tanggal --}}
                        <td class="py-3 px-4">
                            {{
                                            $u->inputlaporankegiatans?->laporankegiatans?->tanggalmulai_kegiatan &&
                                            $u->inputlaporankegiatans?->laporankegiatans?->tanggalselesai_kegiatan
                                                ? \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalmulai_kegiatan)->format('d F Y')
                                                  . ' - ' .
                                                  \Carbon\Carbon::parse($u->inputlaporankegiatans->laporankegiatans->tanggalselesai_kegiatan)->format('d F Y')
                                                : '-'
                                        }}
                        </td>

                        {{-- Jumlah Peserta --}}
                        <td class="py-3 px-4">
                            {{ $u->inputlaporankegiatans?->laporankegiatans?->detaillaporankegiatans?->pesertakegiatans?->count() ?? 0 }}
                            Peserta
                        </td>

                        <!-- Sertifikat -->
                        <td class="py-3 px-4">
                            @php
                            $laporan = $u->inputlaporankegiatans?->laporankegiatans;
                            $sertifikat = $laporan?->sertifikats;

                            $laporanId = $laporan?->id;
                            $sertifikatId = $sertifikat?->id;

                            $alreadyFinalized =
                            $sertifikat &&
                            $sertifikat->pesertakegiatans()->exists() &&
                            $sertifikat->pesertakegiatans()
                            ->whereNotNull('filesertifikatgenerate_path')
                            ->count() ==
                            $sertifikat->pesertakegiatans()->count();
                            @endphp

                            @if ($sertifikatId)

                            <div class="flex flex-col gap-2">

                                @if (!$alreadyFinalized)

                                {{-- FINALISASI --}}
                                <form
                                    action="{{ route('admin.sertifikat.finalisasi', $sertifikatId) }}"
                                    method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs py-2">

                                        Finalisasi Sertifikat

                                    </button>

                                </form>

                                @else

                                {{-- Status --}}
                                <div
                                    class="w-full rounded-lg bg-gray-200 text-gray-600 text-xs py-2 text-center cursor-not-allowed">

                                    Sudah Difinalisasi

                                </div>

                                @endif

                                {{-- DOWNLOAD ZIP --}}
                                <a
                                    href="{{ route('admin.sertifikat.download', $laporanId) }}"
                                    class="block rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs py-2 text-center">

                                    Download ZIP

                                </a>

                            </div>

                            @else

                            <span
                                class="text-gray-500 py-2">

                                Proses Belum Selesai Sertifikat Belum Tergenerate

                            </span>

                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="hidden text-center py-12 text-gray-500">
        Tidak ada data yang sesuai dengan pencarian
    </div>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');

            if (!searchInput) return;

            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }
            });
        });
    </script>
</x-app-layout>