<section class="space-y-6">

    <!-- Header -->
    <header class="bg-blue-50 border border-blue-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-blue-700 flex items-center gap-2">
            <i class="fa-solid fa-key text-blue-600"></i>
            Update Password
        </h2>

        <p class="mt-1 text-sm text-blue-700">
            Ensure your account uses a strong and secure password.
        </p>
    </header>

    <!-- Form -->
    <form method="post" action="{{ route('password.update') }}" class="bg-white p-6 rounded-xl shadow-sm border border-blue-100 mt-4 space-y-5">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="font-medium text-gray-700">Current Password</label>
            <input 
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 w-full rounded-lg border border-blue-200 focus:ring-blue-400 focus:border-blue-400"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="font-medium text-gray-700">New Password</label>
            <input 
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 w-full rounded-lg border border-blue-200 focus:ring-blue-400 focus:border-blue-400"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="font-medium text-gray-700">Confirm Password</label>
            <input 
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 w-full rounded-lg border border-blue-200 focus:ring-blue-400 focus:border-blue-400"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Save Button & Status -->
        <div class="flex items-center gap-4">

            <button 
                class="bg-blue-500 text-white px-5 py-2.5 rounded-lg shadow hover:bg-blue-600 transition-all font-semibold"
            >
                Save
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-blue-600 font-medium"
                >
                    Saved.
                </p>
            @endif
        </div>
    </form>

</section>
