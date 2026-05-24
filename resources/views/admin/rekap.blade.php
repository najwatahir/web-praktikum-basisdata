<x-admin-layout>
    <x-slot name="title">Rekap Nilai</x-slot>

    {{-- Filter --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">
            {{ $kelompok ? 'Kelompok ' . $kelompok : 'Semua Kelompok' }}
            — {{ $rekap->count() }} peserta
        </p>
        <form method="GET" action="{{ route('admin.rekap') }}" class="flex items-center gap-2">
            <select name="kelompok" onchange="this.form.submit()"
                    class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none bg-white">
                <option value="">Semua Kelompok</option>
                @foreach($kelompoks as $k)
                    <option value="{{ $k }}" {{ $kelompok == $k ? 'selected' : '' }}>
                        Kelompok {{ str_pad($k, 2, '0', STR_PAD_LEFT) }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50">
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">NIM</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kelompok</th>
                    @foreach($questions as $q)
                        <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase whitespace-nowrap">
                            Soal {{ $q->urutan }}
                        </th>
                    @endforeach
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-center px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Selesai</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekap as $index => $row)
                    <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $row->nim }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $row->nama }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                                Kelompok {{ str_pad($row->kelompok, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>

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
                            <td class="px-4 py-3 text-center">
                                @if($score == 100)
                                    <span class="text-xs font-bold px-2 py-1 rounded-md text-white"
                                          style="background:#D4A853">{{ $score }}</span>
                                @elseif($score > 0)
                                    <span class="text-xs font-bold px-2 py-1 rounded-md"
                                          style="background:#fff7ed; color:#c2710c; border:1px solid #fed7aa">{{ $score }}</span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                        @endforeach

                        <td class="px-4 py-3 text-right">
                            <span class="font-bold text-base" style="color:#D4A853">
                                {{ $row->total_score }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-xs text-gray-500">
                            {{ $row->solved }}/{{ $questions->count() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 5 + $questions->count() }}"
                            class="px-4 py-16 text-center text-gray-400">
                            Belum ada data peserta.
                        </td>
                    </tr>
                @endforelse
            </tbody>

            {{-- Footer total --}}
            @if($rekap->count() > 0)
                <tfoot>
                    <tr class="bg-gray-50 border-t border-gray-200">
                        <td colspan="4" class="px-4 py-3 text-xs font-semibold text-gray-500">
                            Total {{ $rekap->count() }} peserta
                        </td>
                        @foreach($questions as $q)
                            <td class="px-4 py-3 text-center text-xs text-gray-400">
                                avg {{ round($rekap->avg(function($r) use ($q, $scorePerSoal, $partialScore) {
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
                        <td class="px-4 py-3 text-right text-xs font-semibold" style="color:#D4A853">
                            avg {{ round($rekap->avg('total_score')) }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</x-admin-layout>