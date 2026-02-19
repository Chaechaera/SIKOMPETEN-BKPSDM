<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIKOMPETEN')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="text-gray-800">

    <div x-data="{ sidebarOpen: true }">
        <!-- Tombol Open Sidebar -->
        <button
            @click="sidebarOpen = true"
            class="fixed top-1/2 -translate-y-1/2 left-4 z-50 bg-white p-2 rounded-lg shadow"
            x-show="!sidebarOpen"
            x-transition>
            <i class="fa-solid fa-bars text-xl text-gray-700"></i>
        </button>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 w-64 bg-[#F9FAFC] border-r border-gray-200
               flex flex-col overflow-y-auto transform transition-transform
               duration-300 ease-in-out z-50"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
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
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ Request::is('admin/dashboard') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Request::is('admin/dashboard') ? asset('images/grid-white.png') : asset('images/grid.png') }}" class="w-5">
                    Dashboard
                </a>

                <!-- Daftar Usulan -->
                <a href="{{ route('admin.usulankegiatan.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ Route::is('admin/usulankegiatan') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Route::is('admin/usulankegiatan') ? asset('images/file-white.png') : asset('images/file.png') }}" class="w-5">
                    Daftar Usulan Kegiatan
                </a>

                <!-- Izin Pengembangan -->
                <a href="{{ route('admin.usulankegiatan.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ Route::is('admin/usulankegiatan') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Route::is('admin/usulankegiatan') ? asset('images/file-white.png') : asset('images/file.png') }}" class="w-5">
                    Ajukan Usulan Kegiatan
                </a>

                <!-- Pengaturan Dasar -->
                <a href="{{ route('admin.pengaturan') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ request()->routeIs('admin.pengaturan', 'admin-detail.pengaturan')
                    ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ request()->routeIs('admin.pengaturan', 'admin-detail.pengaturan')
                    ? asset('images/Settings-white.png') : asset('images/Settings.png') }}"
                    class="w-5">
                    Pengaturan Dasar
                </a>

                <!-- Informasi -->
                <a href="{{ route('admin.informasi') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ Request::is('admin/informasi') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Request::is('admin/informasi') ? asset('images/Info-white.png') : asset('images/Info.png') }}" class="w-5">
                    Informasi
                </a>

                <!-- Rekapitulasi -->
                <a href="{{ route('admin.rekapitulasi') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                    {{ Route::is('admin.rekapitulasi') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Route::is('admin.rekapitulasi') ? asset('images/briefcase-white.png') : asset('images/briefcase.png') }}" class="w-5">
                    Rekapitulasi
                </a>

                <!-- Sertifikat -->
                <a href="{{ route('admin.sertifikat') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
                {{ Route::is('admin.sertifikat') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}">
                    <img src="{{ Route::is('admin.sertifikat') ? asset('images/Award-white.png') : asset('images/Award.png') }}" class="w-5">
                    Sertifikat
                </a>
            </nav>
        </aside>

        <!-- Wrapper konten -->
        <div
            class="transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'">
            @yield('content')
        </div>

    </div>


    <script>
        const sidebar = document.getElementById("sidebar");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");

        // Buka sidebar
        openBtn.addEventListener("click", () => {
            sidebar.classList.remove("-translate-x-full");
            openBtn.classList.add("hidden");
        });

        // Tutup sidebar
        closeBtn.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            openBtn.classList.remove("hidden");
        });
    </script>


</body>