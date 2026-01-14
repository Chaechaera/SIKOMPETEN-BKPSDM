<x-app-layout>
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}} 
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main 
        class="flex-1 p-6 space-y-6 transition-all duration-300"
        :class="sidebarOpen ? 'ml-64' : 'ml-0'"
    >

        {{-- Header --}}
        <div class="flex items-start gap-3">
            <img src="{{ asset('images/rekap.png') }}" alt="Rekap" class="h-8 w-8 mt-1">
            <div>
                <h1 class="text-2xl font-semibold text-[#2B3674]">
                    REFERENSI IZIN PENGEMBANGAN KOMPETENSI
                    <span id="year-title">2025</span>
                </h1>
                <p class="text-sm text-gray-500 max-w-2xl">
                    Daftar Referensi Izin Pengembangan Kompetensi ASN
                </p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="bg-white border rounded-xl shadow">
            <div class="p-6">
                <div class="flex items-center justify-between gap-4">

                    {{-- Search --}}
                    <div class="relative w-72">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search..."
                            class="w-full pl-10 pr-4 py-2 border rounded-md text-sm"
                        />
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M16 10.5A5.5 5.5 0 115.5 10.5a5.5 5.5 0 0111 0z" />
                        </svg>
                    </div>

                </div>
            </div>
        </div>

        {{-- Table --}}
<div class="bg-white rounded-xl shadow p-4 sm:p-6">

    {{-- Title --}}
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900">
            Daftar Penanggung Jawab
        </h3>
        <p class="text-sm text-gray-500">
            Klik <span class="font-medium text-gray-700">"Lihat Detail"</span> untuk mengatur KOP, TTD, dan Stempel
        </p>
    </div>

    {{-- Table --}}
    <div class="border rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-gray-600">
                        <th class="py-3 px-4 text-left font-semibold w-16">NO</th>
                        <th class="py-3 px-4 text-left font-semibold">Nama Penanggung Jawab</th>
                        <th class="py-3 px-4 text-left font-semibold">Asal</th>
                       <th class="py-3 px-4 text-center font-semibold w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $data = [
                            ['Dr. Budi Santoso, M.Si', 'BKPSDM Provinsi Kalbar'],
                            ['Ir. Siti Rahmawati, M.T', 'Dinas Pendidikan'],
                            ['Drs. Ahmad Hidayat, M.M', 'Dinas Kesehatan'],
                            ['Hj. Nurlaila, S.Sos, MAP', 'Dinas Sosial'],
                            ['Drs. Sukarno, M.Si', 'BAPPEDA'],
                            ['Ir. Wawan Setiawan, M.T', 'Dinas PUPR'],
                        ];
                    @endphp

                    @foreach ($data as $index => $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>

                            <td class="py-3 px-4 font-medium text-gray-800">
                                {{ $row[0] }}
                            </td>

                            <td class="py-3 px-4 text-gray-600">
                                {{ $row[1] }}
                            </td>

                            <td class="py-3 px-4 text-center">
    <a href="{{ route('admin.pengaturan.detail') }}"
       class="text-blue-600 hover:underline text-sm font-medium">
        Detail
    </a>
</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4 text-sm text-gray-500">

        {{-- Entries info --}}
        <div>
            1–10 of 97 entries
        </div>

        {{-- Pagination --}}
        <div class="flex items-center gap-4">

            {{-- Rows per page --}}
    <div class="flex items-center gap-2">
        <span class="text-sm text-gray-600">Rows per page:</span>
        <select class="border rounded-md px-8 py-1 text-sm">
            <option selected>10</option>
            <option>25</option>
            <option>50</option>
        </select>
    </div>

            {{-- Page --}}
            <div class="flex items-center gap-2">
                <button class="px-2 py-1 border rounded hover:bg-gray-100">
                    ‹
                </button>
                <span>1 / 10</span>
                <button class="px-2 py-1 border rounded hover:bg-gray-100">
                    ›
                </button>
            </div>
        </div>
    </div>

</div>


    {{-- Script --}}
    <script>
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.table-row');
        const emptyState = document.getElementById('emptyState');
        const yearFilter = document.getElementById('yearFilter');
        const yearTitle = document.getElementById('year-title');

        searchInput.addEventListener('keyup', () => {
            let visible = 0;
            const keyword = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const unit = row.querySelector('.unit-kerja').innerText.toLowerCase();
                if (unit.includes(keyword)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            emptyState.classList.toggle('hidden', visible !== 0);
        });

        yearFilter.addEventListener('change', () => {
            yearTitle.innerText = yearFilter.value;
        });
    </script>
</x-app-layout>
