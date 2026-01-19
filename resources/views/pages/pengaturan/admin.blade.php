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
                <div class="relative w-72">
                    <input
                        type="text"
                        placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 border rounded-md text-sm"
                    />
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M16 10.5A5.5 5.5 0 115.5 10.5a5.5 5.5 0 0111 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    Daftar Penanggung Jawab
                </h3>
                <p class="text-sm text-gray-500">
                    Detail hanya dapat diakses jika status <b>Aktif</b>
                </p>
            </div>

            <div class="border rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b text-gray-600">
                            <th class="py-3 px-4 text-left w-16">No</th>
                            <th class="py-3 px-4 text-left">Nama Penanggung Jawab</th>
                            <th class="py-3 px-4 text-left">Asal OPD</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center w-32">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $data = [
                                ['Dr. Budi Santoso, M.Si', 'BKPSDM Provinsi Kalbar', 'active'],
                                ['Ir. Siti Rahmawati, M.T', 'Dinas Pendidikan', 'inactive'],
                                ['Drs. Ahmad Hidayat, M.M', 'Dinas Kesehatan', 'inactive'],
                                ['Hj. Nurlaila, S.Sos, MAP', 'Dinas Sosial', 'inactive'],
                                ['Drs. Sukarno, M.Si', 'BAPPEDA', 'inactive'],
                                ['Ir. Wawan Setiawan, M.T', 'Dinas PUPR', 'inactive'],
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

                            {{-- STATUS --}}
                            <td class="py-3 px-4 text-center">
                                @if($row[2] === 'active')
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-500 font-medium">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="py-3 px-4 text-center">
                                @if($row[2] === 'active')
                                    <a href="{{ route('admin.pengaturan.detail') }}"
                                       class="text-blue-600 hover:underline text-sm font-medium">
                                        Detail
                                    </a>
                                @else
                                    <span
                                        class="text-gray-400 text-sm font-medium cursor-not-allowed"
                                        title="Aktifkan data untuk melihat detail">
                                        Detail
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                <span>1–6 dari 6 data</span>
            </div>

        </div>

    </main>
</div>
</x-app-layout>
