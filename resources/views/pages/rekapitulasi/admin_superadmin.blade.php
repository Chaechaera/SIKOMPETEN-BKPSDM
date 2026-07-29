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
        <form method="GET">
            <div class="flex flex-col md:flex-row gap-4 text-base font-normal">
                {{-- Search --}}
                <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                    <form method="GET">
                        <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                    </form>
                </div>

                {{-- Tahun Filter --}}
                <select name="tahun" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-56 px-3 py-3 text-abuabuGelap">
                    <option value="">Pilih Tahun</option>
                    @foreach($tahuns as $tahun)
                    @if(!empty($tahun))
                    <option class="text-black" value="{{ $tahun }}"
                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endif
                    @endforeach
                </select>

                {{-- Kategori Filter --}}
                <select name="kategori"
                    onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-56 px-3 py-3 text-abuabuGelap">
                    <option value="">Semua Kategori</option>
                    <option value="Sangat Baik" {{ request('kategori')=='Sangat Baik' ? 'selected' : '' }}>
                        🟢 Sangat Baik
                    </option>
                    <option value="Baik" {{ request('kategori')=='Baik' ? 'selected' : '' }}>
                        🔵 Baik
                    </option>
                    <option value="Cukup" {{ request('kategori')=='Cukup' ? 'selected' : '' }}>
                        🟡 Cukup
                    </option>
                    <option value="Kurang" {{ request('kategori')=='Kurang' ? 'selected' : '' }}>
                        🟠 Kurang
                    </option>
                    <option value="Sangat Kurang" {{ request('kategori')=='Sangat Kurang' ? 'selected' : '' }}>
                        🔴 Sangat Kurang
                    </option>
                </select>

                {{-- OPD Filter --}}
                <select name="opd"
                    onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-56 px-3 py-3 text-abuabuGelap">
                    <option value="">Pilih OPD</option>
                    @foreach($opds as $o)
                    <option value="{{$o->id}}" @selected(request('opd')==$o->id)>
                        {{$o->singkatan}}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>

        {{-- Grafik Trend Rekapitulasi Berdasarkan OPD --}}
        @if(!request('opd'))

        {{-- Belum memilih OPD --}}
        <div class="bg-white rounded-xl shadow mb-5 overflow-hidden text-gray-500">
            <p class="p-2 text-sm text-center">
                Pilih OPD terlebih dahulu untuk melihat grafik perkembangan kegiatan
            </p>
        </div>
        @elseif(count($chartData) > 0)

        {{-- Ada data trend --}}
        <div class="bg-white rounded-xl shadow mb-5 overflow-hidden">
            <div class="relative w-full h-72">
                <canvas id="trendChart" class="w-full max-w-full"></canvas>
            </div>
        </div>
        @else

        {{-- Tidak ada data trend --}}
        <div class="bg-white rounded-xl shadow mb-5 overflow-hidden text-gray-500">
            <p class="p-2 text-sm text-center">
                Belum terdapat grafik trend karena kegiatan pengembangan kompetensi pada OPD yang dipilih belum dibuat atau belum memiliki data yang dapat ditampilkan.
            </p>
        </div>
        @endif

        {{-- Tabel Rekapitulasi --}}
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm table-auto">
                <thead>
                    <tr class="bg-abuabuMuda font-semibold border-b text-center">
                        <th class="p-4">No</th>
                        <th class="p-4">Sub Unit Kerja OPD</th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                Jumlah Kegiatan PK
                                <x-izin-info-tooltip
                                    position="left"
                                    title="Jumlah Kegiatan PK"
                                    description="Jumlah seluruh kegiatan Pengembangan Kompetensi (PK) yang telah terlaksana pada masing-masing OPD dalam periode tahun anggaran yang dipilih." />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                0 - 10 JP
                                <x-izin-info-tooltip
                                    position="left"
                                    title="0 - 10 JP"
                                    description="Jumlah kegiatan PK yang menghasilkan capaian 0 sampai dengan 10 Jam Pelajaran (JP)." />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                11 - 19 JP
                                <x-izin-info-tooltip
                                    position="left"
                                    title="11 - 19 JP"
                                    description="Jumlah kegiatan PK yang menghasilkan capaian 11 sampai dengan 19 Jam Pelajaran (JP)." />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                &gt; 20 JP
                                <x-izin-info-tooltip
                                    position="left"
                                    title="> 20 JP"
                                    description="Jumlah kegiatan PK yang menghasilkan capaian lebih dari 20 Jam Pelajaran (JP)." />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                Total JP
                                <x-izin-info-tooltip
                                    position="right"
                                    title="Total JP"
                                    description="Total akumulasi Jam Pelajaran (JP) dari seluruh kegiatan PK yang telah dilaksanakan oleh masing-masing OPD." />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                % &gt; 20 JP
                                <x-izin-info-tooltip
                                    position="right"
                                    title="% > 20 JP"
                                    :description="'Persentase kegiatan PK yang memiliki capaian lebih dari 20 JP dibandingkan dengan seluruh kegiatan PK yang telah dilaksanakan oleh OPD.
                                        Rumus:
                                        (Jumlah kegiatan > 20 JP ÷ Jumlah seluruh kegiatan PK) × 100%.'" />
                            </div>
                        </th>
                        <th class="p-4 whitespace-nowrap">
                            <div class="flex justify-center items-center gap-1">
                                Kategori Kinerja PK
                                <x-izin-info-tooltip
                                    position="right"
                                    title="Kategori Kinerja PK ASN"
                                    :description="'Kategori yang menggambarkan tingkat kinerja pelaksanaan Pengembangan Kompetensi ASN berdasarkan indikator yang telah ditetapkan sehingga dapat digunakan sebagai bahan perbandingan antar OPD. Indikator yang digunakan meliputi:
                                        1. Jumlah kegiatan PK yang terlaksana (menunjukkan tingkat aktivitas OPD).
                                        2. Persentase kegiatan dengan capaian > 20 JP (menunjukkan kualitas atau intensitas kegiatan).'" />
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rekap as $index => $row)
                    @php
                    $hoverColor = match ($row['kategori_kinerja']) {
                    'Sangat Baik' => 'hover:bg-hijauBening/95',
                    'Baik' => 'hover:bg-biruCerah/95',
                    'Cukup' => 'hover:bg-kuningBening/95',
                    'Kurang' => 'hover:bg-orangeBening/95',
                    'Sangat Kurang' => 'hover:bg-merahBening/95',
                    };

                    $groupHover = match ($row['kategori_kinerja']) {
                    'Sangat Baik' => 'group-hover:bg-hijauBening/95',
                    'Baik' => 'group-hover:bg-biruCerah/95',
                    'Cukup' => 'group-hover:bg-kuningBening/95',
                    'Kurang' => 'group-hover:bg-orangeBening/95',
                    'Sangat Kurang' => 'group-hover:bg-merahBening/95',
                    };
                    @endphp

                    <tr class="group border-b text-center transition-colors {{ $hoverColor }} table-row">
                        <td class="p-4 border-r">{{ $index + 1 }}</td>
                        <td class="p-4 font-semibold text-left border-r">
                            {{ $row['nama'] }}
                        </td>
                        <td class="p-4 font-semibold border-r bg-abuabuKoin {{ $groupHover }}">
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
                        <td class="p-4 font-semibold border-r bg-abuabuKoin {{ $groupHover }}">
                            {{ $row['persen_20'] }}
                        </td>
                        <td class="p-4 font-semibold whitespace-nowrap bg-abuabuKoin {{ $groupHover }}">
                            @php
                            $badge = match ($row['kategori_kinerja']) {
                            'Sangat Baik' => ['bg-hijauBening border border-hijauTua text-hijauTua', '🟢'],
                            'Baik' => ['bg-biruCerah border border-biruMariana text-biruMariana', '🔵'],
                            'Cukup' => ['bg-kuningBening border border-orangeMuda text-orangeMuda', '🟡'],
                            'Kurang' => ['bg-orangeBening border border-orange text-orange', '🟠'],
                            'Sangat Kurang' => ['bg-merahBening border border-merahCabai text-merahCabai', '🔴'],
                            };
                            @endphp

                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badge[0] }}">
                                <span>{{ $badge[1] }}</span>
                                <span>{{ $row['kategori_kinerja'] }}</span>
                            </span>
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

            const data = @json($chartData);

            const ctx = document.getElementById('trendChart');

            if (ctx && data.length) {

                new Chart(ctx, {

                    type: 'line',

                    data: {

                        labels: data.map(e => e.tahun),

                        datasets: [

                            {

                                label: 'Jumlah Kegiatan',

                                data: data.map(e => e.jumlah)

                            },

                            {

                                label: 'Total JP',

                                data: data.map(e => e.jp)

                            },

                            {

                                label: 'Kategori',

                                data: data.map(e => e.kategori)

                            }

                        ]

                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        interaction: {
                            mode: 'index',
                            intersect: false
                        },

                        plugins: {

                            tooltip: {

                                callbacks: {

                                    label: function(context) {

                                        if (context.dataset.label == "Kategori") {

                                            const map = {
                                                1: "Sangat Kurang",
                                                2: "Kurang",
                                                3: "Cukup",
                                                4: "Baik",
                                                5: "Sangat Baik"
                                            };

                                            return "Kategori : " + map[context.raw];

                                        }

                                        return context.dataset.label + ": " + context.raw;

                                    }

                                }

                            }

                        }

                    }

                });

            }
        </script>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>