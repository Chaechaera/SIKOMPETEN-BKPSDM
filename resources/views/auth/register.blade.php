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

        <!-- RIGHT SECTION REGISTER FORM -->
<div class="bg-white w-full md:w-1/2 rounded-2xl p-8 shadow-lg">

    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
        Daftar Akun Baru
    </h2>

    <!-- Scrollable Form -->
    <div class="max-h-[420px] overflow-y-auto hide-scrollbar pr-2 space-y-4">

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Nip -->
            <div>
                <x-input-label for="nip" :value="__('NIP')" class="text-sm font-medium mb-1"/>
                <x-text-input 
                    id="nip"
                    type="text"
                    name="nip"
                    :value="old('nip')"
                    required
                    autocomplete="nip"
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                />
                <x-input-error :messages="$errors->get('nip')" class="mt-1 text-red-500" />
            </div>

            <!-- Nama -->
            <div>
                <x-input-label for="nama" :value="__('Nama')" class="text-sm font-medium mb-1"/>
                <x-text-input 
                    id="nama"
                    type="text"
                    name="nama"
                    :value="old('nama')"
                    required
                    autocomplete="nama"
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                />
                <x-input-error :messages="$errors->get('nama')" class="mt-1 text-red-500" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-medium mb-1"/>
                <x-text-input 
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500" />
            </div>

            <!-- Sub Unit Kerja -->
            <div>
                <x-input-label for="subunitkerja_id" :value="__('Sub Unit Kerja')" class="text-sm font-medium mb-1"/>
                <select 
                    id="subunitkerja_id"
                    name="subunitkerja_id"
                    required
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                >
                    @foreach($subunitkerjas as $s)
                        <option value="{{ $s->id }}">{{ $s->sub_unitkerja }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('subunitkerja_id')" class="mt-1 text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-sm font-medium mb-1"/>
                <x-text-input 
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium mb-1"/>
                <x-text-input 
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-[#6F3BF5]"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500" />
            </div>

            <!-- Button -->
            <div class="flex justify-center mb-4">
                <x-primary-button
                    class="px-20 py-2 rounded-lg bg-[#FFA41B] text-white font-semibold hover:bg-[#ff9600] transition">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </form>
    </div>

    <!-- Already registered -->
    <div class="text-center text-sm mt-2">
        <a href="{{ route('login') }}" class="text-[#6F3BF5] hover:underline">
            Sudah punya akun?
        </a>
    </div>

</div>


</body>
</html>
