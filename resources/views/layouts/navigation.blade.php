<nav class="bg-white border-b border-gray-200 px-6 py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('questions.index') }}" class="text-lg font-bold text-gray-900">
                Praktikum Basis Data
            </a>
        </div>

        <div class="flex items-center gap-4 text-sm">
            @if(session('nim'))
                <span class="text-gray-500">{{ session('nama') }}</span>
                <span class="text-gray-400">|</span>
                <a href="{{ route('leaderboard') }}"
                   class="text-gray-600 hover:text-gray-900 transition">
                    Leaderboard
                </a>
                <form method="POST" action="{{ route('participant.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                        Keluar
                    </button>
                </form>
            @elseif(Auth::check())
                <span class="text-gray-500">{{ Auth::user()->name }}</span>
                <span class="text-gray-400">|</span>
                <a href="{{ route('admin.dashboard') }}"
                   class="text-gray-600 hover:text-gray-900 transition">
                    Admin Panel
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                        Keluar
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>