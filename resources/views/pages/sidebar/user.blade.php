<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>User Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-blue-800 text-white p-4 flex justify-between items-center">
        <div class="font-bold">User Dashboard</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded">Logout</button>
        </form>
    </nav>

    <div class="p-6">
        @yield('content')
    </div>
</body>
</html>
