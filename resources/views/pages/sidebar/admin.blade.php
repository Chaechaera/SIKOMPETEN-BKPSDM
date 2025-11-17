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


    <!-- Sidebar -->
    <aside
  id="sidebar"
  class="fixed inset-y-0 left-0 w-64 bg-[#F9FAFC] border-r border-gray-200 flex flex-col overflow-y-auto
         transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-50"
>

      <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <div>
          <img
            src="{{ asset('images/logo-bkpsdm.png') }}"
            alt="Logo BKPSDM"
            class="w-28 mb-2"
          />
          <h1 class="text-lg font-bold text-[#2B3674] tracking-wide">SIKOMPETEN</h1>
        </div>

        <!-- Tombol close di mobile -->
        <button
          id="closeSidebar"
          class="md:hidden text-gray-600 hover:text-gray-800 transition"
        >
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 p-4 space-y-2 text-sm">

<a
  href="{{ route('admin.dashboard') }}"
  class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
    {{ Request::is('admin/dashboard') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
>
  <img 
    src="{{ Request::is('admin/dashboard') ? asset('images/grid-white.png') : asset('images/grid.png') }}" 
    alt="Grid" 
    class="w-5 h-5"
  >
  Dashboard
</a>



        <!-- Daftar Usulan -->
<a 
  href="{{ route('admin.usulankegiatan.index') }}"
  class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
    {{ Route::is('admin.usulankegiatan.index') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
>
  <img
    src="{{ Route::is('admin.usulankegiatan.index') 
      ? asset('images/file-white.png') 
      : asset('images/file.png') }}"
    alt="File"
    class="w-5 h-5"
  >
  Daftar Usulan
</a>



        <!-- Pengajuan Usulan -->
<a
  href="{{ route('admin.usulankegiatan.create') }}"
  class="flex items-center gap-3 px-3 py-2 rounded-lg font-medium
    {{ Route::is('admin.usulankegiatan.create') ? 'bg-[#1C1F4A] text-white' : 'text-gray-600 hover:bg-[#E8EDFF]' }}"
>
  <img
    src="{{ Route::is('admin.usulankegiatan.create') 
      ? asset('images/briefcase-white.png') 
      : asset('images/briefcase.png') }}"
    alt="Briefcase"
    class="w-5 h-5"
  >
  Pengajuan Usulan
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
