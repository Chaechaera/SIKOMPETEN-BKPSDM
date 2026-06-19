<div class="py-2">
    {{-- Panel Switch --}}
    @include('components.izin-menu-switch-panel')

    {{-- Profile --}}
    <a href="{{ route('profile.edit') }}" 
        class="flex items-center gap-3 px-4 py-2 text-sm hover:bg-abuabuCerah/70">
        <i data-lucide="user-pen" class="w-5 h-5"></i>
        Edit Profil
    </a>

    {{-- Log Out --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
            class="w-full flex items-center gap-3 px-4 py-2 text-sm hover:bg-abuabuCerah/70">
            <i data-lucide="log-out" class="w-5 h-5"></i>
            Log Out
        </button>
    </form>
</div>