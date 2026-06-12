<nav
    class="sticky top-0 z-50 bg-[#09090b]/80 backdrop-blur-xl border-b border-white/5 px-6 py-4 transition-all duration-300">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        {{-- Brand / Logo Area --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('questions.index') }}"
                class="group flex items-center gap-3 transition-transform hover:-translate-y-0.5 duration-300">
                {{-- Diubah ke skema warna HMTI Gold --}}
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#D4A853]/20 to-[#9b7c3f]/10 border border-[#D4A853]/20 flex items-center justify-center text-[#D4A853] shadow-[0_0_15px_rgba(212,168,83,0.1)] group-hover:shadow-[0_0_20px_rgba(212,168,83,0.2)] transition-shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                        </path>
                    </svg>
                </div>
                <span
                    class="text-lg font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-400 group-hover:to-gray-200 transition-colors">
                    Praktikum Basis Data
                </span>
            </a>
        </div>

        {{-- User Navigation Area --}}
        <div class="flex items-center gap-2 sm:gap-4 text-sm">
            @if (session('nim'))
                {{-- Participant State --}}
                <div
                    class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-lg bg-[#111113] border border-white/5 shadow-sm">
                    {{-- Avatar diubah ke skema warna HMTI Gold --}}
                    <div
                        class="w-5 h-5 rounded-full bg-[#D4A853]/20 flex items-center justify-center text-[10px] font-bold text-[#D4A853]">
                        {{ substr(session('nama'), 0, 1) }}
                    </div>
                    <span class="font-medium text-gray-300">{{ session('nama') }}</span>
                </div>

                <div class="w-px h-5 bg-gray-800 hidden sm:block mx-1"></div>

                {{-- Hover Leaderboard diubah ke skema warna HMTI Gold --}}
                <a href="{{ route('leaderboard') }}"
                    class="flex items-center gap-1.5 text-gray-400 hover:text-[#D4A853] hover:bg-[#D4A853]/10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Leaderboard
                </a>

                <form method="POST" action="{{ route('participant.logout') }}" class="inline m-0 p-0">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            @elseif(Auth::check())
                {{-- Admin State --}}
                <div
                    class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-lg bg-[#111113] border border-amber-500/10 shadow-sm">
                    <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                    <span class="font-medium text-gray-300">{{ Auth::user()->name }}</span>
                </div>

                <div class="w-px h-5 bg-gray-800 hidden sm:block mx-1"></div>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-1.5 text-gray-400 hover:text-amber-300 hover:bg-amber-500/10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Admin Panel
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 px-3 py-2 rounded-lg transition-all duration-200 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</nav>
