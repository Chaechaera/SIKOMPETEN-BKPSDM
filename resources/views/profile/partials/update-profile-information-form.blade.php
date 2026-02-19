<section class="bg-gradient-to-b from-[#F6F2FF] to-[#FFFFFF] p-8 rounded-2xl shadow-sm border border-[#EDE6FF]">

    <header class="mb-6">
        <h2 class="text-2xl font-semibold text-[#5C4A9A]">
            Profile Information
        </h2>

        <p class="mt-1 text-sm text-[#8679C3]">
            Update your account's profile information and email address.
        </p>
    </header>

    {{-- FORM VERIFICATION SEND --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- MAIN FORM --}}
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- NAME --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-[#E6DFFF]">
            <label for="name" class="block text-sm font-medium text-[#5C4A9A] mb-1">
                Name
            </label>

            <input id="name" name="name" type="text"
                   class="w-full px-4 py-2 rounded-lg border border-[#D8CCFF] 
                   focus:ring-2 focus:ring-[#B8A9FF] focus:border-[#B8A9FF] transition"
                   value="{{ old('name', $user->name) }}" required autofocus />

            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- EMAIL --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-[#E6DFFF]">
            <label for="email" class="block text-sm font-medium text-[#5C4A9A] mb-1">
                Email
            </label>

            <input id="email" name="email" type="email"
                   class="w-full px-4 py-2 rounded-lg border border-[#D8CCFF] 
                   focus:ring-2 focus:ring-[#B8A9FF] focus:border-[#B8A9FF] transition"
                   value="{{ old('email', $user->email) }}" required />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- VERIFIKASI EMAIL --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-[#F4ECFF] p-4 rounded-lg border border-[#D9C7FF]">
                    <p class="text-sm text-[#6A55B5]">
                        Your email address is unverified.

                        <button form="send-verification"
                            class="underline text-sm text-[#8571E6] hover:text-[#6C54E0]">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-[#6CCF85]">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- BUTTON / STATUS --}}
        <div class="flex items-center gap-4">
            <button
                class="px-6 py-2.5 bg-[#A796FF] hover:bg-[#917DFF] text-white rounded-xl shadow-md transition">
                Save
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-[#8679C3]"
                >Saved.</p>
            @endif
        </div>
    </form>

</section>
