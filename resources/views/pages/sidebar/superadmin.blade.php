<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'SIKOMPETEN - SuperAdmin')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="text-gray-800">

<!-- SIDEBAR -->
<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-[#F9FAFC] border-r border-gray-200 flex flex-col overflow-y-auto
           transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50">

    <!-- Logo -->
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-28 mb-2">
            <h1 class="text-lg font-bold text-[#2B3674] tracking-wide">SIKOMPETEN</h1>
        </div>

        <button id="closeSidebar" class="md:hidden text-gray-600 hover:text-gray-800 transition">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-2 text-sm">

        <!-- Dashboard -->
        <a
            href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
            {{ Request::is('superadmin/dashboard') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
            <img
                src="{{ Request::is('superadmin/dashboard') ? asset('images/grid-white.png') : asset('images/grid.png') }}"
                class="w-5 h-5">
            Dashboard
        </a>

        <!-- Daftar Usulan -->
        <a
            href="{{ route('superadmin.usulankegiatan.pending') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
            {{ Request::is('superadmin/usulankegiatan/*') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
            <img
    src="{{ Route::is('admin.usulankegiatan.index') 
      ? asset('images/file-white.png') 
      : asset('images/file.png') }}"
    alt="File"
    class="w-5 h-5"
  >
            Daftar Usulan Kegiatan
        </a>

        <!-- Laporan Kegiatan -->
        <a
            href="#"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
            {{ Request::is('identitas/create') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
            <img
    src="{{ Route::is('admin.usulankegiatan.create') 
      ? asset('images/briefcase-white.png') 
      : asset('images/briefcase.png') }}"
    alt="Briefcase"
    class="w-5 h-5"
  >
            Laporan Kegiatan
        </a>

        <!-- Balasan -->
        <a
            href="#"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
            {{ Request::is('identitas/create') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
            <img
    src="{{ Route::is('admin.usulankegiatan.create') 
      ? asset('images/File text-white.png') 
      : asset('images/File text.png') }}"
    alt="Briefcase"
    class="w-5 h-5"
  >
            Daftar Balasan
        </a>

        <!-- User Magement -->
        <a
            href="#"
            class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
            {{ Request::is('identitas/create') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
            <img
    src="{{ Route::is('admin.usulankegiatan.create') 
      ? asset('images/User-white.png') 
      : asset('images/User.png') }}"
    alt="Briefcase"
    class="w-5 h-5"
  >
            User Management
        </a>

        <!-- Other -->
        <div class="mt-6 text-xs text-gray-400 uppercase">Other</div>

        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-headset w-5 text-center"></i>
            Support
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-gear w-5 text-center"></i>
            Settings
        </a>

    </nav>
</aside>

<!-- Overlay Mobile -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 hidden md:hidden z-40"></div>

<!-- Script toggle -->
<script>
    const sidebar = document.getElementById("sidebar");
    const openSidebar = document.getElementById("openSidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const overlay = document.getElementById("overlay");

    openSidebar?.addEventListener("click", () => {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
    });

    closeSidebar?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });
</script>

</body>
</html>
