<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - SIKOMPETEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hilangkan scrollbar (Chrome, Edge, Safari) */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Firefox */
        .hide-scrollbar {
            scrollbar-width: none;
        }
    </style>
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
                Buat Akun Baru
            </h2>

            <!-- Scrollable Form -->
            <div class="max-h-[480px] overflow-y-auto hide-scrollbar space-y-2">

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

                        <!-- Nip -->
                        <div class="md:col-span-2">
                            <x-input-label for="nip" :value="__('NIP')" class="text-sm font-medium mb-1 text-slate-300" />
                            <x-text-input
                                id="nip"
                                type="text"
                                name="nip"
                                :value="old('nip')"
                                required
                                autocomplete="nip"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1" />
                            <x-input-error :messages="$errors->get('nip')" class="mt-1 text-red-500" />
                        </div>

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

                        <!-- Nama -->
                        <div class="md:col-span-2">
                            <x-input-label for="nama" :value="__('Nama')" class="text-sm font-medium mb-1 text-slate-300" />
                            <x-text-input
                                id="nama"
                                type="text"
                                name="nama"
                                :value="old('nama')"
                                required
                                autocomplete="nama"
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1" />
                            <x-input-error :messages="$errors->get('nama')" class="mt-1 text-red-500" />
                        </div>

                        <!-- Sub Unit Kerja -->
                        <div class="md:col-span-2">
                            <x-input-label for="subunitkerja_id" :value="__('Sub Unit Kerja')" class="text-sm font-medium mb-1 text-slate-300" />
                            <select
                                id="subunitkerja_id"
                                name="subunitkerja_id"
                                required
                                class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1">
                                @foreach($subunitkerjas as $s)
                                <option value="{{ $s->id }}">{{ $s->sub_unitkerja }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subunitkerja_id')" class="mt-1 text-red-500" />
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
                                    autocomplete="new-password"
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

                        <!-- Confirm Password -->
                        <div class="md:col-span-2">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium mb-1 text-slate-300" />
                            <div class="relative">
                                <x-text-input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm bg-white/90 focus:ring-1" />
                                <!-- Toggle Password -->
                                <button
                                    type="button"
                                    id="togglePasswordConfirmation"
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
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500" />
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="flex justify-center mb-4">
                        <button
                            class="bg-[#FFA41B] text-white px-6 w-full py-2 rounded-lg text-sm font-semibold hover:bg-[#ff9600] transition">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Already registered -->
            <div class="text-center text-slate-300 font-medium text-sm mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#FFA41B] font-semibold hover:underline cursor-pointer">
                    Login sekarang
                </a>
            </div>
        </div>
    </div>
</body>

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
    const passwordConfirmationInput = document.getElementById("password_confirmation");
    const togglePassword = document.getElementById("togglePassword");
    const togglePasswordConfirmation = document.getElementById("togglePasswordConfirmation");

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

    // ===== PASSWORD =====
    let showPassword = false;
    togglePassword.addEventListener("click", () => {
        showPassword = !showPassword;

        // 👁️ open = terlihat, closed = tersembunyi
        passwordInput.type = showPassword ? "text" : "password";
        togglePassword.innerHTML = showPassword ? eyeClosed : eyeOpen;
    });

    // ===== CONFIRM PASSWORD =====
    let showPasswordConfirm = false;
    togglePasswordConfirmation.addEventListener("click", () => {
        showPasswordConfirm = !showPasswordConfirm;

        passwordConfirmationInput.type = showPasswordConfirm ? "text" : "password";
        togglePasswordConfirmation.innerHTML = showPasswordConfirm ? eyeClosed : eyeOpen;
    });
</script>

</html>