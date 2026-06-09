<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lengkapi Data - Praktikum Basis Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="relative min-h-screen flex items-center justify-center">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/hmtiudayana_cover.jpg') }}')"></div>
        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative z-10 w-full max-w-md px-6">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white tracking-wide">Lengkapi Profil</h1>
                <p class="text-white/70 mt-2 text-sm">Lengkapi data diri kamu sebelum masuk ke ruang praktikum.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-8">
                <form method="POST" action="{{ route('participant.store_profile') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-white/50 text-xs font-medium mb-1">Nama (Sesuai Akun Google)</label>
                        <input type="text" value="{{ session('temp_google_name') }}" readonly class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white/70 cursor-not-allowed" />
                    </div>
                    <div class="mb-6">
                        <label class="block text-white/50 text-xs font-medium mb-1">Email Kampus</label>
                        <input type="text" value="{{ session('temp_google_email') }}" readonly class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white/70 cursor-not-allowed" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-white/90 text-sm font-medium mb-1">NIM Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="nim" required placeholder="Masukkan NIM (misal: 24055...)" class="w-full px-4 py-3 bg-white/10 border border-[#D4A853]/50 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-[#D4A853] focus:bg-white/20 transition" />
                        @error('nim') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-white/90 text-sm font-medium mb-1">Nomor Kelompok <span class="text-red-400">*</span></label>
                        <input type="number" name="kelompok" min="1" required placeholder="Contoh: 1, 11" class="w-full px-4 py-3 bg-white/10 border border-[#D4A853]/50 rounded-xl text-white placeholder-white/40 focus:outline-none focus:border-[#D4A853] focus:bg-white/20 transition" />
                        @error('kelompok') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-[#D4A853] hover:bg-[#9b7c3f] active:scale-95 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-[#D4A853]/20">
                        Simpan & Mulai Praktikum →
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>