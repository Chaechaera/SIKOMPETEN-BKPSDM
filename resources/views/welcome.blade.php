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
    <header class="w-full py-6 px-8 flex justify-between items-center bg-gradient-to-r from-[#922B80] to-[#5B2C89] text-white">

        <div class="flex items-center gap-3 text-2xl font-bold">
            <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-36" alt="Logo BKPSDM">
            <span>SIKOMPETEN</span>
        </div>

        <nav class="hidden md:flex items-center gap-8 font-medium">
            <a href="#" class="hover:text-yellow-300">Careers</a>
            <a href="#" class="hover:text-yellow-300">Blog</a>
            <a href="#" class="hover:text-yellow-300">About Us</a>

            @auth
                <a href="{{ url('/dashboard') }}" class="bg-[#F7941E] px-6 py-2 rounded-lg font-semibold shadow-lg">
                    Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-[#F7941E] px-6 py-2 rounded-lg font-semibold shadow-lg">Registrasi</a>
                <a href="{{ route('login') }}" class="bg-[#F7941E] px-6 py-2 rounded-lg font-semibold shadow-lg">Login</a>
            @endauth
        </nav>

    </header>

    <!-- ======================= HERO SECTION ======================= -->
    <section class="w-full bg-gradient-to-br from-[#922B80] to-[#5B2C89] text-white pb-20 pt-16 px-8">
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
                    <button class="border border-white px-6 py-3 rounded-lg font-semibold hover:bg-white/20">
                        Pelajari Lebih Lanjut
                    </button>
                </div>
            </div>

        </div>
    </section>

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
    <section class="py-16 px-8 bg-blue-50">
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
