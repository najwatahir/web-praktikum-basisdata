<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 mb-1">Total Peserta</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalParticipants }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 mb-1">Total Kelompok</p>
            <p class="text-3xl font-bold" style="color:#D4A853">{{ $totalKelompok }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 mb-1">Total Soal</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalQuestions }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <p class="text-xs text-gray-500 mb-1">Total Submission</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalSubmissions }}</p>
        </div>
    </div>

    {{-- Menu Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <a href="{{ route('admin.rekap') }}"
           class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="text-2xl mb-3">📊</div>
            <h2 class="font-semibold text-gray-900 mb-1">Rekap Nilai</h2>
            <p class="text-sm text-gray-500">Lihat nilai peserta, filter per kelompok</p>
        </a>
        <a href="{{ route('admin.submissions') }}"
           class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="text-2xl mb-3">📋</div>
            <h2 class="font-semibold text-gray-900 mb-1">Semua Submission</h2>
            <p class="text-sm text-gray-500">Lihat semua jawaban yang masuk</p>
        </a>
        <a href="{{ route('admin.questions.index') }}"
           class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md hover:-translate-y-0.5 transition duration-200">
            <div class="text-2xl mb-3">📝</div>
            <h2 class="font-semibold text-gray-900 mb-1">Kelola Soal</h2>
            <p class="text-sm text-gray-500">Tambah, edit, dan hapus soal praktikum</p>
        </a>
    </div>
</x-admin-layout>