<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIKOMPETEN')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
  </head>

<body class="text-gray-800">

    <div x-data="{ sidebarOpen: true }">
    <!-- Tombol Open Sidebar -->
   <button
    @click="sidebarOpen = true"
    class="fixed top-1/2 -translate-y-1/2 left-4 z-50 bg-white p-2 rounded-lg shadow"
    x-show="!sidebarOpen"
    x-transition
>
    <i class="fa-solid fa-bars text-xl text-gray-700"></i>
</button>

     <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 w-64 bg-[#F9FAFC] border-r border-gray-200
               flex flex-col overflow-y-auto transform transition-transform
               duration-300 ease-in-out z-50"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <div>
                <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-28 mb-2">
                <h1 class="text-lg font-bold text-[#2B3674]">SIKOMPETEN</h1>
            </div>

            <!-- Close Sidebar -->
            <button @click="sidebarOpen = false" class="text-gray-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- NAV -->
        <nav class="flex-1 p-4 space-y-2 text-sm">
        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium 
            {{ Request::is('superadmin/dashboard') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
            >
            <img src="{{ Request::is('superadmin/dashboard') ? asset('images/grid-white.png') : asset('images/grid.png') }}" class="w-5">
                Dashboard
            </a>

            <!-- Informasi -->
            <a 
                href="{{ route('superadmin.informasi') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                {{ Request::is('superadmin/informasi') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
            >
                <img src="{{ Request::is('superadmin/informasi') ? asset('images/Info-white.png') : asset('images/Info.png') }}" class="w-5">
                Informasi
            </a>

        <!-- Daftar Pengajuan -->
            <a 
                href="{{ route('usulankegiatan.daftar-masuk') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                {{ Route::is('usulankegiatan.daftar-masuk') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
            >
                <img src="{{ Route::is('usulankegiatan.daftar-masuk') ? asset('images/file-white.png') : asset('images/file.png') }}" class="w-5">
                Daftar Pengajuan
            </a>

        <!-- Daftar Laporan Yang Masuk -->
        <a 
    href="{{ route('laporan-masuk') }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
    {{ Route::is('laporan-masuk') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
>
    <img 
        src="{{ Route::is('laporan-masuk') 
            ? asset('images/File text-white.png') 
            : asset('images/File text.png') 
        }}" 
        class="w-5"
    >
    Daftar Laporan
</a>
        <!-- Rekapitulasi -->
            <a 
                href="{{ route('superadmin.rekapitulasi') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                {{ Route::is('superadmin.rekapitulasi') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
            >
                <img src="{{ Route::is('superadmin.rekapitulasi') ? asset('images/briefcase-white.png') : asset('images/briefcase.png') }}" class="w-5">
                Rekapitulasi 
            </a>

        <!-- Other -->
        <div class="mt-6 text-xs text-gray-400 uppercase">Other</div>

        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-headset"></i>
            Support
        </a>

        <a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-gear"></i>
            Settings
        </a>
    </nav>
</aside>
