<nav class="bg-blue-600 py-4 text-white mb-6">
    <div class="container mx-auto flex justify-between items-center">

        <a href="/" class="text-xl font-bold">Digital Hospital</a>

        <div class="flex items-center gap-4">
            @auth
                <span>Halo, {{ Auth::user()->name }}</span>

                <a href="/admin/dashboard" class="hover:underline">Dashboard</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-700">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
        </div>

    </div>
</nav>
