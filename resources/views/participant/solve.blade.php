<x-app-layout>
    <x-slot name="title">{{ $question->judul }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-full">

        {{-- ── KOLOM KIRI: Info Soal ── --}}
        <div class="space-y-4">

            {{-- Back --}}
            <a href="{{ route('questions.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition">
                ← Kembali ke daftar soal
            </a>

            {{-- Judul & Poin --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <h1 class="text-xl font-bold text-gray-900">{{ $question->judul }}</h1>
                    <span class="flex-shrink-0 text-sm font-semibold px-3 py-1 rounded-full text-white"
                          style="background-color:#D4A853">
                        {{ $question->poin }} poin
                    </span>
                </div>
                <p class="text-gray-600 leading-relaxed">{{ $question->deskripsi }}</p>

                {{-- Status sudah benar --}}
                @if($lastSubmission && $lastSubmission->is_correct)
                    <div class="mt-4 px-4 py-2 rounded-lg text-sm font-medium"
                         style="background:#fdf6e7; border:1px solid #D4A853; color:#92680a">
                        ✓ Kamu sudah menjawab soal ini dengan benar!
                    </div>
                @endif
            </div>

            {{-- Schema --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                    Schema Database
                </h3>
                <pre class="text-xs bg-gray-50 rounded-lg p-4 overflow-x-auto text-gray-700 leading-relaxed whitespace-pre-wrap">{{ trim($question->schema_sql) }}</pre>
            </div>

            {{-- Hasil Query --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6" id="result-box" style="display:none">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                    Hasil Query
                </h3>
                <div id="result-content" class="overflow-x-auto"></div>
            </div>

        </div>

        {{-- ── KOLOM KANAN: Editor ── --}}
        <div class="space-y-4">

            {{-- Editor Card --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-700">SQL Editor</span>
                    <span class="text-xs text-gray-400 bg-gray-50 px-2 py-1 rounded-md">
                        Hanya SELECT yang diizinkan
                    </span>
                </div>
                <div id="monaco-editor" style="height:320px;"></div>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">
                <button onclick="testQuery()" id="test-btn"
                        class="flex-1 py-3 rounded-xl font-semibold text-sm border-2 transition active:scale-95 duration-150"
                        style="border-color:#D4A853; color:#D4A853; background:white">
                    ▶ Test Query
                </button>
                <button onclick="submitQuery()" id="submit-btn"
                        class="flex-1 py-3 rounded-xl font-semibold text-sm text-white transition active:scale-95 duration-150"
                        style="background-color:#D4A853">
                    ✓ Submit
                </button>
            </div>

            {{-- Feedback --}}
            <div id="feedback-box" class="rounded-xl p-4 text-sm hidden"></div>

            {{-- Riwayat --}}
            @if($lastSubmission)
                <div class="bg-white rounded-xl border border-gray-200 p-4">
                    <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-2">
                        Percobaan Terakhir
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Attempt ke-{{ $lastSubmission->attempt }}</span>
                        <span class="text-sm font-semibold"
                              style="color:#D4A853">
                            {{ $lastSubmission->score }} poin
                        </span>
                    </div>
                    @if($lastSubmission->feedback)
                        <p class="text-sm text-gray-500 mt-2 italic border-t border-gray-100 pt-2">
                            💡 {{ $lastSubmission->feedback }}
                        </p>
                    @endif

                    {{-- Query terakhir --}}
                    <div class="mt-3 border-t border-gray-100 pt-3">
                        <p class="text-xs text-gray-400 mb-1">Query terakhir kamu:</p>
                        <pre class="text-xs bg-gray-50 rounded p-2 text-gray-600 overflow-x-auto">{{ $lastSubmission->query }}</pre>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Monaco + JS --}}
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
                theme: 'vs',
                fontSize: 14,
                minimap: { enabled: false },
                scrollBeyondLastLine: false,
                automaticLayout: true,
                padding: { top: 12 },
            });
        });

        async function testQuery() {
            const query = editor.getValue().trim();
            if (!query) return;

            setLoading('test-btn', true, 'Menjalankan...');

            try {
                const data = await sendRequest('{{ route("test") }}', query);
                if (data.status === 'error') {
                    showFeedback('error', '❌ <strong>Error:</strong> ' + data.message);
                } else {
                    showFeedback('info', '✓ Query berhasil dijalankan. Cek hasil di bawah, lalu klik <strong>Submit</strong> jika sudah yakin.');
                    showResult(data.result);
                }
            } catch (e) {
                showFeedback('error', 'Terjadi kesalahan koneksi, coba lagi.');
            } finally {
                setLoading('test-btn', false, '▶ Test Query');
            }
        }

        async function submitQuery() {
            const query = editor.getValue().trim();
            if (!query) return;
            if (!confirm('Yakin mau submit? Jawaban akan dinilai dan skor disimpan.')) return;

            setLoading('submit-btn', true, 'Menyimpan...');

            try {
                const data = await sendRequest('{{ route("submit") }}', query);

                if (data.status === 'correct') {
                    showFeedback('correct', ` <strong>Jawaban benar!</strong> Kamu mendapat <strong>${data.score} poin</strong>.`);
                    showResult(data.result);
                    setTimeout(() => location.reload(), 2500);

                } else if (data.status === 'partial') {
                    showFeedback('partial', ` <strong>Jawaban sbagian benar.</strong> Kamu mendapat <strong>${data.score} poin</strong>.` +
                        (data.feedback ? `<br><span class="mt-1 block italic">💡 ${data.feedback}</span>` : ''));
                    showResult(data.result);

                } else if (data.status === 'wrong') {
                    showFeedback('wrong', `✗ <strong>Belum tepat.</strong>` +
                        (data.feedback ? `<br><span class="mt-1 block italic">💡 ${data.feedback}</span>` : ''));
                    showResult(data.result);

                } else {
                    showFeedback('error', '❌ <strong>Error:</strong> ' + data.message);
                }
            } catch (e) {
                showFeedback('error', 'Terjadi kesalahan koneksi, coba lagi.');
            } finally {
                setLoading('submit-btn', false, '✓ Submit');
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
            btn.textContent = text;
        }

        function showFeedback(type, message) {
            const box = document.getElementById('feedback-box');
            box.classList.remove('hidden');
            const styles = {
                correct: 'background:#fdf6e7; border:1px solid #D4A853; color:#92680a',
                partial: 'background:#fffbeb; border:1px solid #fbbf24; color:#92400e',
                wrong:   'background:#fef2f2; border:1px solid #fca5a5; color:#b91c1c',
                error:   'background:#fef2f2; border:1px solid #fca5a5; color:#b91c1c',
                info:    'background:#eff6ff; border:1px solid #93c5fd; color:#1e40af',
            };
            box.style.cssText = styles[type] || styles.info;
            box.innerHTML = message;
        }

        function showResult(rows) {
            if (!rows || rows.length === 0) return;
            const box = document.getElementById('result-box');
            box.style.display = 'block';
            const keys = Object.keys(rows[0]);
            let html = '<table class="w-full text-xs border-collapse">';
            html += '<thead><tr>' + keys.map(k =>
                `<th class="text-left px-3 py-2 bg-gray-50 border border-gray-200 font-medium text-gray-600">${k}</th>`
            ).join('') + '</tr></thead><tbody>';
            rows.forEach(row => {
                html += '<tr>' + keys.map(k =>
                    `<td class="px-3 py-2 border border-gray-100 text-gray-700">${row[k] ?? '-'}</td>`
                ).join('') + '</tr>';
            });
            html += '</tbody></table>';
            document.getElementById('result-content').innerHTML = html;
        }
    </script>

</x-app-layout>