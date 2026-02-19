@props(['statususulan_kegiatanSaatini' => null])

@php
    // Daftar semua langkah
    $steps = [
        ['key' => 'draft', 'label' => 'Pengajuan Usulan'],
        ['key' => 'pending', 'label' => 'Menunggu Verifikasi'],
        ['key' => 'accepted', 'label' => 'Pengajuan Diterima'],
        ['key' => 'rejected', 'label' => 'Pengajuan Ditolak'],
        ['key' => 'in_progress', 'label' => 'Pelaksanaan Kegiatan'],
        ['key' => 'completed', 'label' => 'Upload Laporan'],
        ['key' => 'in_review', 'label' => 'Peninjauan Laporan'],
        ['key' => 'finish', 'label' => 'Selesai'],
    ];

// Filter untuk hide accepted/rejected sesuai aturan
/*if ($statususulan_kegiatanSaatini === 'rejected') {
    $filteredSteps = array_values(array_filter($steps, fn($s) => $s['key'] !== 'accepted'));
} else {
    $filteredSteps = array_values(array_filter($steps, fn($s) => $s['key'] !== 'rejected'));
}*/

// Ambil daftar key utk pencarian posisi index
/*$keys = array_column($steps, 'key');
$statususulan_kegiatanIndexsaatini = array_search($statususulan_kegiatanSaatini, $keys);

// Jika tidak ada usulan kegiatan → semua step abu-abu
if ($statususulan_kegiatanIndexsaatini === false) {
    $statususulan_kegiatanIndexsaatini = -1;
}*/

$keys = array_column($steps, 'key');
$currentIndex = array_search($processStatus, $keys);
$currentIndex = $currentIndex === false ? -1 : $currentIndex;
@endphp

<div class="flex items-center w-full overflow-x-auto">
    @foreach ($steps as $index => $step)
        <div class="flex flex-col items-center text-center">
            <div
                class="w-8 h-8 flex items-center justify-center rounded-full font-semibold transition-all duration-300
                    {{ $index < $currentIndex ? 'bg-cyan-700 text-white' : '' }}
                    {{ $index === $currentIndex ? 'bg-green-600 text-white' : '' }}
                    {{ $index > $currentIndex ? 'bg-gray-300 text-black' : '' }}">
                    {{ $loop->iteration }}
            </div>
            <p class="text-xs mt-1 w-32">{{ $step['label'] }}</p>
        </div>

        {{-- Garis antar step --}}
        @if (! $loop->last)
            <div
                class="flex-1 h-0.5 mx-2 transition-all duration-300
                    {{ $index < $currentIndex ? 'bg-cyan-700' : 'bg-gray-300' }}">
            </div>
        @endif
    @endforeach
</div>
