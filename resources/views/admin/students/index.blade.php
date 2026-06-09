<x-app-layout>
    <x-slot name="title">Daftar Mahasiswa - Leaderboard</x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}"
               class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6 relative">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Data Peserta Praktikum
                </div>
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-500 tracking-tight">
                    Daftar Mahasiswa
                </h1>
                <p class="text-gray-400 mt-2 text-sm">Peringkat dan data peserta berdasarkan total skor modul.</p>
            </div>

            <div class="flex items-center gap-2 bg-[#111113] border border-white/5 px-4 py-2.5 rounded-xl shadow-lg relative z-10">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="font-mono text-xs font-medium text-emerald-500/80 uppercase tracking-wider">Live Sync (30s)</span>
            </div>
        </div>

        <div class="mb-6 bg-[#111113] border border-gray-800 p-4 rounded-2xl shadow-sm relative z-10">
            <form action="{{ route('admin.students') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">

                <div class="flex-1 w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." 
                           class="w-full pl-11 pr-4 py-2.5 bg-gray-900 border border-gray-700 rounded-xl text-sm text-white focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>

                <div class="w-full sm:w-56">
                    <select name="kelompok" onchange="this.form.submit()" 
                            class="w-full px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-xl text-sm text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition-colors cursor-pointer">
                        <option value="">Semua Kelompok</option>
                        @foreach($kelompoks as $k)
                            <option value="{{ $k }}" {{ request('kelompok') == $k ? 'selected' : '' }}>Kelompok {{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex w-full sm:w-auto gap-2">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-xl transition duration-200 text-sm">
                        Cari
                    </button>
                    
                    @if(request('search') || request('kelompok'))
                        <a href="{{ route('admin.students') }}" class="w-full sm:w-auto px-4 py-2.5 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white font-medium rounded-xl transition duration-200 text-sm text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl overflow-hidden relative">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#18181b] border-b border-white/5">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest w-20 text-center">Rank</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Peserta</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">NIM</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Kelompok</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Solved</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($students as $index => $row)
                            @php
                                $rank = ($students->currentPage() - 1) * $students->perPage() + $index + 1;
                                $isMe = session('nim') === $row->nim;
                            @endphp
                            <tr class="transition-colors duration-200 hover:bg-white/[0.02] {{ $isMe ? 'bg-indigo-500/[0.03] relative' : '' }}">
                                
                                <td class="px-6 py-4">
                                    @if($isMe)
                                        <span class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] h-full"></span>
                                    @endif
                                    <div class="flex justify-center">
                                        @if($rank === 1)
                                            <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-500 flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(245,158,11,0.2)]">1</div>
                                        @elseif($rank === 2)
                                            <div class="w-8 h-8 rounded-lg bg-gray-400/10 border border-gray-400/30 text-gray-300 flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(156,163,175,0.2)]">2</div>
                                        @elseif($rank === 3)
                                            <div class="w-8 h-8 rounded-lg bg-amber-700/10 border border-amber-700/30 text-amber-600 flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(180,83,9,0.2)]">3</div>
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gray-800/30 border border-gray-700/50 text-gray-500 flex items-center justify-center font-bold text-sm font-mono">{{ $rank }}</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-400 border border-white/5 flex-shrink-0">
                                            {{ substr($row->nama, 0, 1) }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold {{ $isMe ? 'text-indigo-300' : 'text-gray-200' }}">
                                                {{ $row->nama }}
                                            </span>
                                            @if($isMe)
                                                <span class="text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider bg-indigo-500/20 text-indigo-400 border border-indigo-500/30">
                                                    Kamu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-400 font-mono">
                                    {{ $row->nim }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-400">
                                    <span class="px-2.5 py-1 rounded-lg bg-gray-800/50 border border-gray-700/50 text-xs font-medium">
                                        Kelompok {{ $row->kelompok }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-sm font-bold border border-emerald-500/20">
                                        {{ $row->solved }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#09090b] border border-white/5">
                                        <span class="text-indigo-500">✦</span>
                                        <span class="font-bold text-indigo-400 font-mono">{{ $row->total_score }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">Data tidak ditemukan.</p>
                                        <p class="text-gray-500 text-sm mt-1">Coba sesuaikan kata kunci pencarian atau filter kelompoknya.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->hasPages())
                <div class="px-6 py-4 border-t border-gray-800 bg-[#18181b]">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

    <script>
        const searchInput = document.querySelector('input[name="search"]');
        let reloadTimer = setTimeout(() => location.reload(), 30000);

        searchInput.addEventListener('focus', () => clearTimeout(reloadTimer));
        searchInput.addEventListener('blur', () => {
            reloadTimer = setTimeout(() => location.reload(), 30000);
        });
    </script>
</x-app-layout>