<x-app-layout>
    <x-slot name="title">Leaderboard</x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Leaderboard</h1>
        <p class="text-gray-500 mt-1">Peringkat peserta berdasarkan total skor</p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide w-16">
                        #
                    </th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Nama
                    </th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        NIM
                    </th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Kelompok
                    </th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Soal Selesai
                    </th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Total Skor
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaderboard as $index => $row)
                    @php
                        $rank = $index + 1;
                        $isMe = session('nim') === $row->nim;
                    @endphp
                    <tr class="border-b border-gray-50 transition hover:bg-gray-50
                               {{ $isMe ? 'bg-yellow-50' : '' }}">

                        {{-- Rank --}}
                        <td class="px-6 py-4">
                            @if($rank === 1)
                                <span class="text-xl">🥇</span>
                            @elseif($rank === 2)
                                <span class="text-xl">🥈</span>
                            @elseif($rank === 3)
                                <span class="text-xl">🥉</span>
                            @else
                                <span class="text-sm font-medium text-gray-500">{{ $rank }}</span>
                            @endif
                        </td>

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-900">
                                {{ $row->nama }}
                                @if($isMe)
                                    <span class="text-xs ml-1 px-2 py-0.5 rounded-full font-medium"
                                          style="background-color:#fdf6e7; color:#D4A853; border:1px solid #D4A853">
                                        Kamu
                                    </span>
                                @endif
                            </span>
                        </td>

                        {{-- NIM --}}
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $row->nim }}
                        </td>

                        {{-- Kelompok --}}
                        <td class="px-6 py-4 text-sm text-gray-500">
                            Kelompok {{ $row->kelompok }}
                        </td>

                        {{-- Soal Selesai --}}
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $row->solved }} soal
                        </td>

                        {{-- Total Skor --}}
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-gray-900">{{ $row->total_score }}</span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                            Belum ada peserta yang mengumpulkan skor.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Auto refresh tiap 30 detik --}}
    <script>
        setTimeout(() => location.reload(), 30000);
    </script>

</x-app-layout>