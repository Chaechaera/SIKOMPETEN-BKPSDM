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
    <x-izin-navbar />

    {{-- Hero Section --}}
    <x-izin-hero />

    {{-- ======================= CEK SERTIFIKAT ASN ======================= -->
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
                <input id="nipInput" type="text" placeholder="Masukkan NIP Anda" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3
                       focus:outline-none focus:border-purple-600 mb-4">

                <button onclick="cekSertifikat()" class="w-full bg-gradient-to-r from-[#922B80] to-[#5B2C89]
                       text-white py-3 rounded-lg font-semibold hover:opacity-90">
                    Cari Sertifikat
                </button>
            </div>

            <!-- NOT FOUND -->
            <div id="notFound" class="hidden mt-8 text-center text-red-600 font-medium">
                ❌ Sertifikat dengan NIP tersebut tidak ditemukan
            </div>

            <!-- RESULT -->
            <div id="result" class="hidden mt-12 border-t pt-10">

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
                        <button class="px-5 py-2 text-sm rounded-lg border border-gray-300 hover:bg-gray-100">
                            Lihat
                        </button>

                        <button id="downloadBtn"
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
async function cekSertifikat() {
    const nipInput = document.getElementById("nipInput").value.trim();
    const result = document.getElementById("result");
    const notFound = document.getElementById("notFound");
    const downloadBtn = document.getElementById("downloadBtn");

    result.classList.add("hidden");
    notFound.classList.add("hidden");

    if (!nipInput) return;

    try {
        const response = await fetch(`/user/ceksertifikat/${nipInput}`);
        const data = await response.json();

        if (data.success) {
            document.getElementById("namaPelatihan").innerText = data.data.pelatihan;
            document.getElementById("namaASN").innerText = data.data.nama;
            document.getElementById("nipASN").innerText = "NIP: " + data.data.nip;

            // ✅ set download
            downloadBtn.onclick = () => {
                window.location.href = data.data.download_url;
            };

            result.classList.remove("hidden");
        } else {
            notFound.classList.remove("hidden");
        }

    } catch (e) {
        console.error(e);
        notFound.classList.remove("hidden");
    }
}
</script>
    <!-- ======================= END CEK SERTIFIKAT ASN ======================= --}}

    {{-- Fitur Section --}}
    <x-izin-fitur-section />

    {{-- Alur Proses --}}
    <x-izin-alur-proses />

    {{-- Footer --}}
    <x-izin-footer />

</body>

</html>