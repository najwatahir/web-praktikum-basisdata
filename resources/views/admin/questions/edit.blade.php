<x-app-layout>
    <x-slot name="title">Edit Soal Praktikum</x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <div class="mb-6">
            <a href="{{ route('admin.questions.index') }}"
               class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke daftar soal
            </a>
        </div>

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-tight">Edit Soal: {{ $question->judul }}</h1>
            <p class="text-gray-400 mt-2">Perbarui detail soal dan konfigurasi test case untuk evaluasi otomatis.</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT') 

            <div class="bg-[#111113] rounded-2xl border border-gray-800 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-200 mb-6 border-b border-gray-800 pb-2">Detail Soal</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Judul Soal</label>
                        <input type="text" name="judul" value="{{ old('judul', $question->judul) }}" required class="w-full bg-[#151518] border border-gray-700 rounded-lg text-white px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Deskripsi Soal (Markdown / Teks)</label>
                        <textarea name="deskripsi" rows="4" required class="w-full bg-[#151518] border border-gray-700 rounded-lg text-white px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500">{{ old('deskripsi', $question->deskripsi) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Poin Maksimal</label>
                        <input type="number" name="poin" value="{{ old('poin', $question->poin) }}" required class="w-full bg-[#151518] border border-gray-700 rounded-lg text-white px-4 py-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Urutan Tampil (No. Soal)</label>
                        <input type="number" name="urutan" value="{{ old('urutan', $question->urutan) }}" required class="w-full bg-[#151518] border border-gray-700 rounded-lg text-white px-4 py-2.5">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Batas Waktu (Opsional)</label>
                        <input type="datetime-local" name="batas_waktu" 
                               value="{{ old('batas_waktu', $question->batas_waktu ? date('Y-m-d\TH:i', strtotime($question->batas_waktu)) : '') }}" 
                               class="w-full bg-[#151518] border border-gray-700 rounded-lg text-white px-4 py-2.5" style="color-scheme: dark;">
                    </div>

                    <div class="flex items-center gap-6 pt-8">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="aktif" value="1" {{ old('aktif', $question->aktif) ? 'checked' : '' }} class="rounded border-gray-700 bg-gray-900 text-indigo-500 focus:ring-indigo-500 h-5 w-5">
                            <span class="ml-2 text-sm text-gray-300">Status Aktif</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="order_matters" value="1" {{ old('order_matters', $question->order_matters) ? 'checked' : '' }} class="rounded border-gray-700 bg-gray-900 text-indigo-500 focus:ring-indigo-500 h-5 w-5">
                            <span class="ml-2 text-sm text-gray-300">Wajib ORDER BY?</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-[#111113] rounded-2xl border border-gray-800 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6 border-b border-gray-800 pb-2">
                    <h2 class="text-lg font-semibold text-gray-200">Konfigurasi Test Case</h2>
                    <button type="button" id="btn-add-tc" class="text-sm bg-indigo-500/10 text-indigo-400 border border-indigo-500/30 px-3 py-1.5 rounded-lg hover:bg-indigo-500/20 transition">
                        + Tambah Test Case
                    </button>
                </div>

                <div id="test-cases-container" class="space-y-6">
                    @forelse($question->testCases as $index => $tc)
                        <div class="test-case-item border border-gray-700/50 rounded-xl p-5 bg-[#151518] relative">
                            @if($index > 0)
                                <button type="button" class="btn-hapus absolute -top-3 -right-3 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center hover:bg-red-600 transition">✕</button>
                            @endif
                            
                            <input type="hidden" name="test_cases[{{ $index }}][id]" value="{{ $tc->id }}">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Nama Test Case</label>
                                    <input type="text" name="test_cases[{{ $index }}][nama_test_case]" value="{{ $tc->nama_test_case }}" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Bobot Poin</label>
                                    <input type="number" name="test_cases[{{ $index }}][bobot_poin]" value="{{ $tc->bobot_poin }}" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Tipe (Visibility)</label>
                                    <select name="test_cases[{{ $index }}][is_hidden]" class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                        <option value="0" {{ $tc->is_hidden == 0 ? 'selected' : '' }}>Public (Muncul di Test Query)</option>
                                        <option value="1" {{ $tc->is_hidden == 1 ? 'selected' : '' }}>Hidden (Jebakan / Submit Saja)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Schema SQL (CREATE & INSERT)</label>
                                    <textarea name="test_cases[{{ $index }}][schema_sql]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600">{{ $tc->schema_sql }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Expected Output (Format JSON Array)</label>
                                   <textarea name="test_cases[{{ $index }}][expected_output]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600">{{ is_array($tc->expected_output) ? json_encode($tc->expected_output, JSON_PRETTY_PRINT) : $tc->expected_output }}</textarea>
                                </div>
                            </div>
                        </div>
                    @empty

                        <div class="test-case-item border border-gray-700/50 rounded-xl p-5 bg-[#151518] relative">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Nama Test Case</label>
                                    <input type="text" name="test_cases[0][nama_test_case]" value="Public Normal Case" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Bobot Poin</label>
                                    <input type="number" name="test_cases[0][bobot_poin]" value="30" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Tipe (Visibility)</label>
                                    <select name="test_cases[0][is_hidden]" class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                        <option value="0">Public (Muncul di Test Query)</option>
                                        <option value="1">Hidden (Jebakan / Submit Saja)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Schema SQL (CREATE & INSERT)</label>
                                    <textarea name="test_cases[0][schema_sql]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 mb-1">Expected Output (Format JSON Array)</label>
                                    <textarea name="test_cases[0][expected_output]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600"></textarea>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.questions.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl transition">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg shadow-indigo-500/30">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let tcIndex = {{ $question->testCases->count() > 0 ? $question->testCases->count() : 1 }}; 
            const container = document.getElementById('test-cases-container');
            const btnAdd = document.getElementById('btn-add-tc');

            btnAdd.addEventListener('click', function() {
                const html = `
                    <div class="test-case-item border border-gray-700/50 rounded-xl p-5 bg-[#151518] relative mt-6">
                        <button type="button" class="btn-hapus absolute -top-3 -right-3 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center hover:bg-red-600 transition">✕</button>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1">Nama Test Case</label>
                                <input type="text" name="test_cases[${tcIndex}][nama_test_case]" value="Hidden Edge Case" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1">Bobot Poin</label>
                                <input type="number" name="test_cases[${tcIndex}][bobot_poin]" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1">Tipe (Visibility)</label>
                                <select name="test_cases[${tcIndex}][is_hidden]" class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm">
                                    <option value="1">Hidden (Jebakan / Submit Saja)</option>
                                    <option value="0">Public (Muncul di Test Query)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1">Schema SQL</label>
                                <textarea name="test_cases[${tcIndex}][schema_sql]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-400 mb-1">Expected Output (JSON)</label>
                                <textarea name="test_cases[${tcIndex}][expected_output]" rows="5" required class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 text-sm font-mono placeholder-gray-600"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', html);
                tcIndex++;
            });

            // hapus form test case
            container.addEventListener('click', function(e) {
                if(e.target.classList.contains('btn-hapus')) {
                    e.target.closest('.test-case-item').remove();
                }
            });
        });
    </script>
</x-app-layout>