<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIKOMPETEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#1C1F4A] text-gray-800 px-4">

    <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-between bg-transparent">

        <!-- Left Section -->
        <div class="text-white max-w-md mb-10 md:mb-0">
            <img 
                src="{{ asset('images/logo-bkpsdm.png') }}" 
                alt="Logo BKPSDM" 
                class="w-36 mb-0" 
            />
            <h1 class="text-3xl font-bold tracking-wide mt-0">SIKOMPETEN</h1>
            <p class="text-lg font-semibold mb-6">Sistem Pengembangan Kompetensi ASN</p>
            <p class="text-sm text-gray-300 leading-relaxed">
                Sistem yang membantu mempermudah proses pengajuan dan pengembangan kompetensi ASN.
            </p>
            <div class="mt-6 flex gap-2">
                <span class="h-1 w-6 bg-white rounded"></span>
                <span class="h-1 w-2 bg-white/40 rounded"></span>
                <span class="h-1 w-2 bg-white/40 rounded"></span>
            </div>
        </div>

        <!-- Right Section (Backend Form Tetap) -->
        <div class="bg-white w-full md:w-1/2 rounded-2xl p-8 space-y-6 shadow-lg">

            <h2 class="text-2xl font-bold text-center text-gray-800">
                Selamat Datang
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1" />
                    <x-text-input
                        id="email"
                        class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#6F3BF5]"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium mb-1" />

                    <div class="relative">
                        <x-text-input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#6F3BF5]"
                        />

                        <!-- Toggle Password -->
                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-4 top-2.5 text-gray-400 hover:text-gray-600"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                                        8.268 2.943 9.542 7-1.274 4.057-5.065 
                                        7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                </div>

                <!-- Remember + Forgot -->
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[#6F3BF5] hover:underline">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="flex justify-center">
                    <x-primary-button
                        class="px-20 py-2 rounded-lg bg-[#FFA41B] text-white font-semibold hover:bg-[#ff9600] transition">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>

    <!-- Password Toggle JS -->
    <script>
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        const eyeOpen = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                8.268 2.943 9.542 7-1.274 
                4.057-5.065 7-9.542 7-4.477 
                0-8.268-2.943-9.542-7z" />
            </svg>`;

        const eyeClosed = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M3 3l18 18M9.88 9.88A3 3 0 0112 9c1.657 0 
                3 1.343 3 3 0 .74-.268 1.42-.713 
                1.94M6.1 6.1C4.03 7.39 
                2.5 9.47 2.458 12c1.274 4.057 
                5.065 7 9.542 7 1.42 0 2.77-.26 
                4.01-.73M15.88 15.88A3 3 
                0 0012 15c-1.657 0-3-1.343-3-3 
                0-.74.268-1.42.713-1.94"/>
            </svg>`;

        let showPassword = false;
        togglePassword.addEventListener("click", () => {
            showPassword = !showPassword;
            passwordInput.type = showPassword ? "text" : "password";
            togglePassword.innerHTML = showPassword ? eyeClosed : eyeOpen;
        });
    </script>

</body>
</html>

