@props(['statususulan_kegiatanSaatini' => 'draft'])

@php
    // Daftar semua langkah
    $steps = [
        ['key' => 'draft', 'label' => 'Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN'],
        ['key' => 'pending', 'label' => 'Menunggu Verifikasi Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN'],
        ['key' => 'accepted', 'label' => 'Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN Diterima'],
        ['key' => 'rejected', 'label' => 'Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN Ditolak'],
        ['key' => 'in_progress', 'label' => 'Pelaksanaan Kegiatan Pengembangan Kompetensi ASN'],
        ['key' => 'completed', 'label' => 'Upload Bukti Hasil Pelaksanaan Kegiatan Pengembangan Kompetensi ASN'],
        ['key' => 'in_review', 'label' => 'Peninjauan Pengakuan JP Dari Kegiatan Pengembangan Kompetensi ASN Yang Terlaksana'],
        ['key' => 'finish', 'label' => 'Proses Selesai dan Sertifikat Pengakuan JP Peserta Dapat Diakses'],
    ];

    // Filter: jika status "rejected", sembunyikan "approved"
    // jika status "approved" atau setelahnya, sembunyikan "rejected"
    if ($statususulan_kegiatanSaatini === 'rejected') {
        $filteredSteps = array_filter($steps, fn($s) => $s['key'] !== 'accepted');
    } else {
        $filteredSteps = array_filter($steps, fn($s) => $s['key'] !== 'rejected');
    }

    // Ambil daftar key utk pencarian posisi index
    $keys = array_column($steps, 'key');
    $statususulan_kegiatanIndexsaatini = array_search($statususulan_kegiatanSaatini, $keys);
@endphp

<div class="flex items-center w-full overflow-x-auto">
    @foreach ($filteredSteps as $index => $step)
        <div class="flex flex-col items-center text-center">
            <div
                class="w-8 h-8 flex items-center justify-center rounded-full font-semibold transition-all duration-300
                {{ $index === $statususulan_kegiatanIndexsaatini ? 'bg-green-600 text-white' : '' }}
                {{ $index < $statususulan_kegiatanIndexsaatini ? 'bg-cyan-800 text-white' : '' }}
                {{ $index > $statususulan_kegiatanIndexsaatini ? 'bg-gray-300 text-black' : '' }}"
            >
                {{ $loop->iteration }}
            </div>
            <p class="text-xs mt-1 w-32">{{ $step['label'] }}</p>
        </div>

        {{-- Garis antar step --}}
        @if (! $loop->last)
            <div
                class="flex-1 h-0.5 mx-2 transition-all duration-300
                {{ $index < $statususulan_kegiatanIndexsaatini ? 'bg-cyan-800' : 'bg-gray-300' }}">
            </div>
        @endif
    @endforeach
</div>
