<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIKOMPETEN')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body class="bg-abuabuKoin text-abuabuSedang">

    <div x-data="{ sidebarOpen: true }" class="relative">

        <!-- 🔘 TOGGLE BUTTON -->
        <button
            @click="sidebarOpen = !sidebarOpen; $nextTick(() => lucide.createIcons())"
            class="fixed top-6 z-[60] transition-all duration-300"
            :class="sidebarOpen ? 'left-[268px]' : 'left-[56px]'">

            <div class="w-10 h-10 bg-white rounded-xl shadow-lg
                flex items-center justify-center
                border border-abuabuCerah/60">
                <i class="w-5 h-5"
                    :data-lucide="sidebarOpen ? 'list-indent-decrease' : 'list-indent-increase'">
                </i>
            </div>
        </button>

        <!-- ✅ SIDEBAR -->
        <aside
            class="fixed inset-y-0 left-0 bg-white border-r border-abuabuCerah/60
            transition-all duration-300 z-50" :class="sidebarOpen ? 'w-72' : 'w-20'">

            <!-- 🔷 HEADER -->
            <div class="p-6 border-b border-abuabuCerah/60">

                <!-- Logo besar -->
                <div class="flex flex-col items-start" x-show="sidebarOpen">
                    <img src="{{ asset('images/logo-bkpsdm.png') }}" class="w-28">
                    <div>
                        <h1 class="text-3xl font-bold bg-primary-gradient bg-clip-text text-transparent leading-tight">
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
            <nav class="flex-1 p-4 space-y-2 font-semibold text-sm">

                <!-- Dashboard -->
                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                    {{ Request::is('superadmin/dashboard')
                    ? 'bg-biruMariana text-white'
                    : 'text-abuabuSedang hover:bg-abuabuMuda/75' }}">

                    <!-- ICON -->
                    <i data-lucide="layout-grid" class="w-5 h-5 shrink-0
                        {{ Request::is('superadmin/dashboard') ? 'text-white' : 'text-abuabuSedang' }}">
                    </i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>

                <!-- Daftar Usulan Kegiatan -->
                <a href="{{ route('superadmin.usulankegiatan.pending') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('superadmin.usulankegiatan*')
                    ? 'bg-biruMariana text-white'
                    : 'text-abuabuSedang hover:bg-abuabuMuda/75' }}">

                    <!-- ICON -->
                    <i data-lucide="folder" class="w-5 h-5 shrink-0
                        {{ Route::is('superadmin.usulankegiatan*') ? 'text-white' : 'text-abuabuSedang' }}">
                    </i>
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

                <!-- Manajemen Pengguna -->
                <a href="{{ route('superadmin.manajemenuser') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('superadmin.manajemenuser')
                    ? 'bg-biruMariana text-white'
                    : 'text-abuabuSedang hover:bg-abuabuMuda/75' }}">

                    <!-- ICON -->
                    <i data-lucide="settings" class="w-5 h-5 shrink-0
                        {{ Route::is('superadmin.manajemenuser') ? 'text-white' : 'text-abuabuSedang' }}">
                    </i>
                    <span x-show="sidebarOpen">Manajemen Pengguna</span>
                </a>

                <!-- 🔻 DIVIDER -->
                <div class="my-4 border-t border-abuabuCerah/60"></div>

                <!-- OTHERS LABEL -->
                <p class="px-3 text-xs font-semibold text-abuabuBesi tracking-wider"
                    x-show="sidebarOpen">
                    OTHERS
                </p>

                <!-- Daftar Laporan Peserta Kegiatan -->
                <a href="{{ route('superadmin.laporanpeserta.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('superadmin.laporanpeserta.index')
                    ? 'bg-biruMariana text-white'
                    : 'text-abuabuSedang hover:bg-abuabuMuda/75' }}">

                    <!-- ICON -->
                    <i data-lucide="clipboard-list" class="w-5 h-5 shrink-0
                        {{ Route::is('superadmin.laporanpeserta.index') ? 'text-white' : 'text-abuabuSedang' }}">
                    </i>
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
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('superadmin.informasi')
                    ? 'bg-biruMariana text-white'
                    : 'text-abuabuSedang hover:bg-abuabuMuda/75' }}">

                    <!-- ICON -->
                    <i data-lucide="info" class="w-5 h-5 shrink-0
                        {{ Route::is('superadmin.informasi') ? 'text-white' : 'text-abuabuSedang' }}">
                    </i>
                    <span x-show="sidebarOpen">Informasi</span>
                </a>
            </nav>
        </aside>

        <!-- ✅ CONTENT WRAPPER -->
        <div
            class="transition-all duration-300"
            :class="sidebarOpen ? 'ml-52' : 'ml-0'">
            @yield('content')
        </div>

    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");

        // Inisialisasi ikon Lucide
        document.addEventListener("DOMContentLoaded", () => {
            lucide.createIcons();
        });

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
