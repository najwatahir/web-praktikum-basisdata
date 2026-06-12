<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Praktikum Basis Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="relative min-h-screen flex items-center justify-center">

        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('images/hmtiudayana_cover.jpg') }}')">
        </div>

        <div class="absolute inset-0 bg-black/60"></div>

        {{-- content --}}
        <div class="relative z-10 w-full max-w-md px-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white tracking-wide">Praktikum Basis Data</h1>
                <p class="text-white/70 mt-2 text-sm">HMTI Udayana — Masukkan data diri kamu untuk mulai</p>
            </div>

            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8">

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-500/20 border border-red-400/40 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-red-300 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('participant.join') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-white/80 text-sm font-medium mb-1">NIM</label>
                        <input
                            type="text"
                            name="nim"
                            value="{{ old('nim') }}"
                            placeholder="Masukkan NIM kamu"
                            required
                            class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-goldYellow/70 focus:bg-white/20 transition"
                        />
                    </div>

                    <div class="mb-4">
                        <label class="block text-white/80 text-sm font-medium mb-1">Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap kamu"
                            required
                            class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-white/70 focus:bg-white/20 transition"
                        />
                    </div>

                    <div class="mb-6">
                        <label class="block text-white/80 text-sm font-medium mb-1">Nomor Kelompok</label>
                        <input
                            type="number"
                            name="kelompok"
                            value="{{ old('kelompok') }}"
                            placeholder="Contoh: 1, 11"
                            min="1"
                            required
                            class="w-full px-4 py-3 bg-white/10 border border-goldYellow/30 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-goldYellow/70 focus:bg-white/20 transition"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 bg-[#D4A853] hover:bg-[#9b7c3f] active:scale-95 text-white font-semibold rounded-xl transition duration-200"
                    >
                        Mulai Praktikum →
                    </button>

                </form>
            </div>

            <p class="text-center text-white/40 text-xs mt-6">
                Inti Basis Data © {{ date('Y') }} HMTI Udayana
            </p>
        </div>
    </div>

</body>
</html>