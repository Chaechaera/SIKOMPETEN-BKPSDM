<section class="space-y-6">

    <!-- Header -->
    <header class="bg-red-50 border border-red-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-red-700 flex items-center gap-2">
            <i class="fa-solid fa-user-xmark text-red-600"></i>
            Delete Account
        </h2>

        <p class="mt-1 text-sm text-red-600">
            Once your account is deleted, all data will be permanently removed.
            Make sure to download anything you need before continuing.
        </p>
    </header>

    <!-- Delete Button -->
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-500 text-white px-5 py-2.5 rounded-lg shadow hover:bg-red-600 transition-all font-semibold"
    >
        Delete Account
    </button>

    <!-- Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 rounded-xl">
            @csrf
            @method('delete')

            <!-- Modal Card -->
            <div class="bg-white rounded-xl shadow-xl p-6 border border-red-100">
                <h2 class="text-lg font-semibold text-red-700">
                    Are you sure you want to delete your account?
                </h2>

                <p class="mt-2 text-sm text-gray-600">
                    This action is permanent. Please enter your password to confirm.
                </p>

                <!-- Password Input -->
                <div class="mt-6">
                    <label class="sr-only" for="password">Password</label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Password"
                        class="mt-1 block w-full rounded-lg border border-red-200 focus:ring-red-400 focus:border-red-400"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex justify-end gap-3">

                    <!-- Cancel -->
                    <button 
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition"
                    >
                        Cancel
                    </button>

                    <!-- Delete -->
                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 shadow transition"
                    >
                        Delete Account
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

</section>
