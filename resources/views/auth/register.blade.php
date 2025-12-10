<x-guest-layout>
    <h2 class="text-2xl font-bold text-white text-center mb-2">Buat Akun Baru</h2>
    <p class="text-gray-300 text-center mb-6 text-sm">Daftar untuk mulai membuat janji temu</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-medium text-sm text-gray-200 mb-1">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none" 
                   type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Budi Santoso" />
            @error('name')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block font-medium text-sm text-gray-200 mb-1">Email</label>
            <input id="email" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none" 
                   type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
            @error('email')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block font-medium text-sm text-gray-200 mb-1">Password</label>
            <input id="password" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none"
                   type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            @error('password')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-200 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-lg px-4 py-3 input-modern text-gray-800 placeholder-gray-400 focus:outline-none"
                   type="password" name="password_confirmation" required placeholder="Ulangi password di atas" />
            @error('password_confirmation')
                <span class="text-red-300 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold rounded-lg shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                DAFTAR SEKARANG
            </button>
        </div>

        <div class="mt-6 text-center border-t border-gray-500/30 pt-4">
            <p class="text-sm text-gray-300">Sudah punya akun?</p>
            <a href="{{ route('login') }}" class="text-pink-300 hover:text-white font-bold transition">
                Masuk di sini
            </a>
        </div>
    </form>
</x-guest-layout>