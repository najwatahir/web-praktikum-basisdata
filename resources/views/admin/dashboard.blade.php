<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="relative max-w-7xl mx-auto py-6">
        
        {{-- Header & Dekorasi Hal Tidak Penting --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 relative z-10">
            <div>
                <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-400 tracking-tight">
                    Overview Analytics
                </h1>
                <p class="text-gray-500 mt-1.5 text-sm font-medium">Metrik dan akses cepat pengelolaan praktikum.</p>
            </div>
            
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-[#111113] border border-white/5 rounded-lg shadow-sm">
                <svg class="w-4 h-4 text-emerald-500 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">DB Synced</span>
            </div>
        </div>

        {{-- Stats Grid (Modular Card Layout) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-12 relative z-10">
            
            {{-- Total Peserta --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg relative overflow-hidden group hover:border-indigo-500/30 transition-colors duration-300">
                <div class="absolute top-0 right-0 p-16 bg-indigo-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-indigo-500/10 transition-colors"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-md border border-emerald-500/20">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        12%
                    </span>
                </div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1 relative z-10">Total Peserta</p>
                <p class="text-3xl font-extrabold text-white relative z-10">{{ $totalParticipants }}</p>
            </div>

            {{-- Total Kelompok --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg relative overflow-hidden group hover:border-amber-500/30 transition-colors duration-300">
                <div class="absolute top-0 right-0 p-16 bg-amber-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-amber-500/10 transition-colors"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <span class="inline-flex items-center text-[10px] font-bold text-gray-500 bg-gray-800 px-2 py-1 rounded-md border border-gray-700">Active</span>
                </div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1 relative z-10">Total Kelompok</p>
                <p class="text-3xl font-extrabold text-amber-400 relative z-10">{{ $totalKelompok }}</p>
            </div>

            {{-- Total Soal --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg relative overflow-hidden group hover:border-emerald-500/30 transition-colors duration-300">
                <div class="absolute top-0 right-0 p-16 bg-emerald-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-emerald-500/10 transition-colors"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1 relative z-10">Total Soal</p>
                <p class="text-3xl font-extrabold text-white relative z-10">{{ $totalQuestions }}</p>
            </div>

            {{-- Total Submission --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg relative overflow-hidden group hover:border-rose-500/30 transition-colors duration-300">
                <div class="absolute top-0 right-0 p-16 bg-rose-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none group-hover:bg-rose-500/10 transition-colors"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div class="flex items-end gap-0.5 h-6 opacity-60">
                        <div class="w-1.5 h-3 bg-rose-500/40 rounded-sm"></div>
                        <div class="w-1.5 h-4 bg-rose-500/50 rounded-sm"></div>
                        <div class="w-1.5 h-2 bg-rose-500/30 rounded-sm"></div>
                        <div class="w-1.5 h-5 bg-rose-500/70 rounded-sm"></div>
                        <div class="w-1.5 h-6 bg-rose-500 rounded-sm"></div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mb-1 relative z-10">Total Submission</p>
                <p class="text-3xl font-extrabold text-white relative z-10">{{ $totalSubmissions }}</p>
            </div>
        </div>

        {{-- Section Divider & Header --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-100 tracking-tight">Quick Actions</h2>
            <div class="h-px bg-white/5 flex-1 ml-6 hidden sm:block"></div>
        </div>

        {{-- Menu Cards (Quick Actions) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
            
            {{-- Rekap Nilai --}}
            <a href="{{ route('admin.rekap') }}"
               class="group relative bg-[#111113] rounded-2xl border border-white/5 p-6 hover:border-indigo-500/40 hover:bg-white/[0.02] transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between min-h-[160px]">
                <div class="absolute right-0 bottom-0 p-24 bg-indigo-500/5 rounded-full blur-3xl -mr-16 -mb-16 pointer-events-none group-hover:bg-indigo-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-gray-800/80 border border-gray-700/50 flex items-center justify-center text-gray-400 group-hover:text-indigo-400 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/20 transition-all mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-200 group-hover:text-white transition-colors mb-1.5">Rekap Nilai</h2>
                    <p class="text-sm text-gray-500 group-hover:text-gray-400 transition-colors">Pantau dan filter akumulasi skor seluruh kelompok.</p>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300">
                    Akses Modul <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>

            {{-- Semua Submission --}}
            <a href="{{ route('admin.submissions') }}"
               class="group relative bg-[#111113] rounded-2xl border border-white/5 p-6 hover:border-rose-500/40 hover:bg-white/[0.02] transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between min-h-[160px]">
                <div class="absolute right-0 bottom-0 p-24 bg-rose-500/5 rounded-full blur-3xl -mr-16 -mb-16 pointer-events-none group-hover:bg-rose-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-gray-800/80 border border-gray-700/50 flex items-center justify-center text-gray-400 group-hover:text-rose-400 group-hover:bg-rose-500/10 group-hover:border-rose-500/20 transition-all mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-200 group-hover:text-white transition-colors mb-1.5">Semua Submission</h2>
                    <p class="text-sm text-gray-500 group-hover:text-gray-400 transition-colors">Tinjau log kueri SQL dan aktivitas pengumpulan peserta.</p>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-rose-400 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300">
                    Akses Modul <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>

            {{-- Kelola Soal --}}
            <a href="{{ route('admin.questions.index') }}"
               class="group relative bg-[#111113] rounded-2xl border border-white/5 p-6 hover:border-emerald-500/40 hover:bg-white/[0.02] transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between min-h-[160px]">
                <div class="absolute right-0 bottom-0 p-24 bg-emerald-500/5 rounded-full blur-3xl -mr-16 -mb-16 pointer-events-none group-hover:bg-emerald-500/10 transition-colors"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-xl bg-gray-800/80 border border-gray-700/50 flex items-center justify-center text-gray-400 group-hover:text-emerald-400 group-hover:bg-emerald-500/10 group-hover:border-emerald-500/20 transition-all mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-200 group-hover:text-white transition-colors mb-1.5">Kelola Soal</h2>
                    <p class="text-sm text-gray-500 group-hover:text-gray-400 transition-colors">Konfigurasi tantangan SQL, rubrik poin, dan skema *database*.</p>
                </div>
                <div class="mt-4 flex items-center text-xs font-semibold text-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300">
                    Akses Modul <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </div>
            </a>

        </div>
    </div>
</x-admin-layout>