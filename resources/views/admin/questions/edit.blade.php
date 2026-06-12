<x-app-layout>
    <x-slot name="title">Edit Soal Praktikum</x-slot>

    <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Aksen blur latar belakang diubah ke HMTI Gold --}}
        <div class="absolute top-0 right-10 w-64 h-64 bg-[#D4A853]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="mb-6 relative z-10">
            <a href="{{ route('admin.questions.index') }}"
               class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-[#D4A853] transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke daftar soal
            </a>
        </div>

        <div class="mb-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#D4A853]/10 border border-[#D4A853]/20 text-[#D4A853] text-xs font-bold uppercase tracking-widest mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Editor Mode
            </div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-100 to-gray-500 tracking-tight">Edit Soal: {{ $question->judul }}</h1>
            <p class="text-gray-400 mt-2 text-sm">Perbarui detail soal dan konfigurasi test case untuk evaluasi otomatis.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-medium relative z-10 flex items-center gap-3">
                <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-8 relative z-10">
            @csrf
            @method('PUT') 

            {{-- Detail Soal Card --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-2xl relative overflow-hidden">
                {{-- Mac Header Style untuk estetika --}}
                <div class="flex items-center gap-2 mb-6 border-b border-white/5 pb-4">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                    <h2 class="ml-2 text-sm font-bold text-gray-400 uppercase tracking-widest">Detail Soal</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative z-10">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Judul Soal</label>
                        {{-- Focus ring diubah ke HMTI Gold --}}
                        <input type="text" name="judul" value="{{ old('judul', $question->judul) }}" required class="w-full bg-[#09090b] border border-white/10 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi Soal (Markdown / Teks)</label>
                        <textarea name="deskripsi" rows="4" required class="w-full bg-[#09090b] border border-white/10 rounded-xl text-gray-300 px-4 py-3 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed">{{ old('deskripsi', $question->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Poin Maksimal</label>
                        <input type="number" name="poin" value="{{ old('poin', $question->poin) }}" required class="w-full bg-[#09090b] border border-white/10 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Urutan Tampil (No. Soal)</label>
                        <input type="number" name="urutan" value="{{ old('urutan', $question->urutan) }}" required class="w-full bg-[#09090b] border border-white/10 rounded-xl text-white px-4 py-3 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Batas Waktu (Opsional)</label>
                        <input type="datetime-local" name="batas_waktu" 
                               value="{{ old('batas_waktu', $question->batas_waktu ? date('Y-m-d\TH:i', strtotime($question->batas_waktu)) : '') }}" 
                               class="w-full bg-[#09090b] border border-white/10 rounded-xl text-gray-300 px-4 py-3 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all" style="color-scheme: dark;">
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pt-6">
                        <label class="flex items-center cursor-pointer group">
                            {{-- Checkbox text color HMTI Gold --}}
                            <input type="checkbox" name="aktif" value="1" {{ old('aktif', $question->aktif) ? 'checked' : '' }} class="rounded border-white/20 bg-[#09090b] text-[#D4A853] focus:ring-[#D4A853]/50 h-5 w-5 transition-all">
                            <span class="ml-3 text-sm font-medium text-gray-400 group-hover:text-gray-200 transition-colors">Status Aktif</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="order_matters" value="1" {{ old('order_matters', $question->order_matters) ? 'checked' : '' }} class="rounded border-white/20 bg-[#09090b] text-[#D4A853] focus:ring-[#D4A853]/50 h-5 w-5 transition-all">
                            <span class="ml-3 text-sm font-medium text-gray-400 group-hover:text-gray-200 transition-colors">Wajib ORDER BY?</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Konfigurasi Test Case Card --}}
            <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b border-white/5 pb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-gray-700"></div>
                        <h2 class="ml-2 text-sm font-bold text-gray-400 uppercase tracking-widest">Konfigurasi Test Case</h2>
                    </div>
                    {{-- Tombol tambah test case diubah ke aksen HMTI Gold --}}
                    <button type="button" id="btn-add-tc" class="text-sm font-bold bg-[#D4A853]/10 text-[#D4A853] border border-[#D4A853]/30 px-4 py-2 rounded-xl hover:bg-[#D4A853]/20 hover:border-[#D4A853]/50 transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Test Case
                    </button>
                </div>

                <div id="test-cases-container" class="space-y-6">
                    @forelse($question->testCases as $index => $tc)
                        <div class="test-case-item border border-white/10 rounded-xl p-6 bg-[#09090b] relative shadow-inner group">
                            @if($index > 0)
                                <button type="button" class="btn-hapus absolute -top-3 -right-3 bg-rose-500/20 border border-rose-500/50 text-rose-500 rounded-full w-8 h-8 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            @endif
                            
                            <input type="hidden" name="test_cases[{{ $index }}][id]" value="{{ $tc->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Test Case</label>
                                    <input type="text" name="test_cases[{{ $index }}][nama_test_case]" value="{{ $tc->nama_test_case }}" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Bobot Poin</label>
                                    <input type="number" name="test_cases[{{ $index }}][bobot_poin]" value="{{ $tc->bobot_poin }}" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe (Visibility)</label>
                                    <select name="test_cases[{{ $index }}][is_hidden]" class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium cursor-pointer appearance-none">
                                        <option value="0" {{ $tc->is_hidden == 0 ? 'selected' : '' }}>Public (Muncul di Test Query)</option>
                                        <option value="1" {{ $tc->is_hidden == 1 ? 'selected' : '' }}>Hidden (Jebakan / Submit Saja)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Schema SQL (CREATE & INSERT)</label>
                                    {{-- Teks schema menggunakan aksen warna Gold saat di isi --}}
                                    <textarea name="test_cases[{{ $index }}][schema_sql]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-[#D4A853]/80 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar">{{ $tc->schema_sql }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Expected Output (Format JSON Array)</label>
                                    <textarea name="test_cases[{{ $index }}][expected_output]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-400 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar">{{ is_array($tc->expected_output) ? json_encode($tc->expected_output, JSON_PRETTY_PRINT) : $tc->expected_output }}</textarea>
                                </div>
                            </div>
                        </div>
                    @empty

                        <div class="test-case-item border border-white/10 rounded-xl p-6 bg-[#09090b] relative shadow-inner group">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Test Case</label>
                                    <input type="text" name="test_cases[0][nama_test_case]" value="Public Normal Case" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Bobot Poin</label>
                                    <input type="number" name="test_cases[0][bobot_poin]" value="30" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe (Visibility)</label>
                                    <select name="test_cases[0][is_hidden]" class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium cursor-pointer appearance-none">
                                        <option value="0">Public (Muncul di Test Query)</option>
                                        <option value="1">Hidden (Jebakan / Submit Saja)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Schema SQL (CREATE & INSERT)</label>
                                    <textarea name="test_cases[0][schema_sql]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-[#D4A853]/80 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar"></textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Expected Output (Format JSON Array)</label>
                                    <textarea name="test_cases[0][expected_output]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-400 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6">
                <a href="{{ route('admin.questions.index') }}" class="bg-[#111113] border border-white/10 hover:bg-white/5 text-gray-300 font-bold py-3.5 px-8 rounded-xl transition-all duration-200 text-center text-sm">Batal</a>
                {{-- Tombol Submit diubah ke HMTI Gold dengan efek Glow --}}
                <button type="submit" class="bg-[#D4A853] hover:bg-[#9b7c3f] text-black font-bold py-3.5 px-8 rounded-xl transition-all duration-300 shadow-[0_0_15px_rgba(212,168,83,0.3)] hover:shadow-[0_0_25px_rgba(212,168,83,0.5)] hover:-translate-y-0.5 text-center text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tcIndex = {{ $question->testCases->count() > 0 ? $question->testCases->count() : 1 }}; 
            const container = document.getElementById('test-cases-container');
            const btnAdd = document.getElementById('btn-add-tc');

            btnAdd.addEventListener('click', function() {
                // Skrip inject HTML ini juga disesuaikan stylingnya agar konsisten
                const html = `
                    <div class="test-case-item border border-white/10 rounded-xl p-6 bg-[#09090b] relative shadow-inner group mt-6 animation-fade-in">
                        <button type="button" class="btn-hapus absolute -top-3 -right-3 bg-rose-500/20 border border-rose-500/50 text-rose-500 rounded-full w-8 h-8 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-lg opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Test Case</label>
                                <input type="text" name="test_cases[${tcIndex}][nama_test_case]" value="Hidden Edge Case" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Bobot Poin</label>
                                <input type="number" name="test_cases[${tcIndex}][bobot_poin]" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe (Visibility)</label>
                                <select name="test_cases[${tcIndex}][is_hidden]" class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-200 px-4 py-2.5 text-sm focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all font-medium cursor-pointer appearance-none">
                                    <option value="1">Hidden (Jebakan / Submit Saja)</option>
                                    <option value="0">Public (Muncul di Test Query)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Schema SQL</label>
                                <textarea name="test_cases[${tcIndex}][schema_sql]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-[#D4A853]/80 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Expected Output (JSON)</label>
                                <textarea name="test_cases[${tcIndex}][expected_output]" rows="6" required class="w-full bg-[#111113] border border-white/10 rounded-xl text-gray-400 px-4 py-3 text-[13px] font-mono placeholder-gray-700 focus:ring-1 focus:ring-[#D4A853]/50 focus:border-[#D4A853]/50 transition-all leading-relaxed custom-scrollbar"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', html);
                tcIndex++;
            });

            container.addEventListener('click', function(e) {
                if(e.target.classList.contains('btn-hapus') || e.target.closest('.btn-hapus')) {
                    const item = e.target.closest('.test-case-item');
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.98)';
                    item.style.transition = 'all 0.2s ease-out';
                    setTimeout(() => item.remove(), 200);
                }
            });
        });
    </script>

    <style>
        .animation-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>