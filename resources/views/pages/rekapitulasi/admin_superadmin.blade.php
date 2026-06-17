<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Card Informasi Rekapitulasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">REKAPITULASI KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
            <p class="text-sm text-abuabuCerah max-w-4xl">
                Berikut adalah rekap kegiatan pengembangan kompetensi ASN yang telah terlaksana di lingkungan Pemerintah Kota Surakarta
            </p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">
            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                </form>
            </div>

            {{-- Tahun Filter --}}
            <form method="GET">
                <select name="tahun" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option value="">Tahun Anggaran</option>
                    @foreach ($tahuns as $tahun)
                    <option class="text-black" value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Tabel Rekapitulasi --}}
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm table-auto">
                <thead>
                    <tr class="bg-abuabuMuda font-semibold border-b text-center">
                        <th class="p-4">No</th>
                        <th class="p-4">Sub Unit Kerja OPD</th>
                        <th class="p-4">Jumlah Kegiatan PK</th>
                        <th class="p-4">0 - 10 JP</th>
                        <th class="p-4">11 - 19 JP</th>
                        <th class="p-4">&gt; 20 JP</th>
                        <th class="p-4">Total JP</th>
                        <th class="p-4">% &gt; 20 JP</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rekap as $index => $row)
                    <tr class="border-b text-center hover:bg-abuabuCerah/30 table-row">
                        <td class="p-4 border-r">{{ $index + 1 }}</td>
                        <td class="p-4 border-r font-semibold text-left">
                            {{ $row['nama'] }}
                        </td>
                        <td class="p-4 font-semibold border-r">
                            {{ $row['jumlah_kegiatan'] }}
                        </td>
                        <td class="p-4 border-r">
                            {{ $row['jp0_10'] }}
                        </td>
                        <td class="p-4 border-r">
                            {{ $row['jp11_19'] }}
                        </td>
                        <td class="p-4 border-r">
                            {{ $row['jp20'] }}
                        </td>
                        <td class="p-4 font-semibold border-r">
                            {{ $row['total'] }}
                        </td>
                        <td class="p-4 font-semibold">
                            {{ $row['persen_20'] }}
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
        <div class="mt-4">
            {{ $rekap->appends(request()->query())->links() }}
        </div>

        <div id="emptyState" class="hidden text-center py-12 text-gray-500">
            Tidak ada data yang sesuai dengan pencarian
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');

                if (!searchInput) return;

                searchInput.addEventListener('input', function() {
                    if (this.value.trim() === '') {
                        // 🔥 hapus parameter search dari URL
                        const url = new URL(window.location.href);
                        url.searchParams.delete('search');

                        // optional: hapus page juga biar balik ke halaman 1
                        url.searchParams.delete('page');

                        window.location.href = url.toString();
                    }
                });
            });
        </script>
    </div>
</x-app-layout>