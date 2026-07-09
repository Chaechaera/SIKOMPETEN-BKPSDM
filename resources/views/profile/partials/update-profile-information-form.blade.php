{{-- FORM VERIFICATION --}}
<form id="send-verification" method="POST" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="POST"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data"
      class="bg-white rounded-2xl border border-gray-200 shadow p-6 space-y-6">

    @csrf
    @method('PATCH')

    <h3 class="text-xl font-semibold text-gray-800 border-b pb-3">
        Edit Informasi Akun
    </h3>

    {{-- FOTO PROFIL --}}
    <div class="flex items-center gap-6">

        @if($user->foto)
            <img src="{{ asset('storage/'.$user->foto) }}"
                class="w-24 h-24 rounded-full object-cover border shadow">
        @else
            <img src="{{ asset('images/default-profile.png') }}"
                class="w-24 h-24 rounded-full object-cover border shadow">
        @endif

        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto Profil
            </label>

            <input
                type="file"
                name="foto"
                accept="image/*"
                class="block w-full rounded-lg border border-gray-300 p-2">

            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>

    </div>

    {{-- NAMA --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama
        </label>

        <input
            type="text"
            name="nama"
            value="{{ old('nama', $user->nama) }}"
            class="w-full rounded-lg bg-gray-100 border-gray-300"
            readonly>

        <x-input-error class="mt-2" :messages="$errors->get('nama')" />
    </div>

    {{-- EMAIL --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Email
        </label>

        <input
            type="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

            <div class="mt-3 rounded-lg bg-yellow-50 border border-yellow-200 p-4">

                <p class="text-sm text-yellow-800">
                    Email belum diverifikasi.

                    <button
                        form="send-verification"
                        class="underline font-medium">

                        Kirim ulang email verifikasi

                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')

                    <p class="mt-2 text-sm text-green-600">
                        Link verifikasi berhasil dikirim.
                    </p>

                @endif

            </div>

        @endif

    </div>

    {{-- OPD --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            OPD
        </label>

        <input
            type="text"
            value="{{ $user->subunitkerjas->sub_unitkerja ?? '-' }}"
            readonly
            class="w-full rounded-lg bg-gray-100 border-gray-300">

    </div>

    {{-- BUTTON --}}
    <div class="flex items-center gap-4 pt-2">

        <button
            type="submit"
            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">

            Simpan Perubahan

        </button>

        <button
            type="button"
            onclick="document.getElementById('editInformasi').classList.add('hidden')"
            class="px-6 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-100">

            Batal

        </button>

        @if (session('status') === 'profile-updated')

            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-green-600">

                Berhasil disimpan.

            </p>

        @endif

    </div>

</form>