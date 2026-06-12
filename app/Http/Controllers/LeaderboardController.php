<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // Pastikan ini ada

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = DB::table('participants')
            // Pakai Left Join agar yang poinnya 0 tetap masuk daftar
            ->leftJoin('submissions', function($join) {
                $join->on('participants.nim', '=', 'submissions.nim')
                     ->where('submissions.is_correct', true); // Hanya hitung skor dari jawaban yang benar
            })
            ->select(
                'participants.nim',
                'participants.nama',
                'participants.email',
                'participants.kelompok',
                DB::raw('COALESCE(SUM(submissions.score), 0) as total_score'),
                // Pakai DISTINCT agar kalau praktikan iseng submit jawaban benar berkali-kali di soal yang sama, hitungan solved-nya nggak jebol
                DB::raw('COUNT(DISTINCT submissions.question_id) as solved'), 
                DB::raw('MAX(submissions.created_at) as last_submission')
            )
            ->groupBy(
                'participants.nim', 
                'participants.nama', 
                'participants.email', // <-- Tambahkan email di sini agar tidak SQL Error!
                'participants.kelompok'
            )
            ->orderByDesc('total_score') // Urutkan berdasarkan poin tertinggi
            ->orderBy('last_submission', 'asc') // Tie-breaker: Yang duluan submit benar ditaruh di atas
            ->orderBy('participants.nim', 'asc')
            ->get();

        return view('leaderboard.index', compact('leaderboard'));
    }
}