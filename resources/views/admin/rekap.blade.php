<x-admin-layout>
    <x-slot name="title">Rekap Nilai</x-slot>

    <div class="relative max-w-[90rem] mx-auto py-6">
        
        <div class="absolute top-0 right-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Header & Filter Area --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 relative z-10">
            <div>
                <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-400 tracking-tight mb-2">
                    Distribusi Nilai Peserta
                </h1>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-800/50 border border-gray-700/50 text-xs font-medium text-gray-400">
                        <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        {{ $rekap->count() }} Peserta Aktif
                    </span>
                    {{-- <span class="text-gray-600 text-sm">•</span>
                    <span class="text-sm font-medium text-gray-400">
                        {{ $kelompok ? 'Filter: Kelompok ' . $kelompok : 'Filter: Semua Kelompok' }}
                    </span> --}}
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                {{-- <button type="button" class="hidden md:flex items-center gap-2 px-4 py-2 bg-[#111113] border border-white/5 hover:bg-white/5 rounded-lg text-sm font-medium text-gray-300 transition-colors duration-200 shadow-sm cursor-not-allowed opacity-80">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export CSV
                </button> --}}

                <form method="GET" action="{{ route('admin.rekap') }}" class="flex items-center">
                    <div class="relative">
                        <select name="kelompok" onchange="this.form.submit()"
                                class="appearance-none text-sm font-medium bg-[#111113] border border-white/10 text-gray-200 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all cursor-pointer shadow-sm hover:bg-white/[0.02]">
                            <option value="" class="bg-[#111113]">Semua Kelompok</option>
                            @foreach($kelompoks as $k)
                                <option value="{{ $k }}" {{ $kelompok == $k ? 'selected' : '' }} class="bg-[#111113]">
                                    Kelompok {{ str_pad($k, 2, '0', STR_PAD_LEFT) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Rekapitulasi (Modular Card) --}}
        <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl relative z-10 flex flex-col">
            <div class="px-4 py-3 bg-[#18181b] border-b border-white/5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-mono font-medium text-emerald-500/80 uppercase tracking-widest">
                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                    Data Integrity: Verified
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-[#18181b]/50 border-b border-white/5">
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap w-12">No</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">NIM</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap min-w-[150px]">Nama Peserta</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Tim</th>
                            @foreach($questions as $q)
                                <th class="text-center px-4 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">
                                    Q{{ $q->urutan }}
                                </th>
                            @endforeach
                            <th class="text-right px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Total</th>
                            <th class="text-center px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($rekap as $index => $row)
                            <tr class="hover:bg-white/[0.02] transition-colors duration-200 group">
                                <td class="px-5 py-3.5 text-gray-500 text-xs font-mono">{{ $index + 1 }}</td>
                                <td class="px-5 py-3.5 font-mono text-xs text-indigo-300/70 group-hover:text-indigo-300 transition-colors">{{ $row->nim }}</td>
                                <td class="px-5 py-3.5 font-semibold text-gray-200">{{ $row->nama }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="text-xs px-2.5 py-1 rounded-md bg-gray-800/50 border border-gray-700/50 text-gray-400 font-medium whitespace-nowrap">
                                        G-{{ str_pad($row->kelompok, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- Logika Loop Skor Tetap Sama --}}
                                @foreach($questions as $q)
                                    @php
                                        $score = 0;
                                        if (isset($scorePerSoal[$row->nim])) {
                                            $s = $scorePerSoal[$row->nim]->firstWhere('question_id', $q->id);
                                            if ($s) $score = $s->score;
                                        }
                                        if ($score == 0 && isset($partialScore[$row->nim])) {
                                            $s = $partialScore[$row->nim]->firstWhere('question_id', $q->id);
                                            if ($s) $score = $s->score;
                                        }
                                    @endphp
                                    <td class="px-4 py-3.5 text-center">
                                        @if($score == 100)
                                            <span class="inline-flex items-center justify-center min-w-[32px] text-[11px] font-bold px-2 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-sm">
                                                {{ $score }}
                                            </span>
                                        @elseif($score > 0)
                                            <span class="inline-flex items-center justify-center min-w-[32px] text-[11px] font-bold px-2 py-1 rounded-md bg-amber-500/10 text-amber-500 border border-amber-500/20 shadow-sm">
                                                {{ $score }}
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-600 font-bold">—</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td class="px-5 py-3.5 text-right">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <span class="text-indigo-500/70 text-xs">✦</span>
                                        <span class="font-extrabold text-base text-indigo-400 font-mono tracking-tight">
                                            {{ $row->total_score }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-5 py-3.5 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md bg-[#09090b] border border-white/5">
                                        <span class="text-[11px] font-bold text-gray-300 font-mono">{{ $row->solved }}</span>
                                        <span class="text-[10px] text-gray-600">/</span>
                                        <span class="text-[11px] font-bold text-gray-500 font-mono">{{ $questions->count() }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 6 + $questions->count() }}" class="px-5 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">Belum ada data rekapitulasi.</p>
                                        <p class="text-gray-500 text-sm mt-1">Data peserta akan muncul di sini setelah mereka melakukan submission.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    {{-- Footer Rata-rata Total --}}
                    @if($rekap->count() > 0)
                        <tfoot class="bg-[#18181b] border-t border-white/10 relative z-20">
                            <tr>
                                <td colspan="4" class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest border-r border-white/5">
                                    Rata-Rata Modul (Avg)
                                </td>
                                
                                {{-- Logika Loop Closure Rata-Rata Tetap Sama --}}
                                @foreach($questions as $q)
                                    <td class="px-4 py-4 text-center text-[11px] font-bold text-gray-400 font-mono">
                                        {{ round($rekap->avg(function($r) use ($q, $scorePerSoal, $partialScore) {
                                            $score = 0;
                                            if (isset($scorePerSoal[$r->nim])) {
                                                $s = $scorePerSoal[$r->nim]->firstWhere('question_id', $q->id);
                                                if ($s) $score = $s->score;
                                            }
                                            if ($score == 0 && isset($partialScore[$r->nim])) {
                                                $s = $partialScore[$r->nim]->firstWhere('question_id', $q->id);
                                                if ($s) $score = $s->score;
                                            }
                                            return $score;
                                        })) }}
                                    </td>
                                @endforeach
                                
                                <td class="px-5 py-4 text-right text-sm font-extrabold text-indigo-400 font-mono border-l border-white/5 bg-indigo-500/5">
                                    {{ round($rekap->avg('total_score')) }} <span class="text-[10px] text-indigo-500/50 font-sans uppercase">pts</span>
                                </td>
                                <td class="bg-indigo-500/5"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- Custom Scrollbar CSS for wide tables in dark mode --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 10px; width: 10px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #09090b; border-radius: 0 0 1rem 1rem; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 5px; border: 2px solid #09090b; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

</x-admin-layout>