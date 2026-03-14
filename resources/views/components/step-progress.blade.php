@props(['usulan' => null])

@php
$status = $usulan?->status_ui ?? 'null';

$hasPelaksanaan = $usulan?->inputusulankegiatans?->pelaksanaankegiatans;

$isLaporan = !empty($hasPelaksanaan);

/* ================= TITLE DINAMIS ================= */
$title = $isLaporan
? 'Progress Pelaporan Hasil Kegiatan'
: 'Progress Pengajuan Usulan Kegiatan';

/* ================= STEPS ================= */
$steps = $isLaporan
? [
1 => 'Ajukan Laporan',
2 => 'Lengkapi Laporan',
3 => 'Cetak Laporan',
4 => 'Kirim Laporan',
]
: [
1 => 'Ajukan Usulan',
2 => 'Lengkapi Usulan',
3 => 'Cetak Usulan',
4 => 'Kirim Usulan',
];

/* ================= CURRENT STEP ================= */
$currentStep = match ($status) {
'null' => 1,
'in_progress' => 1,
'draft', 'completed' => 2,
'pending' => 3,
'need_review' => 4,
'accepted', 'finish' => 4,
'rejected' => 2,
default => 1,
};

$totalSteps = count($steps);
$progress = intval(($currentStep / $totalSteps) * 100);
@endphp

<div class="bg-white rounded-xl shadow p-6 w-full mb-4">

    {{-- Header --}}
    <div class="mb-6">
        <p class="text-sm text-gray-500">{{ $title }}</p>
        <p class="text-[#2B3674] font-semibold text-lg">
            {{ $progress }}%
        </p>
    </div>

    {{-- Step Wrapper --}}
    <div class="relative w-full">

        {{-- Background Line --}}
        <div class="absolute top-5 left-0 w-full h-0.5 bg-gray-200"></div>

        {{-- Active Line --}}
        <div class="absolute top-5 left-0 h-0.5 bg-[#2B3674] transition-all duration-300"
            style="width: {{ $progress }}%">
        </div>

        <div class="flex justify-between relative">

            @foreach ($steps as $step => $label)
            <div class="flex flex-col items-center text-center w-full">

                {{-- Circle --}}
                <div class="
                    relative z-10 w-10 h-10 rounded-full
                    flex items-center justify-center
                    text-sm font-medium transition-all duration-300
                    {{ $currentStep > $step
                        ? 'bg-[#2B3674] text-white'
                        : ($currentStep == $step
                            ? 'bg-[#2B3674] text-white ring-4 ring-blue-100'
                            : 'bg-gray-200 text-gray-400') }}
                ">

                    @if($currentStep > $step)
                    ✓
                    @else
                    ●
                    @endif

                </div>

                {{-- Label --}}
                <span class="mt-3 text-xs
                    {{ $currentStep >= $step
                        ? 'text-[#2B3674] font-medium'
                        : 'text-gray-400' }}">
                    {{ $label }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>