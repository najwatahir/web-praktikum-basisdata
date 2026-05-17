<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = DB::table('submissions')
            ->join('participants', 'submissions.nim', '=', 'participants.nim')
            ->select(
                'participants.nim',
                'participants.nama',
                'participants.kelompok',
                DB::raw('SUM(submissions.score) as total_score'),
                DB::raw('COUNT(CASE WHEN submissions.is_correct = 1 THEN 1 END) as solved'),
                DB::raw('MAX(submissions.created_at) as last_submission')
            )
            ->where('submissions.is_correct', true)
            ->groupBy('participants.nim', 'participants.nama', 'participants.kelompok')
            ->orderByDesc('total_score')
            ->orderBy('last_submission')
            ->get();

        return view('leaderboard.index', compact('leaderboard'));
    }
}