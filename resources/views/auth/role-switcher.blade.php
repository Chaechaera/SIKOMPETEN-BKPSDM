<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Switch User - SIKOMPETEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 py-12 px-4">

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#FFA41B] mb-2">🔄 Switch User (DEV MODE)</h1>
                <p class="text-gray-600">Pilih user untuk login tanpa perlu logout. Fitur ini hanya tersedia dalam mode development.</p>
            </div>

            <!-- Current User Info -->
            @auth
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <p class="text-sm text-gray-600">Currently logged in as:</p>
                <p class="text-lg font-semibold text-blue-900">
                    {{ Auth::user()->nama }} ({{ Auth::user()->role }})
                </p>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            @endauth

            <!-- User List Form -->
            <form method="POST" action="{{ route('dev.switch-user-store') }}">
                @csrf

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Pilih user untuk login:</label>
                    
                    @foreach ($users as $user)
                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-400 cursor-pointer transition-colors 
                        {{ $user->id == $userID ? 'bg-blue-50 border-blue-400' : 'bg-gray-50' }}">
                        <input type="radio" name="user_id" value="{{ $user->id }}" 
                            class="w-4 h-4 text-blue-600"
                            {{ $user->id == $userID ? 'checked' : '' }} />
                        
                        <div class="ml-4 flex-1">
                            <div class="font-semibold text-gray-900">{{ $user->nama }}</div>
                            <div class="text-sm text-gray-500">
                                <span class="px-2 py-1 rounded text-xs bg-gray-200">
                                    @switch($user->role)
                                        @case('superadmin')
                                            🔴 BKPSDM (Superadmin)
                                            @break
                                        @case('admin')
                                            🟠 OPD (Admin)
                                            @break
                                        @default
                                            🟢 User
                                    @endswitch
                                </span>
                                <span class="ml-2 text-gray-400">{{ $user->email }}</span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <!-- Button -->
                <div class="mt-8 flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-colors">
                        Switch to Selected User
                    </button>
                    <a href="/" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-3 rounded-lg transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Test Credentials Info -->
            <div class="mt-12 pt-8 border-t border-gray-200">
                <h2 class="text-lg font-bold text-gray-900 mb-4">📝 Test Credentials</h2>
                <div class="space-y-3 text-sm">
                    <div class="bg-yellow-50 border border-yellow-200 rounded p-4">
                        <p class="font-semibold text-yellow-900">Semua test user menggunakan password:</p>
                        <p class="text-lg font-mono text-red-600 mt-1">password123</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="font-semibold text-gray-900 mb-2">🔴 BKPSDM (Superadmin)</h3>
                            <p class="text-gray-600">superadmin@bkpsdm.local</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="font-semibold text-gray-900 mb-2">🟠 OPD - Dinas Pendidikan</h3>
                            <p class="text-gray-600">admin.pendidikan@opd.local</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="font-semibold text-gray-900 mb-2">🟠 OPD - Dinas Kesehatan</h3>
                            <p class="text-gray-600">admin.kesehatan@opd.local</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="font-semibold text-gray-900 mb-2">🟢 User Peserta</h3>
                            <p class="text-gray-600">peserta@example.local</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
