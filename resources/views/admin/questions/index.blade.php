<x-app-layout>
    <x-slot name="title">Manajemen Soal</x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}"
               class="group inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-300 transition-colors duration-200">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight">Manajemen Soal</h1>
                <p class="text-gray-400 mt-2">Kelola daftar soal praktikum dan konfigurasi test case.</p>
            </div>
            <div>
                <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-xl transition duration-300 shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Soal
                </a>
            </div>
        </div>

        <div class="bg-[#111113] rounded-2xl border border-gray-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900/50 border-b border-gray-800">
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">No</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Judul Soal</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Poin</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Test Cases</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tenggat Waktu</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Status</th>
                            <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($questions as $q)
                            <tr class="hover:bg-[#151518] transition-colors duration-200">
                                <td class="py-4 px-6 text-sm text-gray-300 font-medium">{{ $q->urutan }}</td>
                                <td class="py-4 px-6">
                                    <p class="text-sm font-semibold text-gray-200">{{ $q->judul }}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $q->deskripsi }}</p>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-300 text-center font-medium">{{ $q->poin }}</td>
                                <td class="py-4 px-6 text-sm text-gray-300 text-center">
                                    <span class="bg-gray-800 text-gray-300 py-1 px-3 rounded-full text-xs border border-gray-700">
                                        {{ $q->test_cases_count }} Kasus
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-sm">
                                    @if($q->batas_waktu)
                                        @php $isExpired = now()->isAfter($q->batas_waktu); @endphp
                                        <span class="{{ $isExpired ? 'text-red-400' : 'text-gray-400' }}">
                                            {{ $q->batas_waktu->format('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="text-gray-600 italic">Tanpa Batas</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($q->aktif)
                                        <span class="text-xs px-3 py-1 rounded-full font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20">Aktif</span>
                                    @else
                                        <span class="text-xs px-3 py-1 rounded-full font-medium text-gray-400 bg-gray-800 border border-gray-700">Draft</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
    @if($q->aktif)
        <span class="text-xs px-3 py-1 rounded-full font-medium text-emerald-400 bg-emerald-500/10 border border-emerald-500/20">Aktif</span>
    @else
        <span class="text-xs px-3 py-1 rounded-full font-medium text-gray-400 bg-gray-800 border border-gray-700">Draft</span>
    @endif
</td>

<td class="py-4 px-6 text-center">
    <a href="{{ route('admin.questions.edit', $q->id) }}" class="inline-block px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/20 rounded-lg text-sm transition">
        Edit
    </a>
    <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini? Semua Test Case dan riwayat jawaban praktikan untuk soal ini akan ikut terhapus permanen.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-400 hover:text-red-300 hover:bg-red-500/10 px-3 py-1.5 rounded-lg transition-colors border border-transparent hover:border-red-500/30 text-sm font-medium">
            Hapus
        </button>
        
    </form>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">
                                    Belum ada soal. Klik "Tambah Soal" untuk mulai membuat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>