<x-app-layout>

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main
            class="flex-1 p-6 space-y-6 transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'"
        >

        <div class="space-y-6 max-w-6xl mx-auto">

            {{-- Header --}}
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/rekap.png') }}" alt="Rekap" class="h-8 w-8 mt-1">
                <div>
                    <h1 class="text-2xl font-semibold text-[#2B3674]">
                        REKAPITULASI IZIN PENGEMBANGAN KOMPETENSI ASN TAHUN
                        <span id="year-title">2025</span>
                    </h1>
                    <p class="text-sm text-gray-500 max-w-2xl">
                        Daftar Rekap Izin Pengembangan Kompetensi ASN
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
                <div class="p-6">
                    <div class="border rounded-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm" id="rekapTable">
                                <thead>
                                    <tr class="border-b text-gray-700 bg-[#FAFAFB]">
                                        <th class="py-3 px-4 text-left font-semibold">NO</th>
                                        <th class="py-3 px-4 text-left font-semibold">Unit Kerja / Sub Unit</th>
                                        <th class="py-3 px-4 text-left font-semibold">Jumlah Pegawai</th>
                                        <th class="py-3 px-4 text-left font-semibold">Jumlah Kegiatan Bangkom</th>
                                        <th class="py-3 px-4 text-left font-semibold">0 - 10 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">11 - 19 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">&gt; 20 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">Total JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">% &gt; 20 JP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $data = [
                                            [1,'BKPSDM Surakarta',69,12,0,0,69,69,'100%'],
                                            [2,'DINKES Surakarta',56,8,1,0,55,55,'90%'],
                                            [3,'DISDIK Surakarta',40,6,2,3,35,40,'87%'],
                                            [4,'DISKOMINFO Surakarta',30,5,3,2,25,30,'83%'],
                                            [5,'SETDA Surakarta',50,9,4,1,45,50,'90%'],
                                            [6,'SATPOL PP Surakarta',28,4,5,0,23,28,'82%'],
                                        ];
                                    @endphp

                                    @foreach ($data as $row)
                                    <tr class="border-b hover:bg-gray-50 table-row">
                                        <td class="p-4 border-r">{{ $row[0] }}</td>
                                        <td class="p-4 border-r unit-kerja font-semibold">{{ $row[1] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[2] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[3] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[4] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[5] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[6] }}</td>
                                        <td class="p-4 border-r text-center">{{ $row[7] }}</td>
                                        <td class="p-4 text-center">{{ $row[8] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="emptyState" class="hidden text-center py-12 text-gray-500">
                        Tidak ada data yang sesuai dengan pencarian
                    </div>
                </div>
            </div>

        </div>

        {{-- Script --}}
        <script>
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('.table-row');
            const emptyState = document.getElementById('emptyState');

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
        </script>

    </main>
</x-app-layout>
