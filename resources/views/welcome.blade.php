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

    <!-- ======================= NAVBAR BACKEND (AUTH MASIH BERFUNGSI) ======================= -->
    <header
    class="w-full py-4 px-8 flex justify-between items-center
           bg-gradient-to-r from-[#922B80] to-[#5B2C89] text-white">

    <!-- Logo -->
    <div class="flex items-center gap-3 text-xl font-bold">
        <img src="{{ asset('images/logo-bkpsdm.png') }}"
             class="w-28 object-contain"
             alt="Logo BKPSDM">
        <span>SIKOMPETEN</span>
    </div>

    <!-- Navigation -->
    <nav class="hidden md:flex items-center gap-6 font-medium text-sm">
        <a href="#about-us" class="hover:text-yellow-300 transition">
        About Us
        </a>

        @auth
            <a href="{{ url('/dashboard') }}"
               class="bg-[#F7941E] px-5 py-2 rounded-lg font-semibold shadow-md hover:bg-[#ff9f2a] transition">
                Dashboard
            </a>
        @else
            <a href="{{ route('register') }}"
               class="bg-[#F7941E] px-5 py-2 rounded-lg font-semibold shadow-md hover:bg-[#ff9f2a] transition">
                Registrasi
            </a>
            <a href="{{ route('login') }}"
               class="bg-[#F7941E] px-5 py-2 rounded-lg font-semibold shadow-md hover:bg-[#ff9f2a] transition">
                Login
            </a>
        @endauth
    </nav>

</header>

    <!-- ======================= HERO SECTION ======================= -->
    <section id="about-us"class="w-full bg-gradient-to-br from-[#922B80] to-[#5B2C89] text-white pb-20 pt-16 px-8">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 items-center">

            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4">
                    Sistem Izin Pengembangan <br>
                    <span class="text-yellow-300">Kompetensi ASN</span>
                </h1>
                <p class="text-gray-200 mb-6 max-w-lg">
                    Platform digital yang mempermudah proses pengajuan, verifikasi,
                    dan monitoring kegiatan pengembangan kompetensi ASN.
                </p>

                <div class="flex gap-4 mt-6">
                    <a href="{{ route('login') }}" class="bg-white text-[#5B2C89] px-6 py-3 rounded-lg font-semibold shadow-lg">
                        Mulai Sekarang
                    </a>
                    <a href="#alur" class="border border-white px-6 py-3 rounded-lg font-semibold hover:bg-white/20">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

        </div>
    </section>


    <!-- ======================= CEK SERTIFIKAT ASN ======================= -->
<section class="py-10 px-6 bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg p-10">

        <h2 class="text-3xl font-bold text-center text-[#2B3674] mb-3">
            Cek & Unduh Sertifikat ASN
        </h2>

        <p class="text-center text-gray-500 mb-10 max-w-2xl mx-auto">
            Masukkan NIP untuk melihat dan mengunduh sertifikat pengembangan kompetensi.
        </p>

        <!-- Input -->
        <div class="max-w-xl mx-auto">
            <input
                id="nipInput"
                type="text"
                placeholder="Masukkan NIP Anda"
                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3
                       focus:outline-none focus:border-purple-600 mb-4"
            >

            <button
                onclick="cekSertifikat()"
                class="w-full bg-gradient-to-r from-[#922B80] to-[#5B2C89]
                       text-white py-3 rounded-lg font-semibold hover:opacity-90">
                Cari Sertifikat
            </button>
        </div>

        <!-- NOT FOUND -->
        <div id="notFound"
             class="hidden mt-8 text-center text-red-600 font-medium">
            ❌ Sertifikat dengan NIP tersebut tidak ditemukan
        </div>

        <!-- RESULT -->
        <div id="result"
             class="hidden mt-12 border-t pt-10">

            <h3 class="font-semibold text-[#2B3674] mb-6 text-center">
                Sertifikat Ditemukan
            </h3>

            <div class="border rounded-xl p-6
                        flex flex-col sm:flex-row
                        sm:items-center sm:justify-between gap-6">

                <div>
                    <p id="namaPelatihan" class="font-semibold text-lg"></p>
                    <p id="namaASN" class="text-sm text-gray-500"></p>
                    <p id="nipASN" class="text-xs text-gray-400"></p>
                </div>

                <div class="flex gap-3">
                    <button
                        class="px-5 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-100">
                        Lihat
                    </button>

                    <button
                        class="px-5 py-2 text-sm rounded-lg bg-[#1AB0B0] text-white hover:opacity-90">
                        Unduh
                    </button>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- ======================= SCRIPT DUMMY ======================= -->
<script>
    // DATA DUMMY SERTIFIKAT
    const dataSertifikat = [
        {
            nip: "199012122020121001",
            nama: "Fica Lidya Latifatulhusna",
            pelatihan: "Pelatihan Manajemen ASN"
        },
        {
            nip: "198705152019031002",
            nama: "Andi Saputra",
            pelatihan: "Pelatihan Kepemimpinan Nasional"
        }
    ];

    function cekSertifikat() {
        const nipInput = document.getElementById("nipInput").value;
        const result = document.getElementById("result");
        const notFound = document.getElementById("notFound");

        // reset
        result.classList.add("hidden");
        notFound.classList.add("hidden");

        const found = dataSertifikat.find(item => item.nip === nipInput);

        if (found) {
            document.getElementById("namaPelatihan").innerText = found.pelatihan;
            document.getElementById("namaASN").innerText = found.nama;
            document.getElementById("nipASN").innerText = "NIP: " + found.nip;

            result.classList.remove("hidden");
        } else {
            notFound.classList.remove("hidden");
        }
    }
</script>
<!-- ======================= END CEK SERTIFIKAT ASN ======================= -->

    <!-- ======================= FITUR SECTION ======================= -->
    <section class="text-center py-16 px-6">
        <div class="max-w-7xl mx-auto">

            <h2 class="text-3xl font-bold">Mengapa Memilih <span class="text-[#1AB0B0]">SIKOMPETEN?</span></h2>
            <p class="mt-4 max-w-2xl mx-auto text-gray-600">
                Sistem efisien & transparan untuk pengembangan kompetensi ASN.
            </p>

            <div class="grid md:grid-cols-3 gap-10 mt-10">

                @php
                    $features = [
                        ['img'=>'Digital.png','title'=>'Pengajuan Digital','desc'=>'Ajukan usulan kegiatan secara online.','bg'=>'bg-blue-100'],
                        ['img'=>'Calendar.png','title'=>'Monitoring Real-time','desc'=>'Pantau progres kegiatan setiap saat.','bg'=>'bg-teal-100'],
                        ['img'=>'Users.png','title'=>'Verifikasi Cepat','desc'=>'Proses verifikasi cepat & transparan.','bg'=>'bg-blue-100'],
                        ['img'=>'Shield.png','title'=>'Sistem Terpercaya','desc'=>'Keamanan data terjamin.','bg'=>'bg-purple-100'],
                        ['img'=>'Clock.png','title'=>'Efisiensi Waktu','desc'=>'Proses otomatis dari input hingga verifikasi.','bg'=>'bg-green-100'],
                        ['img'=>'Award.png','title'=>'Sertifikat Digital','desc'=>'Sertifikat otomatis diterbitkan.','bg'=>'bg-sky-100'],
                    ];
                @endphp

                @foreach($features as $f)
                <div class="bg-white p-8 rounded-3xl shadow-lg hover:shadow-xl transition">
                    <div class="w-14 h-14 mx-auto mb-5 rounded-full {{ $f['bg'] }} flex items-center justify-center">
                        <img src="{{ asset('images/'.$f['img']) }}" class="w-8 h-8">
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $f['desc'] }}</p>
                </div>
                @endforeach

            </div>

        </div>
    </section>

    <!-- ======================= ALUR PROSES ======================= -->
    <section id="alur" class="py-16 px-8 bg-blue-50">
        <h2 class="text-center text-2xl font-bold mb-8">
            Alur Proses <span class="text-[#1AB0B0]">SIKOMPETEN</span>
        </h2>

        <div class="grid md:grid-cols-4 gap-8 text-center max-w-5xl mx-auto">
            @php
                $steps = [
                    ['1','Pengajuan Usulan','OTP mengajukan usulan online.'],
                    ['2','Verifikasi BKPSDM','BKPSDM memverifikasi usulan.'],
                    ['3','Pelaksanaan Kegiatan','Kegiatan dilaksanakan sesuai jadwal.'],
                    ['4','Sertifikat Digital','Sertifikat diterbitkan otomatis.'],
                ];
            @endphp

            @foreach($steps as $s)
            <div>
                <div class="text-4xl font-bold text-[#5B2C89] mb-2">{{ $s[0] }}</div>
                <p class="font-semibold">{{ $s[1] }}</p>
                <p class="text-gray-600 text-sm">{{ $s[2] }}</p>
            </div>
            @endforeach

        </div>
    </section>

    <!-- ======================= FOOTER ======================= -->
    <footer class="bg-[#1A1A3D] text-center text-white py-10 px-6">
        <h3 class="text-lg font-semibold tracking-wide">SIKOMPETEN</h3>
        <p class="max-w-xl mx-auto text-gray-300 mb-4">
            Dikembangkan untuk meningkatkan efisiensi dan transparansi pengembangan kompetensi ASN.
        </p>
        <p class="text-gray-400 text-sm">© 2025 SIKOMPETEN.</p>
    </footer>

</body>
</html>
