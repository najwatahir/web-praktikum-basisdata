<x-admin-layout>
    <x-slot name="title">Semua Submission</x-slot>

    <div class="relative max-w-[90rem] mx-auto py-6">
        
        <div class="absolute top-0 left-20 w-72 h-72 bg-rose-500/5 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Header & Title Area --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 relative z-10">
            <div>
                <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-400 tracking-tight mb-2">
                    Activity & Submissions Log
                </h1>
                <p class="text-gray-500 text-sm font-medium">Pantau riwayat kueri, percobaan, dan status penyelesaian peserta.</p>
            </div>
            
            <div class="flex items-center gap-2 px-3 py-1.5 bg-[#111113] border border-white/5 rounded-lg shadow-sm">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest">
                    {{ $submissions->total() }} Log Entries
                </span>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="bg-[#111113] p-4 rounded-2xl border border-white/5 shadow-lg mb-6 relative z-10">
            <form method="GET" action="{{ route('admin.submissions') }}" class="flex flex-wrap items-center gap-3">
                
                {{-- Filter Kelompok --}}
                <div class="relative flex-1 min-w-[200px]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <select name="kelompok" class="w-full appearance-none text-sm font-medium bg-[#09090b] border border-white/10 text-gray-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all cursor-pointer shadow-sm hover:bg-white/[0.02]">
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

                {{-- Filter Soal --}}
                <div class="relative flex-1 min-w-[250px]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <select name="question_id" class="w-full appearance-none text-sm font-medium bg-[#09090b] border border-white/10 text-gray-200 rounded-xl pl-10 pr-10 py-2.5 focus:outline-none focus:border-indigo-500/50 focus:ring-1 focus:ring-indigo-500/50 transition-all cursor-pointer shadow-sm hover:bg-white/[0.02]">
                        <option value="" class="bg-[#111113]">Semua Soal</option>
                        @foreach($questions as $q)
                            <option value="{{ $q->id }}" {{ $questionId == $q->id ? 'selected' : '' }} class="bg-[#111113]">
                                Soal {{ $q->urutan }} — {{ $q->judul }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex items-center gap-2 text-sm px-5 py-2.5 rounded-xl text-white font-semibold transition-all duration-200 bg-indigo-600 hover:bg-indigo-500 shadow-[0_0_15px_rgba(79,70,229,0.2)] hover:shadow-[0_0_20px_rgba(79,70,229,0.4)]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    
                    @if(request()->has('kelompok') || request()->has('question_id'))
                        <a href="{{ route('admin.submissions') }}" class="flex items-center gap-2 text-sm px-4 py-2.5 rounded-xl text-gray-400 hover:text-gray-200 bg-white/5 hover:bg-white/10 border border-white/5 transition-all duration-200 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel Submissions --}}
        <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl relative z-10 flex flex-col">
            <div class="px-4 py-3 bg-[#18181b] border-b border-white/5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-mono font-medium text-gray-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    System Logs
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-[#18181b]/50 border-b border-white/5">
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Timestamp</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Peserta</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Tim</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Soal</th>
                            <th class="px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap w-1/3">Query Execution</th>
                            <th class="text-center px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Try</th>
                            <th class="text-center px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Outcome</th>
                            <th class="text-right px-5 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest whitespace-nowrap">Pts</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($submissions as $sub)
                            <tr class="hover:bg-white/[0.02] transition-colors duration-200 group">
                                
                                {{-- Waktu --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-gray-300 font-mono text-[11px]">{{ $sub->created_at->format('d/m/Y') }}</span>
                                        <span class="text-gray-500 font-mono text-[10px]">{{ $sub->created_at->format('H:i:s') }} UTC+8</span>
                                    </div>
                                </td>

                                {{-- Peserta --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-200 text-xs">{{ $sub->participant->nama ?? '-' }}</span>
                                        <span class="text-indigo-400/70 font-mono text-[10px]">{{ $sub->participant->nim ?? '-' }}</span>
                                    </div>
                                </td>

                                {{-- Kelompok --}}
                                <td class="px-5 py-4 whitespace-nowrap">
                                    <span class="text-[11px] px-2.5 py-1 rounded-md bg-gray-800/50 border border-gray-700/50 text-gray-400 font-medium">
                                        G-{{ str_pad($sub->participant->kelompok ?? '-', 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>

                                {{-- Soal --}}
                                <td class="px-5 py-4 whitespace-nowrap text-xs">
                                    <span class="font-bold text-gray-300">Q{{ $sub->question->urutan ?? '-' }}</span>
                                </td>

                                {{-- Query --}}
                                <td class="px-5 py-4">
                                    <div class="relative max-w-sm xl:max-w-md">
                                        <div class="bg-[#09090b] border border-white/5 rounded-lg px-3 py-2 text-[11px] text-gray-400 font-mono truncate hover:whitespace-normal hover:overflow-visible hover:z-20 hover:absolute hover:top-1/2 hover:-translate-y-1/2 hover:w-auto hover:min-w-full hover:shadow-2xl hover:bg-[#111113] hover:border-indigo-500/30 transition-all duration-200 cursor-text select-text">
                                            <span class="text-indigo-500/50 mr-2 opacity-50 select-none">>_</span>{{ $sub->query }}
                                        </div>
                                    </div>
                                </td>

                                {{-- Attempt --}}
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-[#09090b] border border-white/5 text-[11px] font-mono text-gray-400 font-bold">
                                        {{ $sub->attempt }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-4 text-center whitespace-nowrap">
                                    @if($sub->is_correct)
                                        <span class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-md font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Accepted
                                        </span>
                                    @elseif($sub->score > 0)
                                        <span class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-md font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            Partial
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[11px] px-2.5 py-1 rounded-md font-bold bg-rose-500/5 text-rose-400/80 border border-rose-500/10">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Rejected
                                        </span>
                                    @endif
                                </td>

                                {{-- Skor --}}
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <span class="font-bold font-mono {{ $sub->score > 0 ? 'text-indigo-400' : 'text-gray-600' }}">
                                        {{ $sub->score }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">Belum ada riwayat submission.</p>
                                        <p class="text-gray-500 text-sm mt-1">Sistem belum mencatat adanya aktivitas pengumpulan kueri.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination Wrapper for Dark Mode --}}
        <div class="mt-6">
            {{-- Laravel default pagination looks best inside a styled container when tailwind CSS handles 'dark' class properly. --}}
            <div class="bg-[#111113] p-4 rounded-xl border border-white/5 shadow-sm text-sm dark-pagination-wrapper">
                {{ $submissions->appends(request()->query())->links() }}
            </div>
        </div>

    </div>

    {{-- Custom Scrollbar CSS & Pagination Override --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #09090b; border-radius: 0 0 1rem 1rem; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; border: 1px solid #09090b; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
        
        /* Ensures Laravel Pagination Text matches Dark Mode */
        .dark-pagination-wrapper nav p, 
        .dark-pagination-wrapper nav span {
            color: #9ca3af; /* gray-400 */
        }
    </style>

</x-admin-layout>