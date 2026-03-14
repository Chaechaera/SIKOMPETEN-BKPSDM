<div class="py-2">
    {{-- Panel Superadmin--}}
    @if ($realRole === 'superadmin')
    <form method="POST" action="{{ route('switch.panel', 'superadmin') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-table-columns w-4"></i>
            Panel Superadmin
        </button>
    </form>
    @endif

    {{-- Lengkapi Data OPD --}}
    <a href="{{ route('admin.kopunitkerja.create') }}"
        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-box-archive"></i>
        Lengkapi Data OPD
    </a>

    {{-- Profile --}}
    <a href="{{ route('profile.edit') }}"
        class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
        <i class="fa-solid fa-user w-4"></i>
        Profile
    </a>

    {{-- Log Out --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            <i class="fa-solid fa-right-from-bracket w-4"></i>
            Log Out
        </button>
    </form>
</div>