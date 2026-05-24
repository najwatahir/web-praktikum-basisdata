<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Praktikum Basis Data' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-lg font-bold text-gray-900">Praktikum Basis Data</span>
            </div>
            <div class="flex items-center gap-4 text-sm">
                @if(session('nim'))
                    <span class="text-gray-500">{{ session('nama') }}</span>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('leaderboard') }}" class="text-gray-600 hover:text-gray-900 transition">Leaderboard</a>
                    <a href="{{ route('home') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-red-500 hover:text-red-700 transition">Keluar</a>
                    <form id="logout-form" action="{{ route('participant.logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="max-w-6xl mx-auto px-6 py-8">
        {{ $slot }}
    </main>

</body>
</html>