<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-abuabuMuda border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
            {!! __('pagination.previous') !!}
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium bg-abuabuMuda border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
            {!! __('pagination.next') !!}
        </a>
        @else
        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-abuabuCerah leading-5 font-semibold">
                @if ($paginator->firstItem())
                <span>{{ $paginator->firstItem() }}</span>
                {!! __('-') !!}
                <span>{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                {!! __('dari') !!}
                <span>{{ $paginator->total() }}</span>
                {!! __('hasil') !!}
            </p>
        </div>

        <div>
            <span class="flex items-center gap-2">
                {{-- Previous Page Link --}}
                {{-- @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i> 
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="{{ __('pagination.previous') }}">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                @endif--}}
                @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-2 py-2 text-sm font-bold text-black bg-white border border-gray-300 cursor-default rounded-md">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-bold text-black bg-white border border-gray-300 rounded-md hover:bg-abuabuCerah transition">
                    <i data-lucide="chevron-left" class="w-5 h-5"></i>
                </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                @endphp

                {{-- Current & Next --}}
                @for ($i = $current; $i <= min($current + 1, $last); $i++)
                    @if ($i == $current)
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-biruMariana border border-gray-300 rounded-md">
                        {{ $i }}
                    </span>
                    @else
                    <a href="{{ $paginator->url($i) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-black bg-white border border-gray-300 hover:bg-abuabuCerah rounded-md transition">
                        {{ $i }}
                    </a>
                    @endif
                @endfor

                {{-- Dots --}}
                @if ($current + 2 < $last)
                    <span class="px-3 py-2 text-sm font-bold text-black">...</span>
                @endif

                {{-- Last Pages --}}
                @for ($i = max($last - 1, 1); $i <= $last; $i++)
                    @if ($i > $current + 1)
                    <a href="{{ $paginator->url($i) }}" class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-black bg-white border border-gray-300 hover:bg-abuabuCerah rounded-md transition">
                        {{ $i }}
                    </a>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                {{--@if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-black bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="{{ __('pagination.next') }}">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </a>
                @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </span>
                </span>
                @endif--}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 text-sm font-bold text-black bg-white border border-gray-300 rounded-md hover:bg-abuabuCerah transition">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </a>
                @else
                <span class="relative inline-flex items-center px-2 py-2 text-sm font-bold text-black bg-white border border-gray-300 cursor-default rounded-md">
                    <i data-lucide="chevron-right" class="w-5 h-5"></i>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
