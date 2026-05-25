<x-app-layout>
    <x-slot name="title">Daftar Soal</x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Daftar Soal</h1>
                <p class="text-gray-400 mt-2">Halo, <span class="font-semibold text-gray-200">{{ session('nama') }}</span> <span class="mx-1.5 text-gray-700">•</span> Kelompok {{ session('kelompok') }}</p>
            </div>
            
            <div class="hidden md:block bg-gray-800/30 border border-gray-700/50 rounded-lg px-4 py-2.5 text-xs text-gray-400 italic max-w-xs text-right">
                "Saya akan lawan!!!"
            </div>
        </div>

        {{-- Stats (Berdasarkan variabel asli) --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-[#111113] rounded-2xl border border-gray-800 p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/5 rounded-full blur-xl pointer-events-none"></div>
                <p class="text-sm text-gray-500 mb-1 font-medium tracking-wide">Total Soal</p>
                <p class="text-4xl font-extrabold text-white">{{ $questions->count() }}</p>
            </div>
            <div class="bg-[#111113] rounded-2xl border border-gray-800 p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl pointer-events-none"></div>
                <p class="text-sm text-gray-500 mb-1 font-medium tracking-wide">Sudah Dijawab</p>
                <p class="text-4xl font-extrabold text-emerald-400">{{ count($solved) }}</p>
            </div>
            <div class="bg-[#111113] rounded-2xl border border-gray-800 p-6 shadow-sm relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-500/5 rounded-full blur-xl pointer-events-none"></div>
                <p class="text-sm text-gray-500 mb-1 font-medium tracking-wide">Belum Dijawab</p>
                <p class="text-4xl font-extrabold text-white">{{ $questions->count() - count($solved) }}</p>
            </div>
        </div>

        {{-- Daftar Soal (Berdasarkan loop asli) --}}
        <div class="grid gap-4">
            @forelse($questions as $question)
                @php $isSolved = in_array($question->id, $solved); @endphp
                <a href="{{ route('questions.solve', $question->id) }}"
                   class="group bg-[#111113] rounded-2xl border transition-all duration-300 hover:shadow-lg hover:-translate-y-1 p-6 flex flex-col sm:flex-row sm:items-center justify-between
                          {{ $isSolved ? 'border-emerald-500/30 bg-emerald-500/5' : 'border-gray-800 hover:border-indigo-500/40 hover:bg-[#151518]' }}">
                    
                    <div class="flex items-center gap-5 mb-4 sm:mb-0">
                        {{-- Nomor dengan Glassmorphism Accents --}}
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0 transition-colors duration-300
                                    {{ $isSolved ? 'bg-emerald-500/20 text-emerald-400' : 'bg-gray-800/80 text-gray-400 border border-gray-700/50 group-hover:bg-indigo-500/20 group-hover:text-indigo-400 group-hover:border-indigo-500/30' }}">
                            {{ $question->urutan }}
                        </div>
                        <div>
                            <h2 class="font-semibold text-lg text-gray-200 group-hover:text-white transition-colors">{{ $question->judul }}</h2>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-1 group-hover:text-gray-400 transition-colors">{{ $question->deskripsi }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 flex-shrink-0">
                        <span class="text-sm font-semibold text-gray-400 bg-gray-800/50 px-3 py-1.5 rounded-lg border border-gray-700/50">
                            {{ $question->poin }} <span class="font-medium text-gray-500">poin</span>
                        </span>
                        
                        @if($isSolved)
                            <span class="flex items-center gap-1.5 text-sm px-4 py-1.5 rounded-lg font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                Selesai
                            </span>
                        @else
                            <span class="flex items-center gap-1.5 text-sm px-4 py-1.5 rounded-lg font-bold text-gray-400 bg-gray-800 border border-gray-700 group-hover:text-indigo-400 group-hover:bg-indigo-500/10 group-hover:border-indigo-500/30 transition-colors duration-300">
                                Mulai
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="text-center py-20 bg-[#111113] rounded-2xl border border-gray-800 border-dashed">
                    <div class="w-16 h-16 mx-auto bg-gray-800 rounded-2xl flex items-center justify-center text-gray-500 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <p class="text-xl font-semibold text-gray-300">Belum ada soal tersedia.</p>
                    <p class="text-sm text-gray-500 mt-2">Silakan tunggu hingga modul ditambahkan ke database.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>