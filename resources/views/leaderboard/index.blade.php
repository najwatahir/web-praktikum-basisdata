<x-app-layout>
    <x-slot name="title">Leaderboard</x-slot>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        {{-- Header & Dekorasi --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 relative">
            {{-- Aksen blur diubah ke HMTI Gold --}}
            {{-- <div class="absolute -top-10 -left-10 w-40 h-40 bg-[#D4A853]/10 rounded-full blur-3xl pointer-events-none"></div> --}}
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/20 text-[#D4A853] text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Global Rankings
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-500 tracking-tight">
                    Leaderboard
                </h1>
                <p class="text-gray-400 mt-2 text-sm">Peringkat peserta berdasarkan total skor dan penyelesaian modul.</p>
            </div>

            <div class="flex items-center gap-2 bg-[#111113] border border-white/5 px-4 py-2.5 rounded-xl shadow-lg relative z-10">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="font-mono text-xs font-medium text-emerald-500/80 uppercase tracking-wider">Live Sync (30s)</span>
            </div>
        </div>

        {{-- Tabel Leaderboard --}}
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
                        @forelse($leaderboard as $index => $row)
                            @php
                                $rank = $index + 1;
                                $isMe = session('nim') === $row->nim;
                            @endphp
                            {{-- Latar baris "Kamu" diubah ke HMTI Gold opacity super rendah --}}
                            <tr class="transition-colors duration-200 hover:bg-white/[0.02] {{ $isMe ? 'bg-[#D4A853]/[0.05] relative' : '' }}">
                                
                                {{-- Border Kiri Khusus User Aktif diubah ke HMTI Gold dengan shadow sesuai RGB-nya --}}
                                @if($isMe)
                                    <td class="absolute left-0 top-0 bottom-0 w-1 bg-[#D4A853] shadow-[0_0_10px_rgba(212,168,83,0.5)] h-full"></td>
                                @endif

                                {{-- Rank / Lencana Juara --}}
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if($rank === 1)
                                            {{-- Rank 1 menggunakan warna HMTI Gold sejati --}}
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

                                {{-- Nama & Badge "Kamu" --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-xs font-bold text-gray-400 border border-white/5 flex-shrink-0">
                                            {{ substr($row->nama, 0, 1) }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            {{-- Sorotan teks jika user adalah "Kamu" --}}
                                            <span class="font-semibold {{ $isMe ? 'text-[#D4A853]' : 'text-gray-200' }}">
                                                {{ $row->nama }}
                                            </span>
                                            @if($isMe)
                                                {{-- Badge "Kamu" disesuaikan ke HMTI Gold --}}
                                                <span class="text-[10px] px-2 py-0.5 rounded-md font-bold uppercase tracking-wider bg-[#D4A853]/20 text-[#D4A853] border border-[#D4A853]/30">
                                                    Kamu
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- NIM --}}
                                <td class="px-6 py-4 text-sm text-gray-400 font-mono">
                                    {{ $row->nim }}
                                </td>

                                {{-- Kelompok --}}
                                <td class="px-6 py-4 text-sm text-gray-400">
                                    <span class="px-2.5 py-1 rounded-lg bg-gray-800/50 border border-gray-700/50 text-xs font-medium">
                                        Tim {{ $row->kelompok }}
                                    </span>
                                </td>

                                {{-- Soal Selesai --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-500/10 text-emerald-400 font-mono text-sm font-bold border border-emerald-500/20">
                                        {{ $row->solved }}
                                    </span>
                                </td>

                                {{-- Total Skor --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#09090b] border border-white/5">
                                        {{-- Ikon bintang & Skor diubah ke warna HMTI Gold --}}
                                        <span class="text-[#D4A853]">✦</span>
                                        <span class="font-bold text-[#D4A853] font-mono">{{ $row->total_score }}</span>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">Belum ada data tersedia.</p>
                                        <p class="text-gray-500 text-sm mt-1">Skor akan muncul di sini setelah peserta mulai mengerjakan modul.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- CSS Kustom & Auto refresh tiap 30 detik --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

    <script>
        setTimeout(() => location.reload(), 30000);
    </script>

</x-app-layout>