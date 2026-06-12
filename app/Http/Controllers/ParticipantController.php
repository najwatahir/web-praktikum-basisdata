<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Question;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    // halaman awal
    public function index()
    {
        if (session('nim')) {
            return redirect()->route('questions.index');
        }
        return view('welcome');
    }

    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();
            
            // Validasi email kampus sudah dihapus di sini, bebas pakai email apa saja.

            $participant = \App\Models\Participant::where('email', $googleUser->email)->first();

            if ($participant) {
                session([
                    'nim'      => $participant->nim,
                    'nama'     => $participant->nama,
                    'kelompok' => $participant->kelompok,
                    'email'    => $participant->email,
                ]);
                return redirect()->route('questions.index')->with('success', 'Selamat datang kembali di ruang praktikum!');
            } else {
                session([
                    'temp_google_email' => $googleUser->email,
                    'temp_google_name'  => $googleUser->name,
                ]);
                return redirect()->route('participant.complete_profile');
            }

        } catch (\Exception $e) {
            return redirect('/')->withErrors(['email' => 'Gagal terhubung dengan Google. Silakan coba lagi. Error: ' . $e->getMessage()]);
        }
    }

    public function storeProfile(Request $request)
    {
        // 1. Validasi inputan mahasiswa (NIM wajib unik biar nggak ada yang double)
        $request->validate([
            'nim'      => 'required|string|unique:participants,nim',
            'kelompok' => 'required|integer|min:1',
        ], [
            'nim.unique' => 'NIM ini sudah terdaftar. Silakan hubungi asisten jika ini adalah kesalahan.'
        ]);

        // 2. Ambil Email dan Nama yang tadi dititipkan sementara oleh Google
        $email = session('temp_google_email');
        $nama  = session('temp_google_name');

        // Keamanan tambahan: Cegah mahasiswa iseng ngetik URL /complete-profile secara manual
        if (!$email || !$nama) {
            return redirect('/')->with('error', 'Sesi pendaftaran tidak valid. Silakan login menggunakan Google terlebih dahulu.');
        }

        // 3. Simpan data lengkapnya ke Database
        $participant = \App\Models\Participant::create([
            'nim'      => $request->nim,
            'nama'     => $nama, // Nama otomatis dari Google
            'email'    => $email, // Email otomatis dari Google
            'kelompok' => $request->kelompok,
        ]);

        // 4. Ubah statusnya menjadi "Sudah Login Resmi" dengan mendaftarkan Session utama
        session([
            'nim'      => $participant->nim,
            'nama'     => $participant->nama,
            'kelompok' => $participant->kelompok,
            'email'    => $participant->email,
        ]);

        // 5. Bersihkan sampah session sementara agar memori lega
        session()->forget(['temp_google_email', 'temp_google_name']);

        // 6. Buka pintu gerbang menuju soal praktikum!
        return redirect()->route('questions.index')->with('success', 'Profil berhasil disimpan! Selamat mengerjakan praktikum.');
    }

    // proses join
    public function join(Request $request)
    {
        $request->validate([
            'nim'      => 'required|string|max:20',
            'nama'     => 'required|string|max:100',
            'kelompok' => 'required|integer|min:0|max:25',
        ], [
            'kelompok.min' => 'Nomor kelompok minimal 1.',
            'kelompok.max' => 'Nomor kelompok maksimal 25.',
        ]);

        // simpan atau update data peserta
        $participant = Participant::updateOrCreate(
            ['nim' => $request->nim],
            [
                'nama'     => $request->nama,
                'kelompok' => $request->kelompok,
            ]
        );

        // simpan ke session
        session([
            'nim'      => $participant->nim,
            'nama'     => $participant->nama,
            'kelompok' => $participant->kelompok,
        ]);

        // kelompok 00 = admin, redirect ke login admin
        if ($request->kelompok == 0) {
            return back()->withErrors(['kelompok' => 'Nomor kelompok 00 tidak tersedia untuk peserta.',])->withInput();
}

        return redirect()->route('questions.index');
    }

    // daftar soal
    public function questions()
    {
        $questions = Question::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        // ambil skor tertinggi per soal untuk mahasiswa ini
        $userScores = \App\Models\Submission::where('nim', session('nim'))
            ->select('question_id', \Illuminate\Support\Facades\DB::raw('MAX(score) as max_score'))
            ->groupBy('question_id')
            ->pluck('max_score', 'question_id')
            ->toArray();

        return view('participant.questions', compact('questions', 'userScores'));
    }

    // halaman kerjakan soal
    public function solve($id)
    {
        $question = Question::where('aktif', true)->findOrFail($id);

        $lastSubmission = \App\Models\Submission::where('nim', session('nim'))
            ->where('question_id', $id)
            ->latest()
            ->first();

        return view('participant.solve', compact('question', 'lastSubmission'));
    }

    public function logout()
{
    session()->forget(['nim', 'nama', 'kelompok']);
    return redirect()->route('home');
}
}