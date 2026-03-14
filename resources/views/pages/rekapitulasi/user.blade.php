<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIKOMPETEN</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white font-sans antialiased">

    {{-- Navbar --}}
    @include('components.izin-navbar')

    {{-- Background utama --}}
    <div class="min-h-screen bg-gray-100 pt-24">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-8 pb-16">

            {{-- Card Formulir --}}
            <div class="bg-white rounded-xl shadow p-6 mb-4 mt-10">
                <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">REKAPITULASI KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                <p class="text-sm text-gray-500 max-w-4xl">
                    Daftar Rekap Kegiatan Pengembangan Kompetensi ASN di lingkungan Pemerintah Kota Surakarta
                </p>
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
                                        <th class="py-3 px-4 text-left font-semibold">Jumlah Kegiatan Bangkom</th>
                                        <th class="py-3 px-4 text-left font-semibold">0 - 10 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">11 - 19 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">&gt; 20 JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">Total JP</th>
                                        <th class="py-3 px-4 text-left font-semibold">% &gt; 20 JP</th>
                                    </tr>
                                </thead>
                                <tbody>
@forelse ($rekap as $index => $row)
<tr class="border-b hover:bg-gray-50 table-row">
    <td class="p-4 border-r">{{ $index + 1 }}</td>
    <td class="p-4 border-r unit-kerja font-semibold">
        {{ $row['nama'] }}
    </td>
    <td class="p-4 border-r text-center">
        {{ $row['jumlah_kegiatan'] }}
    </td>
    <td class="p-4 border-r text-center">
        {{ $row['jp0_10'] }}
    </td>
    <td class="p-4 border-r text-center">
        {{ $row['jp11_19'] }}
    </td>
    <td class="p-4 border-r text-center">
        {{ $row['jp20'] }}
    </td>
    <td class="p-4 border-r text-center">
        {{ $row['total'] }}
    </td>
    <td class="p-4 text-center">
        {{ $row['persen_20'] }}
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center py-6 text-gray-500">
        Tidak ada data
    </td>
</tr>
@endforelse
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
        
    {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>
