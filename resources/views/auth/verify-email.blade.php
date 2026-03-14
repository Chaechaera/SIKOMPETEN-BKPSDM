<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-6">
        <div class="max-w-lg w-full bg-white rounded-xl shadow-lg p-8 text-center">
            <h1 class="text-3xl font-bold text-[#2B3674] mb-4">
                Terima kasih telah mendaftar!
            </h1>

            <p class="text-gray-600 mb-6 leading-relaxed">
                Sebelum dapat masuk ke sistem, silakan verifikasi alamat e‑mail
                Anda dengan mengklik tautan yang kami kirimkan ke kotak
                masuk Anda. Jika Anda tidak menerima pesan, gunakan 
                tombol di bawah untuk mengirim ulang.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-green-600">
                    {{ __('Sebuah tautan verifikasi baru telah dikirim ke alamat e-mail Anda.') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full sm:w-auto bg-[#FFA41B] text-white py-2 px-6 rounded-lg hover:opacity-90 transition">
                        {{ __('Kirim Ulang E‑mail Verifikasi') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full sm:w-auto bg-gray-300 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                        {{ __('Keluar') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>