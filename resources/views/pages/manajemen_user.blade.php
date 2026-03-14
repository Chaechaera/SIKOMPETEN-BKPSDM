<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.superadmin')

        {{-- Main Content --}}
        <main
            class="flex-1 p-6 space-y-6 transition-all duration-300"
            :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            <div class="flex items-start gap-3">
                <img src="{{ asset('images/rekap.png') }}" alt="User" class="h-8 w-8 mt-1">
                <div>
                    <h1 class="text-2xl font-semibold text-[#2B3674]">
                        MANAJEMEN USER
                    </h1>
                    <p class="text-sm text-gray-500 max-w-2xl">
                        Kelola status dan peran pengguna sistem
                    </p>
                </div>
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
            <div class="bg-white rounded-xl shadow p-6">

                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Daftar User
                    </h3>
                    <p class="text-sm text-gray-500">
                        Admin dapat memverifikasi atau menonaktifkan user
                    </p>
                </div>

                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b text-center text-gray-600">
                                <th class="py-3 px-4 w-14">No</th>
                                <th class="py-3 px-4 w-72">Unit Kerja</th>
                                <th class="py-3 px-4 w-48">Username</th>
                                <th class="py-3 px-4 w-28">Role</th>
                                <th class="py-3 px-4 w-28">Status</th>
                                <th class="py-3 px-4 w-48">Verifikasi</th>
                                <th class="py-3 px-4 w-36">Atur Role</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 text-center">{{ $users->firstItem() ? $users->firstItem() + $index : $index + 1 }}</td>

                                <td class="py-3 px-4 font-medium text-gray-800">
                                    {{ ucfirst($user->subunitkerjas->sub_unitkerja ?? '-') }}
                                </td>

                                <td class="py-3 px-4 font-medium text-gray-800">
                                    {{ $user->nama ?? $user->email }}
                                </td>

                                <td class="py-3 px-4 text-gray-600 text-center">
                                    {{ ucfirst($user->role) }}
                                </td>

                                {{-- STATUS --}}
                                <td class="py-3 px-4 text-center">
                                    @if($user->status === 'aktif')
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                        Aktif
                                    </span>
                                    @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-500 font-medium">
                                        Nonaktif
                                    </span>
                                    @endif
                                </td>

                                {{-- Verifikasi --}}
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Verifikasi --}}
                                        @if(!$user->hasVerifiedEmail())
                                        <form method="POST" action="{{ route('dashboard.users.verify-email', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-green-600 text-white hover:bg-green-700">
                                                Aktifkan
                                            </button>
                                        </form>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-gray-200 text-gray-400 cursor-not-allowed">
                                            Aktifkan
                                        </button>
                                        @endif

                                        {{-- Tombol Nonaktifkan (UI only for now) --}}
                                        @if($user->status === 'aktif')
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-red-600 text-white hover:bg-red-700">
                                            Nonaktifkan
                                        </button>
                                        @else
                                        <button
                                            class="w-24 px-3 py-1.5 text-xs font-medium rounded-md bg-gray-200 text-gray-400 cursor-not-allowed">
                                            Nonaktifkan
                                        </button>
                                        @endif
                                    </div>
                                </td>

                                {{-- Ganti Role --}}
                                <td class="py-3 px-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <form method="POST" action="{{ route('dashboard.users.update-role', $user) }}">
                                            @csrf
                                            @method('PATCH')

                                            <select name="role"
                                                onchange="this.form.submit()"
                                                class="w-full min-w-[110px] px-3 py-1.5 text-xs font-medium rounded-md border border-gray-300 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Footer Pagination --}}
                <div class="flex flex-col md:flex-row justify-between items-center mt-4 gap-3 text-sm text-gray-500">
                    <span>{{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} data</span>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>