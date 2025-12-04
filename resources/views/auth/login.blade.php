<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-white/80">Email</label> 
            <input id="email" class="input-custom mt-1 block w-full" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-white/80">Password</label>
            <input id="password" class="input-custom mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-white/80">Ingat Saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-white/80 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif

            <button type="submit" class="btn-primary-custom ml-4">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>