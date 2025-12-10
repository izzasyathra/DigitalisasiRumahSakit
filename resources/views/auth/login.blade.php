<x-guest-layout>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <h2 class="text-2xl font-bold text-white text-center mb-6">Masuk ke Sistem</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-200 mb-1">Email</label>
            <input id="email" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none" 
                   type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            @error('email')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-200 mb-1">Password</label>
            <input id="password" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none"
                   type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            @error('password')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500" name="remember">
                <span class="ml-2 text-sm text-gray-200">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-pink-300 hover:text-white transition" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                MASUK
            </button>
        </div>

        <div class="mt-6 text-center border-t border-gray-500/30 pt-4">
            <p class="text-sm text-gray-300">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="text-pink-300 hover:text-white font-bold transition">
                Daftar Pasien Baru
            </a>
        </div>
    </form>
</x-guest-layout>