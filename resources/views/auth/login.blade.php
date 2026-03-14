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

        <!-- LEFT SECTION -->
        <div class="text-white max-w-md mb-10 md:mb-20">
            <img
                src="{{ asset('images/logo-bkpsdm.png') }}"
                alt="Logo BKPSDM"
                class="w-40 mb-0" />
            <h1 class="text-4xl font-bold tracking-wide mt-0 text-[#FFA41B]">SIKOMPETEN</h1>
            <p class="text-xl font-semibold mb-4">Sistem Pengembangan Kompetensi ASN</p>
            <p class="text-sm text-gray-300 leading-relaxed">
                Sistem yang membantu mempermudah proses pengajuan, verifikasi, dan pelaporan kegiatan Pengembangan Kompetensi ASN
            </p>
            <div class="mt-6 flex gap-2">
                <span class="h-1 w-6 bg-white rounded"></span>
                <span class="h-1 w-2 bg-white/40 rounded"></span>
                <span class="h-1 w-2 bg-white/40 rounded"></span>
            </div>
        </div>

        <!-- RIGHT SECTION REGISTER FORM -->
        <div class="bg-white/15 w-full md:w-1/2 rounded-2xl p-8 shadow-lg opacity-0 transition-opacity duration-700" id="pageBody">

            <h2 class="text-2xl font-semibold text-center text-[#FFA41B]">
                Selamat Datang Kembali
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Scrollable Form -->
            <div class="max-h-[480px] overflow-y-auto hide-scrollbar space-y-2">

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1 text-slate-300" />
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autocomplete="username"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1" />
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500" />
                        </div>

                        <!-- Password -->
                        <div class="md:col-span-2">
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium mb-1 text-slate-300" />
                            <div class="relative">
                                <x-text-input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1" />
                                <!-- Toggle Password -->
                                <button
                                    type="button"
                                    id="togglePassword"
                                    class="absolute right-4 top-2.5 text-gray-500 hover:text-gray-700">
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
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500" />
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="md:col-span-2 flex justify-between items-center text-sm">
                            <label class="flex items-center text-slate-300 font-medium text-sm gap-2">
                                <span>
                                    <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-gray-300">
                                    Remember me
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[#FFA41B] font-semibold hover:underline cursor-pointer">
                                Forgot Password?
                            </a>
                            @endif
                        </div>
                    </div>
                    <!-- Login Button -->
                    <div class="flex justify-center mb-4">
                        <button
                            class="bg-[#FFA41B] text-white px-6 w-full py-2 rounded-lg text-sm font-semibold hover:bg-[#ff9600] transition">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- You dont have account -->
            <div class="text-center text-slate-300 font-medium text-sm mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#FFA41B] font-semibold hover:underline cursor-pointer">
                    Daftar sekarang
                </a>
            </div>
        </div>
    </div>

    <script>
        // fade in saat load
    window.addEventListener("load", () => {
        document.getElementById("pageBody").classList.remove("opacity-0");
    });

    // fade out saat klik link
    document.querySelectorAll("a[href]").forEach(link => {
        link.addEventListener("click", function(e) {
            const url = this.href;

            // hanya untuk link internal
            if (url && !url.includes("#") && this.target !== "_blank") {
                e.preventDefault();
                document.getElementById("pageBody").classList.add("opacity-0");

                setTimeout(() => {
                    window.location.href = url;
                }, 250);
            }
        });
    });

        // Password Toggle JS 
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