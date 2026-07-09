@props([
    'title',
    'description',
    'position' => 'center',
])

@php
    $positionClass = match ($position) {
        'left' => 'left-0',
        'right' => 'right-0',
        default => 'left-1/2 -translate-x-1/2',
    };
@endphp

<div class="relative inline-flex group">

    {{-- Icon Info --}}
    <button
        type="button"
        class="ml-1 flex items-center justify-center
               w-4 h-4 rounded-full
               hover:bg-primary hover:text-white
               transition">

        <i data-lucide="info" class="w-3 h-3"></i>

    </button>

    {{-- Tooltip --}}
    <div
        class="absolute top-full mt-2 {{ $positionClass }}
               hidden group-hover:block
               w-80 max-w-xs
               rounded-xl bg-white
               border border-abuabuCerah/30
               shadow-xl
               p-4
               text-left
               whitespace-normal
               break-words
               z-[9999]">

        <h4 class="text-sm font-semibold">
            {{ $title }}
        </h4>

        <p class="text-xs font-normal leading-relaxed whitespace-pre-line">
            {{ $description }}
        </p>

    </div>

</div>