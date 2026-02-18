<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard User') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50">
        {{-- Sidebar --}}
        @include('pages.sidebar.user')

        {{-- Konten Utama --}}
        <main class="flex-1 p-6">

            {{-- Header Dashboard --}}
            <h1 class="text-2xl font-bold mb-4">Dashboard User</h1>
            <p>Selamat datang, User!</p>

            {{-- Isi Konten --}}
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            {{ __("You're logged in!") }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
