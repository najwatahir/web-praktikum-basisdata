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