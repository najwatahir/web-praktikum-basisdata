<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Laravel\Socialite\Facades\Socialite;
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
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            if (!str_ends_with($googleUser->email, '@student.unud.ac.id')) {
                return redirect('/')->withErrors(['email' => 'Akses ditolak! Kamu wajib menggunakan email kampus (@student.unud.ac.id).']);
            }

            $participant = Participant::where('email', $googleUser->email)->first();

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

        }
    }


    public function completeProfile()
    {
        if (!session('temp_google_email')) {
            return redirect('/');
        }

        return view('participant.complete-profile');
    }

    public function storeProfile(Request $request)
    {
        $request->validate([
            'nim'      => 'required|string|unique:participants,nim',
            'kelompok' => 'required|integer|min:1',
        ]);

        $participant = Participant::create([
            'nim'      => $request->nim,
            'nama'     => session('temp_google_name'),
            'email'    => session('temp_google_email'),
            'kelompok' => $request->kelompok,
        ]);

        session([
            'nim'      => $participant->nim,
            'nama'     => $participant->nama,
            'kelompok' => $participant->kelompok,
            'email'    => $participant->email,
        ]);

        session()->forget(['temp_google_email', 'temp_google_name']);

        return redirect()->route('questions.index')->with('success', 'Profil berhasil disimpan! Selamat datang di ruang praktikum.');
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