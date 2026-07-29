<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

@php
$activeRole = session('active_role', Auth::user()->role);
$realRole = Auth::user()->role;
@endphp

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        {{-- Sidebar --}}
        @if($activeRole === 'superadmin')
        @include('pages.sidebar.superadmin')
        @elseif($activeRole === 'admin')
        @include('pages.sidebar.admin')
        @endif

        <!-- Page Content -->
        <main
            class="flex-1 transition-all duration-300"
            :class="sidebarOpen ? 'ml-0' : 'ml-20'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- Main Content --}}
            {{ $slot }}
        </main>
    </div>
</body>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

</html>