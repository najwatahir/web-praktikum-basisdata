<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Praktikum Basis Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="relative min-h-screen flex items-center justify-center">

        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('images/hmtiudayana_cover.jpg') }}')">
        </div>

        <div class="absolute inset-0 bg-black/60"></div>

        <div class="relative z-10 w-full max-w-md px-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-wide">Praktikum Basis Data</h1>
                <p class="text-white/70 mt-2 text-sm">HMTI Udayana</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8">

                @if (session('status'))
                    <div class="mb-4 p-3 bg-emerald-500/20 border border-emerald-400/40 rounded-lg">
                        <p class="text-emerald-300 text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-500/20 border border-red-400/40 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-300 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-white/80 text-sm font-medium mb-1" for="email">Email Admin</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="user@gmail.com"
                            required autofocus autocomplete="username"
                            class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-[#D4A853]/70 focus:bg-white/20 transition"
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-white/80 text-sm font-medium mb-1" for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required autocomplete="current-password"
                            class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-[#D4A853]/70 focus:bg-white/20 transition"
                        />
                    </div>

                    <div class="mb-6 flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-400 bg-white/10 text-[#D4A853] focus:ring-[#D4A853] focus:ring-offset-gray-900" name="remember">
                            <span class="ms-2 text-sm text-white/70">Ingat Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-[#D4A853] hover:text-[#9b7c3f] transition" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 bg-[#D4A853] hover:bg-[#9b7c3f] active:scale-95 text-white font-semibold rounded-xl transition duration-200 shadow-lg shadow-[#D4A853]/20"
                    >
                        Login Admin →
                    </button>

                </form>
            </div>

            <p class="text-center text-white/40 text-xs mt-6">
                Inti Praktikum Basis Data © {{ date('Y') }} HMTI Udayana
            </p>
        </div>
    </div>

</body>
</html>