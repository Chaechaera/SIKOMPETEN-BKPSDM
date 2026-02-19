<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}} 
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main 
        class="flex-1 p-6 space-y-6 transition-all duration-300"
        :class="sidebarOpen ? 'ml-64' : 'ml-0'"
    >

<div class="space-y-6 max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="text-center">
            <h2 class="text-2xl font-semibold text-[#2B3674]">
                Pengembangan Kompetensi ASN
            </h2>
        </div>

        {{-- Main Content Card --}}
        <div class="bg-white rounded-xl shadow border">
            <div class="pt-6 px-6 pb-6 space-y-6">

                {{-- Dasar Hukum --}}
                <div>
                    <h3 class="font-medium mb-3">DASAR HUKUM</h3>
                    <div class="space-y-2 text-sm">
                        <p>1. Undang-Undang Nomor 5 Tahun 2014 tentang Aparatur Sipil Negara;</p>
                        <p>2. Peraturan Pemerintah Nomor 11 Tahun 2017 tentang Manajemen Pegawai Negeri Sipil;</p>
                        <p>3. Peraturan Pemerintah Nomor 49 Tahun 2018 tentang Manajemen Pegawai Pemerintah dengan Perjanjian Kerja;</p>
                        <p>4. Peraturan Pemerintah Nomor 17 Tahun 2020 tentang Manajemen Pegawai Negeri Sipil;</p>
                        <p>5. Peraturan Walikota Nomor 51 Tahun 2020 tentang Pengembangan Kompetensi Pegawai Aparatur Sipil Negara di Lingkungan Pemerintah Kota Surakarta;</p>
                        <p>6. Peraturan Walikota Surakarta Nomor 31 Tahun 2023 tentang Pedoman Penyelenggaraan Kompetensi bagi Anggota BPJS Kesehatan di Lingkungan Pemerintah Kota Surakarta;</p>
                        <p>7. Peraturan Walikota Surakarta Nomor 6 Tahun 2025 tentang Tambahan Penghasilan bagi PNS dan PPPK di Lingkungan Pemerintah Kota Surakarta.</p>
                    </div>
                </div>

                {{-- Link Informasi --}}
                <div>
                    <h3 class="font-semibold mb-3 text-blue-600">Link Informasi:</h3>
                    <a 
                        href="https://drive.google.com/drive/folders/1CAbmwteDJ_DopJO_FcmAqfylSwwhPvDag?usp=sharing"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm text-blue-600 hover:underline break-all"
                    >
                        https://drive.google.com/drive/folders/1CAbmwteDJ_DopJO_FcmAqfylSwwhPvDag?usp=sharing
                    </a>
                </div>

                {{-- Keterangan --}}
                <div>
                    <h3 class="font-medium mb-3">Keterangan:</h3>
                    <p class="text-sm leading-relaxed">
                        Pengembangan kompetensi penting untuk memuaskan ASN selaku dan menjadikan perubahan tugas dan tuntutan 
                        layanan. Hanya layanan dan kinerja aparatur yang profesional untuk mendapatkan kepercayaan publik. 
                        Untuk itu, perlu diupayakan agar layanan dan kinerja aparatur yang profesional melalui penyelenggaraan 
                        pengembangan kompetensi guna mencapai visi dan misi sesuai dengan perkembangan ilmu pengetahuan dan 
                        teknologi global.
                    </p>
                </div>

                {{-- File --}}
                <div>
                    <h3 class="font-medium mb-3">File:</h3>
                    <p class="text-sm text-gray-500">
                        Tidak ada file yang tersedia saat ini
                    </p>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
