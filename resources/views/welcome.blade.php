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

    {{-- Fitur Section --}}
    <x-izin-fitur-section />

    {{-- Alur Proses --}}
    <x-izin-alur-proses />

    {{-- Footer --}}
    <x-izin-footer />

</body>

</html>