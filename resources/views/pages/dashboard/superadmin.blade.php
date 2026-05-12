<!-- Dashboard Super Admin Page -->
<x-app-layout>
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

{{-- Sidebar --}}
        @php
    $activeRole = session('active_role', auth()->user()->role);
@endphp

@if ($activeRole === 'superadmin')
    @include('pages.sidebar.superadmin')
@else
    @include('pages.sidebar.admin')
@endif

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- STATISTIK CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE6EB] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Total Usulan</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">24</p>
                    <p class="text-xs text-[#E74C3C] mt-1">+3 minggu ini</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#FFE5B4] shadow-sm">
                <h2 class="text-gray-700 text-sm font-medium">Menunggu Verifikasi</h2>
                <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">8</p>
                    <span class="inline-block mt-2 text-xs bg-yellow-50 text-yellow-700 px-2 py-1 rounded border">
                        Perlu Ditindaklanjuti
                    </span>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#DFFFE0] shadow-sm">
                    <h2 class="text-gray-700 text-sm font-medium">Usulan Disetujui</h2>
                    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">14</p>
                    <p class="text-xs text-green-600">58% dari total</p>
                </div>

                <div class="p-5 sm:p-6 rounded-xl bg-[#E3EEFF] shadow-sm">
    <h2 class="text-gray-700 text-sm font-medium">Laporan Masuk</h2>

    <p class="text-2xl sm:text-3xl font-bold text-[#2B3674] mt-2">
        {{ $total }}
    </p>

    <p class="text-xs text-blue-600">
        {{ $menunggu }} menunggu verifikasi
    </p>
</div>
            </div>

            {{-- Content Box --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-[#2B3674]">Menu Utama</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Daftar Usulan Masuk</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Verifikasi usulan kegiatan dari OPD
                    </p>
                </div>

                <div class="bg-purple-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Daftar Laporan Masuk</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Verifikasi laporan hasil kegiatan
                    </p>
                </div>

                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="font-semibold text-gray-800">Buat Surat Balasan</h3>
                    <p class="text-xs text-gray-600 mt-1">
                        Generate surat balasan untuk OPD
                    </p>
                </div>
            </div>
            </div>

            {{-- BUTTON ACTION --}}
            <div class="flex justify-end">
                <a href="{{ url('surat-balasan-usulan') }}">
                <a href="{{ url('balasan-usulan') }}">
            <button
                class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-medium hover:bg-[#ff9600] transition">
                Buat Surat Balasan
            </button>
                </a>

            </div>

            {{-- Recent Activity --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Usulan Terbaru --}}
            <div class="bg-white shadow rounded-lg">
        {{-- Header --}}
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Usulan Terbaru</h3>
            <p class="text-sm text-gray-500">5 usulan kegiatan terbaru yang masuk</p>
        </div>

        {{-- Content --}}
        <div class="px-6 py-4 space-y-3">
            @php
                $usulans = [
                    ['id'=>1,'title'=>'Pelatihan Manajemen Keuangan','opd'=>'Dinas Pendidikan','status'=>'pending','date'=>'11 Nov 2025'],
                    ['id'=>2,'title'=>'Workshop Pelayanan Publik','opd'=>'Dinas Kesehatan','status'=>'approved','date'=>'10 Nov 2025'],
                    ['id'=>3,'title'=>'Bimtek Pengelolaan Aset','opd'=>'BPKAD','status'=>'pending','date'=>'9 Nov 2025'],
                    ['id'=>4,'title'=>'Pelatihan SPBE','opd'=>'Diskominfo','status'=>'approved','date'=>'8 Nov 2025'],
                    ['id'=>5,'title'=>'Sosialisasi Peraturan Baru','opd'=>'Sekretariat Daerah','status'=>'pending','date'=>'7 Nov 2025'],
                ];
            @endphp

            @foreach ($usulans as $item)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="text-sm text-gray-900">{{ $item['title'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $item['opd'] }} • {{ $item['date'] }}</p>
                    </div>
                    <span class="px-2 py-1 rounded text-xs 
                        @if($item['status'] === 'approved') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 border border-yellow-300 @endif">
                        {{ $item['status'] === 'approved' ? 'Disetujui' : 'Pending' }}
                    </span>
                </div>
            @endforeach

            <a href="/usulan-masuk" class="w-full mt-4 text-blue-600 text-left hover:underline block">
    Lihat Semua Usulan →
</a>


        </div>
    </div>

    {{-- Laporan Terbaru --}}
    <div class="bg-white shadow rounded-lg">
        {{-- Header --}}
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Laporan Terbaru</h3>
            <p class="text-sm text-gray-500">5 laporan hasil kegiatan terbaru</p>
        </div>

        {{-- Content --}}
        <div class="px-6 py-4 space-y-3">
           @foreach ($laporans as $item)
@php
    $input = $item->inputlaporankegiatans?->inputusulankegiatans;

    $title = $input->nama_kegiatan ?? '-';

    $opd = $input?->usulankegiatans?->subunitkerjas?->sub_unitkerja ?? '-';

    $date = \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y');

    $status = $item->status_laporan_ui;
@endphp

    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
        <div>
            <p class="text-sm text-gray-900">{{ $title }}</p>
            <p class="text-xs text-gray-500">{{ $opd }} • {{ $date }}</p>
        </div>

        <span class="px-2 py-1 rounded text-xs
            @if(in_array($status, ['accepted','finish']))
                bg-green-100 text-green-800
            @elseif($status === 'need_review')
                bg-yellow-100 text-yellow-800
            @elseif($status === 'rejected')
                bg-red-100 text-red-800
            @else
                bg-gray-100 text-gray-600
            @endif
        ">
            {{ ucfirst($status) }}
        </span>
    </div>
@endforeach

            <a href="{{ route('superadmin.laporankegiatan.pending') }}" 
   class="w-full mt-4 text-blue-600 text-left hover:underline">
    Lihat Semua Laporan →
</a>
        </div>
    </div>

</div>
            {{-- INFO ALERT --}}
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3">
    <img src="{{ asset('images/Info.png') }}" class="h-5 w-5">
    <div class="text-medium text-blue-800">
        <p class="font-bold">Informasi</p>
        <p class="mt-1">
    Terdapat 8 usulan dan {{ $menunggu }} laporan yang menunggu verifikasi.
    @if($menunggu > 0)
        Mohon segera ditindaklanjuti.
    @else
        Semua laporan sudah diverifikasi 🎉
    @endif
</p>
    </div>
</div>

        </div>
    </main>
</div>
</x-app-layout>
