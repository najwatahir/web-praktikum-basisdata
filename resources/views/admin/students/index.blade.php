<x-admin-layout>
    <x-slot name="title">Daftar Praktikan</x-slot>

    <div class="relative max-w-[90rem] mx-auto py-6">
        
        {{-- Aksen blur diubah ke HMTI Gold --}}
        <div class="absolute top-0 right-20 w-72 h-72 bg-[#D4A853]/5 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Header & Dekorasi --}}
        <div class="mb-6 relative z-10">
            <a href="{{ route('admin.dashboard') }}"
               class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#D4A853] transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6 relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/20 text-[#D4A853] text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Peserta Praktikum
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-500 tracking-tight">
                    Daftar Mahasiswa
                </h1>
                <p class="text-gray-400 mt-2 text-sm font-medium">Peringkat dan pencarian data peserta berdasarkan total skor modul.</p>
            </div>

            <div class="flex items-center gap-2 bg-[#111113] border border-white/5 px-4 py-2.5 rounded-xl shadow-sm relative z-10">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="font-mono text-xs font-medium text-emerald-500/80 uppercase tracking-wider">Live Sync (30s)</span>
            </div>
        </div>

        {{-- Section Filter --}}
        <div class="bg-[#111113] p-4 rounded-2xl border border-white/5 shadow-lg mb-6 relative z-10">
            <form action="{{ route('admin.students') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">

                {{-- Input Pencarian --}}
                <div class="flex-1 w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#D4A853]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-[#09090b] border border-white/10 rounded-xl text-sm text-gray-200 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium placeholder-gray-600 shadow-sm">
                </div>

                {{-- Dropdown Kelompok --}}
                <div class="w-full sm:w-56 relative">
                    <select name="kelompok" onchange="this.form.submit()" 
                            class="w-full appearance-none pl-4 pr-10 py-2.5 bg-[#09090b] border border-white/10 rounded-xl text-sm text-gray-200 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all cursor-pointer font-medium shadow-sm hover:bg-white/[0.02]">
                        <option value="" class="bg-[#111113]">Semua Kelompok</option>
                        @foreach($kelompoks as $k)
                            <option value="{{ $k }}" {{ request('kelompok') == $k ? 'selected' : '' }} class="bg-[#111113]">
                                Kelompok {{ str_pad($k, 2, '0', STR_PAD_LEFT) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex w-full sm:w-auto gap-2">
                    <button type="submit" class="flex-1 sm:w-auto flex justify-center items-center gap-2 px-6 py-2.5 bg-[#D4A853] hover:bg-[#9b7c3f] shadow-[0_0_15px_rgba(212,168,83,0.2)] hover:shadow-[0_0_20px_rgba(212,168,83,0.4)] text-black font-semibold rounded-xl transition-all duration-200 text-sm">
                        Cari
                    </button>
                    
                    @if(request('search') || request('kelompok'))
                        <a href="{{ route('admin.students') }}" class="flex-1 sm:w-auto flex justify-center items-center px-4 py-2.5 bg-[#09090b] border border-white/10 hover:bg-white/5 text-gray-300 hover:text-white font-semibold rounded-xl transition-all duration-200 text-sm text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Mahasiswa --}}
        <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl relative z-10 flex flex-col">
            {{-- Aksen Mac Header --}}
            <div class="px-4 py-3 bg-[#18181b] border-b border-white/5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-mono font-medium text-gray-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Student Database
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#18181b]/50 border-b border-white/5">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest w-20 text-center">Rank</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Peserta</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">NIM</th>
                            
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Email</th>
                            
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
                            <tr class="hover:bg-white/[0.02] transition-colors duration-200 group {{ $isMe ? 'bg-[#D4A853]/[0.05] relative' : '' }}">
                                
                                <td class="px-6 py-4">
                                    @if($isMe)
                                        <span class="absolute left-0 top-0 bottom-0 w-1 bg-[#D4A853] shadow-[0_0_10px_rgba(212,168,83,0.5)] h-full"></span>
                                    @endif
                                    <div class="flex justify-center">
                                        @if($rank === 1)
                                            <div class="w-8 h-8 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/30 text-[#D4A853] flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(212,168,83,0.2)]">1</div>
                                        @elseif($rank === 2)
                                            <div class="w-8 h-8 rounded-lg bg-gray-400/10 border border-gray-400/30 text-gray-300 flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(156,163,175,0.2)]">2</div>
                                        @elseif($rank === 3)
                                            <div class="w-8 h-8 rounded-lg bg-orange-700/10 border border-orange-700/30 text-orange-500 flex items-center justify-center font-extrabold text-sm shadow-[0_0_15px_rgba(194,65,12,0.2)]">3</div>
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-gray-800/30 border border-gray-700/50 text-gray-500 flex items-center justify-center font-bold text-sm font-mono">{{ $rank }}</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-[#09090b] flex items-center justify-center text-xs font-bold text-gray-400 border border-white/10 flex-shrink-0">
                                            {{ substr($row->nama, 0, 1) }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold {{ $isMe ? 'text-[#D4A853]' : 'text-gray-200' }}">
                                                {{ $row->nama }}
                                            </span>
                                            @if($isMe)
                                                <span class="text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider bg-[#D4A853]/20 text-[#D4A853] border border-[#D4A853]/30">
                                                    Kamu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-[#D4A853]/70 group-hover:text-[#D4A853] transition-colors font-mono">
                                    {{ $row->nim }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-400">
                                    {{ $row->email ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-400">
                                    <span class="px-2.5 py-1 rounded-lg bg-white/5 border border-white/10 text-xs font-medium">
                                        Kelompok {{ str_pad($row->kelompok, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-sm font-bold border border-emerald-500/20 shadow-sm">
                                        {{ $row->solved }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#09090b] border border-white/5 shadow-inner">
                                        <span class="text-[#D4A853]/70 text-xs">✦</span>
                                        <span class="font-extrabold text-[#D4A853] font-mono tracking-tight">{{ $row->total_score }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
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
                <div class="mt-0">
                    <div class="bg-[#111113] p-4 rounded-b-2xl border-t border-white/5 text-sm dark-pagination-wrapper">
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #09090b; border-radius: 0 0 1rem 1rem; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; border: 1px solid #09090b; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }

        /* Memastikan Navigasi Pagination Laravel Konsisten */
        .dark-pagination-wrapper nav p, 
        .dark-pagination-wrapper nav span {
            color: #9ca3af; 
        }
    </style>

    <script>
        const searchInput = document.querySelector('input[name="search"]');
        let reloadTimer = setTimeout(() => location.reload(), 30000);

        searchInput.addEventListener('focus', () => clearTimeout(reloadTimer));
        searchInput.addEventListener('blur', () => {
            reloadTimer = setTimeout(() => location.reload(), 30000);
        });
    </script>
</x-admin-layout>