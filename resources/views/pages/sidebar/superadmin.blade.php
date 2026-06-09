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

    <div x-data="{ sidebarOpen: true }" class="relative">

        <!-- 🔘 TOGGLE BUTTON -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="fixed top-6 z-[60] transition-all duration-300"
            :class="sidebarOpen ? 'left-[232px]' : 'left-[56px]'">

            <div class="w-10 h-10 bg-white rounded-xl shadow-lg
                flex items-center justify-center
                border border-gray-200">
                <i class="fa-solid"
                    :class="sidebarOpen ? 'fa-xmark' : 'fa-bars'"></i>
            </div>
        </button>

        <!-- ✅ SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 bg-[#F9FAFC] border-r border-gray-200
               flex flex-col overflow-hidden transition-all duration-300 z-50"
            :class="sidebarOpen ? 'w-64' : 'w-20'">

            <!-- 🔷 HEADER -->
            <div class="p-6 border-b border-gray-200">

                <!-- Logo besar -->
                <div class="flex flex-col items-start" x-show="sidebarOpen">
                    <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-28">
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">
                            SIKOMPETEN
                        </h1>
                    </div>
                </div>

                <!-- Logo kecil saat collapse -->
                <div class="flex justify-center" x-show="!sidebarOpen">
                    <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-10">
                </div>
            </div>

            <!-- 🔷 NAVIGATION -->
            <nav class="flex-1 p-4 space-y-2 text-sm">

                <!-- Dashboard -->
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ Request::is('superadmin/dashboard')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ Request::is('superadmin/dashboard')
                    ? asset('images/grid-white.png')
                    : asset('images/grid.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <!-- Daftar Usulan -->
                <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ Route::is('superadmin.usulankegiatan*')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ Route::is('superadmin.usulankegiatan*')
                    ? asset('images/file-white.png')
                    : asset('images/file.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Daftar Usulan Kegiatan</span>
                </a>

                <!-- Daftar Laporan -->
                <!-- Daftar Laporan -->
<a href="{{ route('superadmin.laporankegiatan.pending') }}"
    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
    {{
        Route::is('superadmin.laporankegiatan*')
        && !Route::is('superadmin.laporankegiatan.arsip')
            ? 'bg-[#1C1F4A] text-white'
            : 'text-gray-600 hover:bg-[#E8EDFF]'
    }}">

                    <img src="{{
    Route::is('superadmin.laporankegiatan*')
    && !Route::is('superadmin.laporankegiatan.arsip')
        ? asset('images/file-white.png')
        : asset('images/file.png')
}}"
class="w-5 shrink-0">
                    <span x-show="sidebarOpen">Daftar Laporan Kegiatan</span>
                </a>

                <!-- Manajemen User -->
                <a href="{{ route('superadmin.manajemenuser') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ request()->routeIs('superadmin.manajemenuser')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ request()->routeIs('superadmin.manajemenuser')
                    ? asset('images/Settings-white.png')
                    : asset('images/Settings.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Manajemen User</span>
                </a>

                <!-- 🔻 DIVIDER -->
                <div class="my-4 border-t border-gray-200"></div>

                <!-- OTHERS LABEL -->
                <p class="px-3 text-xs font-semibold text-gray-400 tracking-wider"
                    x-show="sidebarOpen">
                    OTHERS
                </p>

                <!-- Rekapitulasi -->
                <a href="{{ route('superadmin.rekapitulasi') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ Route::is('superadmin.rekapitulasi')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ Route::is('superadmin.rekapitulasi')
                    ? asset('images/briefcase-white.png')
                    : asset('images/briefcase.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Rekapitulasi</span>
                </a>

                <!-- Daftar Laporan Peserta Kegiatan -->
                <a href="{{ route('superadmin.laporanpeserta.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ Route::is('superadmin.laporanpeserta.index')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ Route::is('superadmin.laporanpeserta.index')
                    ? asset('images/briefcase-white.png')
                    : asset('images/briefcase.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Daftar Laporan Peserta</span>
                </a>

                <!-- Arsip Laporan  -->
                <a href="{{ route('superadmin.laporankegiatan.arsip') }}"
    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
    {{ Route::is('superadmin.laporankegiatan.arsip')
        ? 'bg-[#1C1F4A] text-white'
        : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

    <img src="{{ Route::is('superadmin.laporankegiatan.arsip')
        ? asset('images/Archive-white.png')
        : asset('images/Archive.png') }}"
        class="w-5 shrink-0">

    <span x-show="sidebarOpen">Arsip Laporan</span>
</a>

                <!-- Informasi -->
                <a href="{{ route('superadmin.informasi') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl font-medium transition-all duration-200
               {{ Request::is('superadmin/informasi')
                    ? 'bg-[#1C1F4A] text-white'
                    : 'text-gray-600 hover:bg-[#E8EDFF]' }}">

                    <img src="{{ Request::is('superadmin/informasi')
                    ? asset('images/Info-white.png')
                    : asset('images/Info.png') }}"
                        class="w-5 shrink-0">

                    <span x-show="sidebarOpen">Informasi</span>
                </a>

            </nav>
        </aside>

        <!-- ✅ CONTENT WRAPPER -->
        <div class="transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-20'">
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