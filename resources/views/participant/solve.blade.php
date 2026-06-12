<x-app-layout>
    <x-slot name="title">{{ $question->judul }}</x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Area Layout Workspace --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full">

            {{-- ── KOLOM KIRI: Info Soal (Lebar 5 Kolom) ── --}}
            <div class="lg:col-span-5 space-y-5">

                {{-- Back Navigation --}}
                <a href="{{ route('questions.index') }}"
                   class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke daftar soal
                </a>

                {{-- Card Judul & Poin --}}
                <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg relative overflow-hidden">
                    {{-- Aksen Blur HMTI Gold --}}
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#D4A853]/10 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="flex items-start justify-between gap-4 mb-4 relative z-10">
                        <h1 class="text-2xl font-bold text-gray-100 tracking-tight">{{ $question->judul }}</h1>
                        <span class="flex-shrink-0 flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-lg border border-[#D4A853]/20 bg-[#D4A853]/10 text-[#D4A853]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            {{ $question->poin }} pts
                        </span>
                    </div>
                    <p class="text-gray-400 leading-relaxed text-sm relative z-10">{{ $question->deskripsi }}</p>

                    {{-- Status sudah benar --}}
                    @if($lastSubmission && $lastSubmission->is_correct)
                        <div class="mt-5 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400">
                            <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            Tantangan ini telah berhasil diselesaikan!
                        </div>
                    @endif
                </div>

                {{-- Card Schema --}}
                <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                            Database Schema
                        </h3>
                    </div>
                    {{-- Warna teks diubah ke Gold opacity 80% --}}
                    <pre class="text-[13px] bg-[#09090b] border border-white/5 rounded-xl p-4 overflow-x-auto text-[#D4A853]/80 font-mono leading-relaxed whitespace-pre-wrap">{{ trim($question->schema_sql) }}</pre>
                </div>

                {{-- Card Hasil Query (Hidden by default) --}}
                <div class="bg-[#111113] rounded-2xl border border-white/5 p-6 shadow-lg transition-all duration-300" id="result-box" style="display:none">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Output Query
                    </h3>
                    <div id="result-content" class="overflow-x-auto rounded-lg border border-white/5 custom-scrollbar"></div>
                </div>

            </div>

            {{-- ── KOLOM KANAN: Editor (Lebar 7 Kolom) ── --}}
            <div class="lg:col-span-7 space-y-5">

                {{-- Editor Card --}}
                <div class="bg-[#111113] rounded-2xl border border-white/5 shadow-2xl overflow-hidden flex flex-col">
                    {{-- Header Mac Style --}}
                    <div class="px-4 py-3 bg-[#18181b] border-b border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-500/20 border border-rose-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/20 border border-amber-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/20 border border-emerald-500/50"></div>
                        </div>
                        
                        <span class="text-xs font-mono text-gray-400">workspace.sql</span>

                        <div class="flex items-center gap-1.5 text-[10px] font-mono text-emerald-500/70">
                            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                            1ms
                        </div>
                    </div>
                    
                    {{-- Monaco Container --}}
                    <div id="monaco-editor" class="w-full bg-[#09090b]" style="height:380px;"></div>
                    
                    {{-- Footer Editor --}}
                    <div class="px-4 py-2 bg-[#18181b] border-t border-white/5 flex items-center justify-between">
                        <span class="text-[11px] text-gray-500 font-mono">Read-only connection: SELECT only</span>
                        <span class="text-[11px] text-gray-500 font-mono">UTF-8</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4">
                    <button onclick="testQuery()" id="test-btn"
                            class="flex-1 py-3.5 rounded-xl font-semibold text-sm border border-gray-700 bg-gray-800/50 text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Test Run
                    </button>
                    {{-- Tombol Submit dirubah warnanya menjadi Gold HMTI beserta dengan glow bayangannya --}}
                    <button onclick="submitQuery()" id="submit-btn"
                            class="flex-1 py-3.5 rounded-xl font-semibold text-sm text-black bg-[#D4A853] hover:bg-[#9b7c3f] shadow-[0_0_20px_rgba(212,168,83,0.3)] hover:shadow-[0_0_25px_rgba(212,168,83,0.5)] transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Submit Solution
                    </button>
                </div>

                {{-- Feedback Box --}}
                <div id="feedback-box" class="rounded-xl p-4 text-sm hidden border transition-all duration-300"></div>

                {{-- Riwayat Terakhir --}}
                @if($lastSubmission)
                    <div class="bg-[#111113] rounded-2xl border border-white/5 p-5">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs text-gray-500 uppercase tracking-widest font-bold flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Latest Attempt
                            </p>
                            <span class="text-xs px-2 py-1 rounded bg-gray-800 text-gray-400 border border-gray-700">Attempt #{{ $lastSubmission->attempt }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between bg-[#09090b] rounded-lg p-3 border border-white/5 mb-3">
                            <span class="text-sm text-gray-400">Score Achieved</span>
                            <span class="text-sm font-bold text-[#D4A853]">{{ $lastSubmission->score }} pts</span>
                        </div>

                        @if($lastSubmission->feedback)
                            <div class="text-sm text-amber-500/80 bg-amber-500/10 border border-amber-500/20 rounded-lg p-3 mb-3 flex items-start gap-2">
                                <span class="shrink-0">💡</span>
                                <p>{{ $lastSubmission->feedback }}</p>
                            </div>
                        @endif

                        {{-- Query terakhir --}}
                        <div>
                            <p class="text-[11px] text-gray-500 mb-1.5 uppercase tracking-wide">Submitted Query:</p>
                            <pre class="text-xs bg-[#09090b] border border-white/5 rounded-lg p-3 text-gray-400 overflow-x-auto font-mono">{{ $lastSubmission->query }}</pre>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Monaco + Custom JS Styles --}}
    <style>
        /* Dark mode scrollbar for result table */
        .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #09090b; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #27272a; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #3f3f46; }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs/loader.min.js"></script>
    <script>
        let editor;

        require.config({
            paths: { vs: 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.44.0/min/vs' }
        });

        require(['vs/editor/editor.main'], function () {
            editor = monaco.editor.create(document.getElementById('monaco-editor'), {
                value: `{!! $lastSubmission ? addslashes($lastSubmission->query) : 'SELECT ...' !!}`,
                language: 'sql',
                theme: 'vs-dark',
                fontSize: 14,
                fontFamily: "'JetBrains Mono', 'Fira Code', Consolas, monospace",
                minimap: { enabled: false },
                scrollBeyondLastLine: false,
                automaticLayout: true,
                padding: { top: 16, bottom: 16 },
                renderLineHighlight: "all",
                lineNumbersMinChars: 3,
            });
        });

        async function testQuery() {
            const query = editor.getValue().trim();
            if (!query) return;

            setLoading('test-btn', true, 'Running...');

            try {
                const data = await sendRequest('{{ route("test") }}', query);
                if (data.status === 'error') {
                    showFeedback('error', '❌ <strong>Error:</strong> ' + data.message);
                } else {
                    showFeedback('info', '✓ Query executed successfully. Check the output below.');
                    showResult(data.result);
                }
            } catch (e) {
                showFeedback('error', 'Connection error, please try again.');
            } finally {
                setLoading('test-btn', false, `<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg> Test Run`);
            }
        }

        async function submitQuery() {
            const query = editor.getValue().trim();
            if (!query) return;
            if (!confirm('Submit your solution? Your score will be recorded.')) return;

            setLoading('submit-btn', true, 'Submitting...');

            try {
                const data = await sendRequest('{{ route("submit") }}', query);

                if (data.status === 'correct') {
                    showFeedback('correct', ` <strong>Accepted!</strong> You earned <strong>${data.score} pts</strong>.`);
                    showResult(data.result);
                    setTimeout(() => location.reload(), 2000);

                } else if (data.status === 'partial') {
                    showFeedback('partial', ` <strong>Partially correct.</strong> You earned <strong>${data.score} pts</strong>.` +
                        (data.feedback ? `<br><span class="mt-2 flex items-start gap-1 opacity-80"><span class="shrink-0">💡</span> ${data.feedback}</span>` : ''));
                    showResult(data.result);

                } else if (data.status === 'wrong') {
                    showFeedback('wrong', `✗ <strong>Incorrect outcome.</strong>` +
                        (data.feedback ? `<br><span class="mt-2 flex items-start gap-1 opacity-80"><span class="shrink-0">💡</span> ${data.feedback}</span>` : ''));
                    showResult(data.result);

                } else {
                    showFeedback('error', '❌ <strong>Error:</strong> ' + data.message);
                }
            } catch (e) {
                showFeedback('error', 'Connection error, please try again.');
            } finally {
                setLoading('submit-btn', false, `<svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Submit Solution`);
            }
        }

        async function sendRequest(url, query) {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    question_id: {{ $question->id }},
                    query: query,
                }),
            });
            return res.json();
        }

        function setLoading(btnId, loading, text) {
            const btn = document.getElementById(btnId);
            btn.disabled = loading;
            btn.innerHTML = text;
            if(loading) {
                btn.classList.add('opacity-70', 'cursor-not-allowed');
            } else {
                btn.classList.remove('opacity-70', 'cursor-not-allowed');
            }
        }

        function showFeedback(type, message) {
            const box = document.getElementById('feedback-box');
            box.classList.remove('hidden');
            
            // Konversi warna Notifikasi
            const styles = {
                correct: 'background:rgba(16,185,129,0.1); border-color:rgba(16,185,129,0.2); color:#34d399',
                partial: 'background:rgba(245,158,11,0.1); border-color:rgba(245,158,11,0.2); color:#fbbf24',
                wrong:   'background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#f87171',
                error:   'background:rgba(239,68,68,0.1); border-color:rgba(239,68,68,0.2); color:#f87171',
                // Tipe Info disesuaikan dengan skema Gold
                info:    'background:rgba(212,168,83,0.1); border-color:rgba(212,168,83,0.2); color:#D4A853',
            };
            
            box.style.cssText = styles[type] || styles.info;
            box.innerHTML = message;
        }

        function showResult(rows) {
            if (!rows || rows.length === 0) {
                document.getElementById('result-content').innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">No rows returned.</div>';
                document.getElementById('result-box').style.display = 'block';
                return;
            }
            const box = document.getElementById('result-box');
            box.style.display = 'block';
            const keys = Object.keys(rows[0]);
            
            let html = '<table class="w-full text-[13px] border-collapse">';
            html += '<thead><tr>' + keys.map(k =>
                `<th class="text-left px-4 py-3 bg-[#18181b] border-b border-white/5 font-semibold text-gray-400 whitespace-nowrap">${k}</th>`
            ).join('') + '</tr></thead><tbody class="divide-y divide-white/5">';
            
            rows.forEach((row, i) => {
                const bgClass = i % 2 === 0 ? 'bg-[#111113]' : 'bg-[#151518]';
                // Warna hover tabel diubah dari indigo ke Gold/10
                html += `<tr class="${bgClass} hover:bg-[#D4A853]/5 transition-colors">` + keys.map(k =>
                    `<td class="px-4 py-2.5 text-gray-300 whitespace-nowrap font-mono">${row[k] !== null ? row[k] : '<span class="text-gray-600 italic">NULL</span>'}</td>`
                ).join('') + '</tr>';
            });
            html += '</tbody></table>';
            document.getElementById('result-content').innerHTML = html;
        }
    </script>
</x-app-layout>