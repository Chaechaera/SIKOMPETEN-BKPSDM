<x-app-layout>
    <div class="space-y-4 px-6 py-4">

        {{-- Card Informasi Rekapitulasi --}}
        <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow p-6 mb-8">
            <h1 class="text-2xl font-medium bg-primary-gradient bg-clip-text text-transparent leading-tight">MANAJEMEN PENGGUNA SIKOMPETEN</h1>
            <p class="text-sm text-abuabuCerah max-w-6xl">
                Kelola status dan peran milik akun pengguna dalam lingkungan sistem informasi SIKOMPETEN.
            </p>
        </div>

        {{-- Search and Filtering --}}
        <div class="flex flex-col md:flex-row gap-4 text-base font-normal">

            {{-- Search --}}
            <div class="bg-white rounded-xl border border-abuabuMuda/60 shadow flex-1 relative">
                <form method="GET">
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search ....." class="w-full border-none pl-12 pr-6 py-3 rounded-lg" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-abuabuGelap"><i data-lucide="search"></i></span>
                </form>
            </div>

            {{-- Sub Unit Kerja Filter --}}
            <form method="GET">
                <select name="subunitkerja" onchange="this.form.submit()"
                    class="bg-white rounded-xl border border-abuabuMuda/60 shadow w-full md:w-52 px-3 py-3 text-abuabuGelap">
                    <option class="text-black" value="">Sub Unit Kerja</option>
                    @foreach ($subunitkerjas as $subunit)
                    <option class="text-black" value="{{ $subunit->id }}"
                        data-singkatan="{{ $subunit->singkatan }}"
                        {{ request('subunitkerja') == $subunit->id ? 'selected' : '' }}>
                        {{ $subunit->sub_unitkerja }} ({{ $subunit->singkatan }})
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="rounded-md bg-green-50 border border-green-100 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="rounded-md bg-red-50 border border-red-100 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
        @endif
        @if(session('warning'))
        <div class="rounded-md bg-yellow-50 border border-yellow-100 px-4 py-3 text-yellow-800">
            {{ session('warning') }}
        </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="w-full text-sm table-auto">
                <thead>
                    <tr class="bg-abuabuMuda font-semibold border-b text-center">
                        <th class="p-4">No</th>
                        <th class="p-4">Sub Unit Kerja OPD</th>
                        <th class="p-4">Username</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Verifikasi</th>
                        <th class="p-4">Atur Role</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $index => $user)
                    <tr class="border-b text-center hover:bg-abuabuCerah/30 table-row">
                        <td class="p-4">{{ $users->firstItem() ? $users->firstItem() + $index : $index + 1 }}</td>

                        <td class="p-4 font-semibold text-left">
                            {{ ucfirst($user->subunitkerjas->sub_unitkerja ?? '-') }}
                        </td>

                        <td class="min-w-[160px] p-4 text-left">
                            {{ $user->nama ?? $user->email }}
                        </td>

                        <td class="p-4 font-semibold">
                            {{ ucfirst($user->role) }}
                        </td>

                        {{-- STATUS --}}
                        <td class="p-4">
                            @if($user->status === 'aktif')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-hijauBening text-hijauDaun">
                                Aktif
                            </span>
                            @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-merahBening text-merahCabai">
                                Nonaktif
                            </span>
                            @endif
                        </td>

                        {{-- Verifikasi --}}
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                @if($user->status === 'aktif')
                                <button
                                    type="button"
                                    disabled
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed">
                                    Aktifkan
                                </button>
                                <form method="POST" action="{{ route('dashboard.users.deactivate', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-merahCabai text-white hover:bg-merahCabai/60">
                                        Nonaktifkan
                                    </button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('dashboard.users.verify-email', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-hijauTua text-white hover:bg-hijauTua/60">
                                        Aktifkan
                                    </button>
                                </form>
                                <button
                                    type="button"
                                    disabled
                                    class="inline-block px-4 py-2 text-xs font-semibold rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed">
                                    Nonaktifkan
                                </button>
                                @endif
                            </div>
                        </td>

                        {{-- Ganti Role --}}
                        <td class="p-4">
                            <div class="flex justify-center gap-2">
                                <form method="POST" action="{{ route('dashboard.users.update-role', $user) }}">
                                    @csrf
                                    @method('PATCH')

                                    <select name="role"
                                        onchange="this.form.submit()"
                                        class="w-full min-w-[120px] p-2 text-xs font-semibold rounded-lg border border-abuabuCerah bg-white focus:ring-2 focus:outline-none">
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>
                                            User
                                        </option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>
                                            Superadmin
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-abuabuMuda">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer Pagination --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

        <div id="emptyState" class="hidden text-center py-12 text-gray-500">
            Tidak ada data yang sesuai dengan pencarian
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // ================================
                // 🔍 SEARCH RESET HANDLER
                // ================================
                const searchInput = document.getElementById('searchInput');

                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        if (this.value.trim() === '') {
                            const url = new URL(window.location.href);
                            url.searchParams.delete('search');
                            url.searchParams.delete('page'); // reset pagination
                            window.location.href = url.toString();
                        }
                    });
                }

                // ================================
                // 🏢 SUBUNIT DROPDOWN HANDLER
                // ================================
                const select = document.querySelector('select[name="subunitkerja"]');

                if (select) {

                    const updateSelectedText = () => {
                        const selectedOption = select.options[select.selectedIndex];

                        if (selectedOption && selectedOption.dataset.singkatan) {
                            selectedOption.text = selectedOption.dataset.singkatan;
                        }
                    };

                    // saat pertama load
                    updateSelectedText();

                    // saat user pilih
                    select.addEventListener('change', function() {
                        updateSelectedText();
                        this.form.submit();
                    });
                }

            });
        </script>
    </div>
</x-app-layout>