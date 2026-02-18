<aside class="w-64 bg-white shadow-md flex flex-col">
    <!-- Logo -->
    <div class="flex items-center gap-2 p-4 border-b">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10" />
        <span class="font-bold text-lg">SIKOMPETEN</span>
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-2">

        <!-- Dashboard -->
        <a href="{{ route('superadmin.dashboard') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium 
            {{ Request::is('superadmin/dashboard') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>

        <!-- Daftar Usulan Yang Masuk -->
        <a href="{{ route('superadmin.usulankegiatan.pending') }}"
            class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium 
           {{ Request::is('/superadmin/usulankegiatan/listusulankegiatanpending') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-list"></i>
            <span>Daftar Usulan Kegiatan</span>
        </a>

        <!-- Manajemen User ASN -->
        <a href="#"
            class="flex items-center gap-2 px-3 py-2 rounded-lg font-medium 
           {{ Request::is('identitas/create') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-box"></i>
            <span>Manajemen User</span>
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