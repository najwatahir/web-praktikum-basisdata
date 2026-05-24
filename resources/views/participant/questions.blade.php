<x-app-layout>
    <x-slot name="title">Daftar Soal</x-slot>

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Soal</h1>
        <p class="text-gray-500 mt-1">Halo, <span class="font-medium text-gray-700">{{ session('nama') }}</span> — Kelompok {{ session('kelompok') }}</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Total Soal</p>
            <p class="text-2xl font-bold text-gray-900">{{ $questions->count() }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Sudah Dijawab</p>
            <p class="text-2xl font-bold" style="color:#D4A853">{{ count($solved) }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-xs text-gray-500 mb-1">Belum Dijawab</p>
            <p class="text-2xl font-bold text-gray-900">{{ $questions->count() - count($solved) }}</p>
        </div>
    </div>

    {{-- Daftar Soal --}}
    <div class="grid gap-4">
        @forelse($questions as $question)
            @php $isSolved = in_array($question->id, $solved); @endphp
            <a href="{{ route('questions.solve', $question->id) }}"
               class="bg-white rounded-xl border transition hover:shadow-md hover:-translate-y-0.5 duration-200 p-5 flex items-center justify-between
                      {{ $isSolved ? 'border-yellow-300' : 'border-gray-200' }}">
                <div class="flex items-center gap-4">
                    {{-- Nomor --}}
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0
                                {{ $isSolved ? 'text-white' : 'bg-gray-100 text-gray-500' }}"
                         style="{{ $isSolved ? 'background-color:#D4A853' : '' }}">
                        {{ $question->urutan }}
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">{{ $question->judul }}</h2>
                        <p class="text-sm text-gray-500 mt-0.5 line-clamp-1">{{ $question->deskripsi }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="text-sm font-medium text-gray-500">{{ $question->poin }} poin</span>
                    @if($isSolved)
                        <span class="text-xs px-3 py-1 rounded-full font-medium text-white" style="background-color:#D4A853">
                            ✓ Selesai
                        </span>
                    @else
                        <span class="text-xs px-3 py-1 rounded-full font-medium bg-gray-100 text-gray-500">
                            Belum
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <div class="text-center py-16 text-gray-400">
                <p class="text-lg">Belum ada soal tersedia.</p>
            </div>
        @endforelse
    </div>

</x-app-layout>