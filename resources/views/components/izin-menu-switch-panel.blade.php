@php
$activeRole = session('active_role', Auth::user()->role);
$realRole = Auth::user()->role;
@endphp

<div>

    {{-- SUPERADMIN --}}
    @if ($realRole === 'superadmin')

        {{-- Panel Superadmin --}}
        @if ($activeRole !== 'superadmin')
        <form method="POST" action="{{ route('switch.panel', 'superadmin') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-queen" class="w-5 h-5"></i>  
                Panel Superadmin
            </button>
        </form>
        @endif

        {{-- Panel Admin --}}
        @if ($activeRole !== 'admin')
        <form method="POST" action="{{ route('switch.panel', 'admin') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-rook" class="w-5 h-5"></i>  
                Panel Admin
            </button>
        </form>
        @endif

        {{-- Panel User --}}
        @if ($activeRole !== 'user')
        <form method="POST" action="{{ route('switch.panel', 'user') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-pawn" class="w-5 h-5"></i>  
                Panel User
            </button>
        </form>
        @endif

    @endif


    {{-- ADMIN --}}
    @if ($realRole === 'admin')

        {{-- Panel Admin --}}
        @if ($activeRole !== 'admin')
        <form method="POST" action="{{ route('switch.panel', 'admin') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-rook" class="w-5 h-5"></i>  
                Panel Admin
            </button>
        </form>
        @endif

        {{-- Panel User --}}
        @if ($activeRole !== 'user')
        <form method="POST" action="{{ route('switch.panel', 'user') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-pawn" class="w-5 h-5"></i>  
                Panel User
            </button>
        </form>
        @endif

    @endif

    {{-- ADMIN --}}
    @if ($realRole === 'user')

        {{-- Panel User --}}
        @if ($activeRole !== 'user')
        <form method="POST" action="{{ route('switch.panel', 'user') }}">
            @csrf
            <button type="submit" class="menu-btn">
                <i data-lucide="chess-pawn" class="w-5 h-5"></i>
                Panel User
            </button>
        </form>
        @endif

    @endif

</div>