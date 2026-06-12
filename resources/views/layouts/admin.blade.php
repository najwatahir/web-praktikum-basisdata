<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin' }} — Praktikum Basis Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
{{-- Mengganti warna seleksi teks ke HMTI Gold --}}
<body class="bg-[#09090b] text-gray-100 font-sans antialiased selection:bg-[#D4A853]/30">

<div class="flex min-h-screen relative overflow-hidden">

    {{-- Aksen blur latar belakang diubah ke HMTI Gold --}}
    <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-[#D4A853]/5 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Sidebar (Premium Dark Mode) --}}
    <aside class="w-64 bg-[#111113] border-r border-white/5 flex flex-col fixed h-full z-20 shadow-2xl">
        {{-- Logo Area --}}
        <div class="px-6 py-6 border-b border-white/5 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#D4A853]/5 to-transparent pointer-events-none"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                {{-- Logo DB Mastery menggunakan skema HMTI Gold --}}
                <div class="w-8 h-8 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/20 flex items-center justify-center text-[#D4A853]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                </div>
                <div>
                    <h2 class="font-extrabold text-sm tracking-tight text-gray-200"><span class="text-[#D4A853]">BASDAT</span> Admin</h2>
                </div>
            </div>
        </div>

        {{-- Menu Navigasi dengan Efek Hover Halus --}}
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
            <p class="px-3 text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">Main Menu</p>
            
            {{-- Seluruh indikator menu aktif diubah ke HMTI Gold --}}
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/20' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5 border border-transparent' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-[#D4A853]' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('admin.rekap') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.rekap') ? 'bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/20' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5 border border-transparent' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.rekap') ? 'text-[#D4A853]' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Rekap Nilai
            </a>

            <a href="{{ route('admin.students') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.students') ? 'bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/20' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5 border border-transparent' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.students') ? 'text-[#D4A853]' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Daftar Praktikan
            </a>
            
            <a href="{{ route('admin.submissions') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.submissions') ? 'bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/20' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5 border border-transparent' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.submissions') ? 'text-[#D4A853]' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Submissions
            </a>
            
            <a href="{{ route('admin.questions.index') }}"
               class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
                      {{ request()->routeIs('admin.questions.*') ? 'bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/20' : 'text-gray-400 hover:text-gray-200 hover:bg-white/5 border border-transparent' }}">
                <svg class="w-4 h-4 {{ request()->routeIs('admin.questions.*') ? 'text-[#D4A853]' : 'text-gray-500 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Kelola Soal
            </a>

            <div class="pt-4 mt-2 border-t border-white/5">
                <p class="px-3 text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-3">External</p>
                <a href="{{ route('leaderboard') }}"
                   class="group flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-gray-200 hover:bg-white/5 transition-all duration-200 border border-transparent"
                   target="_blank">
                    <div class="flex items-center gap-3">
                        <svg class="w-4 h-4 text-amber-500/70 group-hover:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Leaderboard
                    </div>
                    <svg class="w-3.5 h-3.5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </nav>

        {{-- User Identity + Logout Area --}}
        <div class="p-4 border-t border-white/5 bg-[#09090b]/50">
            <div class="flex items-center gap-3 px-2 mb-4">
                <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-xs font-bold text-emerald-400 border border-emerald-500/30">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-medium text-gray-200 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-emerald-500/80 font-mono">System Administrator</p>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" class="w-full m-0 p-0">
                @csrf
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-rose-400 bg-rose-500/5 hover:bg-rose-500/10 border border-rose-500/10 hover:border-rose-500/20 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 ml-64 flex flex-col relative z-10 min-h-screen">
        
        {{-- Glassmorphism Topbar --}}
        <header class="sticky top-0 z-30 bg-[#09090b]/80 backdrop-blur-xl border-b border-white/5 px-8 py-4 flex items-center justify-between transition-all duration-300">
            <h1 class="text-xl font-bold text-gray-100 tracking-tight">{{ $title ?? 'Dashboard' }}</h1>
            
            <div class="flex items-center gap-6">
                <div class="hidden md:flex items-center gap-2 text-xs text-gray-500 font-mono">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ now()->format('d M Y') }} • UTC+8
                </div>
                
                <div class="h-4 w-px bg-white/10 hidden md:block"></div>
                
                <div class="flex items-center gap-2 bg-[#111113] border border-white/5 px-3 py-1.5 rounded-md shadow-sm">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-mono font-medium text-emerald-500/80 uppercase tracking-widest">Admin Mode</span>
                    <span class="text-[10px] font-mono font-medium text-emerald-500/80 uppercase tracking-widest">Admin Mode</span>
                </div>
            </div>
        </header>

        {{-- Slot Content --}}
        <main class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<style>
    /* Styling Scrollbar khusus Sidebar agar selaras dengan desain SaaS */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
</style>

</body>
</html>