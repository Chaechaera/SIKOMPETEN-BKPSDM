@php
    /**
     * STEP PROGRESS – UI ONLY
     * Aman tanpa DB
     */

    // Step aktif (default 1)
    $currentStep = $currentStep ?? 1;

    // Daftar step (pastikan TIDAK NULL)
    $steps = $steps ?? [
        1 => 'Input Data',
        2 => 'Cetak Usulan',
        3 => 'Kirim Usulan',
        4 => 'Input Laporan',
        5 => 'Cetak Laporan',
        6 => 'Kirim Laporan',
        7 => 'Unggah Peserta',
        8 => 'Unggah Template',
        9 => 'Download Sertifikat',
    ];

    // Total step (anti error)
    $totalSteps = is_countable($steps) && count($steps) > 0 ? count($steps) : 1;

    // Persentase progress
    $progress = intval(($currentStep / $totalSteps) * 100);
@endphp

<div class="bg-white rounded-xl shadow p-6">

    {{-- Header --}}
    <div class="mb-4">
        <p class="text-sm text-gray-500">Processing</p>
        <p class="text-blue-600 font-semibold">
            {{ $progress }}%
        </p>
    </div>

    {{-- Wrapper scroll horizontal --}}
    <div class="overflow-x-auto">
        <div class="flex items-start min-w-max gap-10 px-2">

            @foreach ($steps as $step => $label)
                <div class="flex flex-col items-center relative min-w-[100px]">

                    {{-- Garis --}}
                    @if (!$loop->first)
                        <div class="absolute top-5 -left-10 w-10 h-0.5
                            {{ $currentStep >= $step ? 'bg-blue-600' : 'bg-gray-200' }}">
                        </div>
                    @endif

                    {{-- Bulatan --}}
                    <div class="
                        relative z-10 w-10 h-10 rounded-full
                        flex items-center justify-center
                        text-sm font-medium
                        {{ $currentStep >= $step
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 text-gray-400' }}
                    ">
                        {{ $step }}
                    </div>

                    {{-- Label --}}
                    <span class="mt-2 text-xs text-center leading-tight
                        {{ $currentStep >= $step
                            ? 'text-blue-600 font-medium'
                            : 'text-gray-400' }}">
                        {{ $label }}
                    </span>
                </div>
            @endforeach

        </div>
    </div>

</div>
