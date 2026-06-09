<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalParticipants = Participant::count();
        $totalSubmissions  = Submission::count();
        $totalQuestions    = Question::count();
        $totalKelompok     = Participant::distinct('kelompok')->count('kelompok');

        return view('admin.dashboard', compact(
            'totalParticipants',
            'totalSubmissions',
            'totalQuestions',
            'totalKelompok'
        ));
    }

    public function students(Request $request)
    {
        $kelompok = $request->input('kelompok');
        $search   = $request->input('search');

        $query = DB::table('participants')
            ->leftJoin('submissions', function($join) {
                $join->on('participants.nim', '=', 'submissions.nim')
                     ->where('submissions.is_correct', true);
            })
            ->select(
                'participants.nim',
                'participants.nama',
                'participants.kelompok',
                DB::raw('COALESCE(SUM(submissions.score), 0) as total_score'),
                DB::raw('COUNT(DISTINCT submissions.question_id) as solved')
            )
            ->groupBy('participants.nim', 'participants.nama', 'participants.kelompok')
            ->orderByDesc('total_score')
            ->orderBy('participants.kelompok')
            ->orderBy('participants.nim');

        if ($kelompok) {
            $query->where('participants.kelompok', $kelompok);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('participants.nama', 'like', "%{$search}%")
                  ->orWhere('participants.nim', 'like', "%{$search}%");
            });
        }

        $students  = $query->paginate(50)->withQueryString(); 
        $kelompoks = Participant::distinct()->orderBy('kelompok')->pluck('kelompok');

        return view('admin.students.index', compact('students', 'kelompoks', 'kelompok', 'search'));
    }

    public function rekap(Request $request)
    {
        $kelompok = $request->input('kelompok');

        $query = DB::table('participants')
            ->leftJoin('submissions', function($join) {
                $join->on('participants.nim', '=', 'submissions.nim')
                     ->where('submissions.is_correct', true);
            })
            ->select(
                'participants.nim',
                'participants.nama',
                'participants.kelompok',
                DB::raw('COALESCE(SUM(submissions.score), 0) as total_score'),
                DB::raw('COUNT(DISTINCT submissions.question_id) as solved')
            )
            ->groupBy('participants.nim', 'participants.nama', 'participants.kelompok')
            ->orderBy('participants.kelompok')
            ->orderByDesc('total_score');

        if ($kelompok) {
            $query->where('participants.kelompok', $kelompok);
        }

        $rekap     = $query->get();
        $kelompoks = Participant::distinct()->orderBy('kelompok')->pluck('kelompok');
        $questions = Question::orderBy('urutan')->get();

        $scorePerSoal = Submission::where('is_correct', true)
            ->select('nim', 'question_id', DB::raw('MAX(score) as score'))
            ->groupBy('nim', 'question_id')
            ->get()
            ->groupBy('nim');

        $partialScore = Submission::where('is_correct', false)
            ->where('score', '>', 0)
            ->select('nim', 'question_id', DB::raw('MAX(score) as score'))
            ->groupBy('nim', 'question_id')
            ->get()
            ->groupBy('nim');

        return view('admin.rekap', compact(
            'rekap', 'kelompoks', 'kelompok', 'questions', 'scorePerSoal', 'partialScore'
        ));
    }

    public function submissions(Request $request)
    {
        $kelompok   = $request->input('kelompok');
        $questionId = $request->input('question_id');

        $query = Submission::with(['participant', 'question'])
            ->join('participants', 'submissions.nim', '=', 'participants.nim')
            ->select('submissions.*')
            ->orderByDesc('submissions.created_at');

        if ($kelompok) {
            $query->where('participants.kelompok', $kelompok);
        }

        if ($questionId) {
            $query->where('submissions.question_id', $questionId);
        }

        $submissions = $query->paginate(20);
        $kelompoks   = Participant::distinct()->orderBy('kelompok')->pluck('kelompok');
        $questions   = Question::orderBy('urutan')->get();

        return view('admin.submissions', compact(
            'submissions', 'kelompoks', 'questions', 'kelompok', 'questionId'
        ));
    }
}