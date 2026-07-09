<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIKOMPETEN</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans antialiased">

    {{-- Navbar --}}
    @include('components.izin-navbar')

    {{-- Background utama --}}
    <div class="min-h-screen pt-24">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-4 pb-12">

        {{-- INFORMASI AKUN --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow mb-8 mt-10">

            <div class="bg-blue-50 border-b border-blue-100 px-6 py-5">

                <h2 class="text-2xl font-semibold text-blue-700">
                    Informasi Akun
                </h2>

                <p class="text-blue-600 text-sm mt-1">
                    Informasi akun yang sedang digunakan.
                </p>

            </div>

            <div class="p-6">

                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- FOTO --}}
                    <div class="flex justify-center">

                        @if(Auth::user()->foto)

                            <img
                                src="{{ asset('storage/'.Auth::user()->foto) }}"
                                class="w-40 h-40 rounded-full object-cover border-4 border-blue-100 shadow">

                        @else

                            <img
                                src="{{ asset('images/default-profile.png') }}"
                                class="w-40 h-40 rounded-full object-cover border-4 border-blue-100 shadow">

                        @endif

                    </div>

                    {{-- DETAIL --}}
                    <div class="flex-1">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <p class="text-sm text-gray-500">Nama</p>
                                <p class="text-lg font-semibold">
                                    {{ Auth::user()->nama }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-lg font-semibold">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">OPD</p>
                                <p class="text-lg font-semibold">
                                    {{ Auth::user()->subunitkerjas->sub_unitkerja ?? '-' }}
                                </p>
                            </div>

                        </div>

                        @if(Auth::user()->role === 'user')

                            <div class="mt-8">
                                <button
                                    onclick="document.getElementById('editInformasi').classList.toggle('hidden')"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                                    Edit Informasi

                                </button>
                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- FORM EDIT --}}
        @if(Auth::user()->role === 'user')

        <div id="editInformasi" class="hidden">
            @include('profile.partials.update-profile-information-form')
        </div>

        @endif

        {{-- PASSWORD --}}
        @include('profile.partials.update-password-form')

        {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-3 text-base text-center mb-6">
                    <a href="{{ route('user.dashboard') }}"
                        class="px-4 py-4 w-60 bg-abuabuMuda rounded-lg font-semibold hover:bg-abuabuMuda/60 transition">
                        Kembali
                    </a>
                </div>

    </div>
    </div>

        {{-- Navbar --}}
    @include('components.izin-footer')
</body>

</html>