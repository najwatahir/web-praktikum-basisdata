<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Praktikum Basis Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-56 bg-gray-900 text-white flex flex-col fixed h-full">
        {{-- Logo --}}
        <div class="px-5 py-5 border-b border-gray-700">
            <p class="font-bold text-sm">Praktikum Basis Data</p>
            <p class="text-xs mt-0.5" style="color:#D4A853">ELABORASI 2026</p>
        </div>

        {{-- Menu --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>🏠</span> Dashboard
            </a>
            <a href="{{ route('admin.rekap') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.rekap') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>📊</span> Rekap Nilai
            </a>
            <a href="{{ route('admin.submissions') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.submissions') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>📋</span> Submissions
            </a>
            <a href="{{ route('admin.questions.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition
                      {{ request()->routeIs('admin.questions.*') ? 'bg-gray-700 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <span>📝</span> Kelola Soal
            </a>
            <a href="{{ route('leaderboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition text-gray-400 hover:bg-gray-800 hover:text-white"
               target="_blank">
                <span>🏆</span> Leaderboard
            </a>
        </nav>

        {{-- User + Logout --}}
        <div class="px-4 py-4 border-t border-gray-700">
            <p class="text-xs text-gray-400 mb-1 truncate">{{ Auth::user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-xs text-red-400 hover:text-red-300 transition">
                    Keluar →
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 ml-56">
        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h1 class="font-semibold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
            <span class="text-xs text-gray-400">{{ now()->format('d M Y') }}</span>
        </header>

        {{-- Content --}}
        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
</div>

</body>
</html>