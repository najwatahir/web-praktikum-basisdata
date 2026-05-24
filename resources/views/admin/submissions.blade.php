<x-admin-layout>
    <x-slot name="title">Semua Submission</x-slot>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.submissions') }}"
          class="flex items-center gap-3 mb-6">
        <select name="kelompok"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none">
            <option value="">Semua Kelompok</option>
            @foreach($kelompoks as $k)
                <option value="{{ $k }}" {{ $kelompok == $k ? 'selected' : '' }}>
                    Kelompok {{ str_pad($k, 2, '0', STR_PAD_LEFT) }}
                </option>
            @endforeach
        </select>
        <select name="question_id"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none">
            <option value="">Semua Soal</option>
            @foreach($questions as $q)
                <option value="{{ $q->id }}" {{ $questionId == $q->id ? 'selected' : '' }}>
                    Soal {{ $q->urutan }} — {{ $q->judul }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="text-sm px-4 py-2 rounded-lg text-white font-medium transition"
                style="background:#D4A853">
            Filter
        </button>
        <a href="{{ route('admin.submissions') }}"
           class="text-sm text-gray-400 hover:text-gray-700">Reset</a>

        <span class="ml-auto text-xs text-gray-400">
            {{ $submissions->total() }} submission
        </span>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Peserta</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kelompok</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Soal</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Query</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Attempt</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $sub)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">
                            {{ $sub->created_at->format('d/m H:i:s') }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-900 text-xs">{{ $sub->participant->nama ?? '-' }}</p>
                            <p class="text-gray-400 text-xs font-mono">{{ $sub->participant->nim ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            Kelompok {{ str_pad($sub->participant->kelompok ?? '-', 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600 whitespace-nowrap">
                            Soal {{ $sub->question->urutan ?? '-' }}
                        </td>
                        <td class="px-4 py-3 max-w-xs">
                            <code class="text-xs bg-gray-50 border border-gray-100 px-2 py-1 rounded text-gray-600 block truncate">
                                {{ $sub->query }}
                            </code>
                        </td>
                        <td class="px-4 py-3 text-center text-xs text-gray-500">
                            #{{ $sub->attempt }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($sub->is_correct)
                                <span class="text-xs px-2 py-1 rounded-full text-white font-medium"
                                      style="background:#D4A853">✓ Benar</span>
                            @elseif($sub->score > 0)
                                <span class="text-xs px-2 py-1 rounded-full font-medium"
                                      style="background:#fff7ed; color:#c2710c; border:1px solid #fed7aa">⚡ Partial</span>
                            @else
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-400 font-medium">
                                    ✗ Salah
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right font-bold"
                            style="{{ $sub->score > 0 ? 'color:#D4A853' : 'color:#d1d5db' }}">
                            {{ $sub->score }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-16 text-center text-gray-400">
                            Belum ada submission.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $submissions->appends(request()->query())->links() }}
    </div>

</x-admin-layout>