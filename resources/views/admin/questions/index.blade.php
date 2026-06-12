<x-admin-layout>
    <x-slot name="title">Manajemen Soal</x-slot>

    <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Aksen blur latar belakang diubah ke HMTI Gold --}}
        <div class="absolute top-0 right-10 w-64 h-64 bg-[#D4A853]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="mb-6 relative z-10">
            <a href="{{ route('admin.dashboard') }}"
                class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#D4A853] transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 relative z-10">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/20 text-[#D4A853] text-xs font-bold uppercase tracking-widest mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Question Bank
                </div>
                <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-500 tracking-tight">
                    Manajemen Soal
                </h1>
                <p class="text-gray-400 mt-2 text-sm">Kelola daftar soal praktikum dan konfigurasi test case.</p>
            </div>
            <div>
                {{-- Tombol Tambah Soal diubah ke HMTI Gold dengan efek Glow --}}
                <a href="{{ route('admin.questions.create') }}"
                    class="inline-flex items-center bg-[#D4A853] hover:bg-[#9b7c3f] text-black font-bold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(212,168,83,0.3)] hover:shadow-[0_0_25px_rgba(212,168,83,0.5)] hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        {{-- Tabel Soal (Modular Card) --}}
        <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl overflow-hidden relative z-10 flex flex-col">
            
            {{-- Aksen Mac Header --}}
            <div class="px-4 py-3 bg-[#18181b] border-b border-white/5 flex items-center justify-between rounded-t-2xl">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                </div>
                <div class="flex items-center gap-1.5 text-[10px] font-mono font-medium text-gray-500 uppercase tracking-widest">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Database Entries
                </div>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#18181b]/50 border-b border-white/5">
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest w-16 text-center">No</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest">Judul Soal</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Poin</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Test Cases</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest">Tenggat Waktu</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Status</th>
                            <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($questions as $q)
                            <tr class="hover:bg-white/[0.02] transition-colors duration-200 group">
                                <td class="py-4 px-6 text-center">
                                    {{-- Nomor soal mendapat aksen warna Gold saat di-hover --}}
                                    <span class="text-sm font-bold text-gray-500 font-mono group-hover:text-[#D4A853] transition-colors">{{ $q->urutan }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-sm font-bold text-gray-200 group-hover:text-white transition-colors">{{ $q->judul }}</p>
                                    <p class="text-[11px] text-gray-500 mt-1 line-clamp-1 group-hover:text-gray-400">{{ $q->deskripsi }}</p>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center gap-1 bg-[#09090b] border border-white/5 text-gray-300 py-1 px-2.5 rounded-lg text-xs font-mono font-bold">
                                        <span class="text-[#D4A853] text-[10px]">✦</span>
                                        {{ $q->poin }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    {{-- Lencana Test Case menggunakan aksen HMTI Gold --}}
                                    <span class="bg-[#D4A853]/10 text-[#D4A853] py-1 px-3 rounded-md text-xs font-bold border border-[#D4A853]/20 inline-flex items-center gap-1.5">
                                        {{ $q->test_cases_count }} Kasus
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @if ($q->batas_waktu)
                                    @if ($q->batas_waktu)
                                        @php $isExpired = now()->isAfter($q->batas_waktu); @endphp
                                        <div class="flex items-center gap-2 {{ $isExpired ? 'text-rose-400/80' : 'text-gray-400' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="font-mono text-[11px]">{{ $q->batas_waktu->format('d M Y, H:i') }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-600 italic text-xs font-medium">Tanpa Batas</span>
                                    @endif
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($q->aktif)
                                        <span class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-md font-bold text-emerald-400 bg-emerald-500/10 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-md font-bold text-gray-400 bg-gray-800 border border-gray-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit diubah ke aksen HMTI Gold --}}
                                        <a href="{{ route('admin.questions.edit', $q->id) }}"
                                            class="inline-flex items-center justify-center px-3 py-1.5 bg-[#D4A853]/10 hover:bg-[#D4A853]/20 text-[#D4A853] border border-[#D4A853]/20 hover:border-[#D4A853]/40 rounded-lg text-xs font-bold transition-all">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus soal ini? Semua Test Case dan riwayat jawaban praktikan untuk soal ini akan ikut terhapus permanen.');" class="m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center text-rose-400 hover:text-rose-300 bg-rose-500/5 hover:bg-rose-500/10 px-3 py-1.5 rounded-lg transition-all border border-rose-500/10 hover:border-rose-500/30 text-xs font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center text-gray-500 mb-4 border border-gray-700/50">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                        </div>
                                        <p class="text-lg font-medium text-gray-300">Belum ada daftar soal.</p>
                                        <p class="text-gray-500 text-sm mt-1">Klik "Tambah Soal" di sudut kanan atas untuk mulai membuat modul.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

</x-app-layout>
