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
        $kelompoks = \App\Models\Participant::distinct()->orderBy('kelompok')->pluck('kelompok');

        $query = \App\Models\Participant::leftJoin('submissions', function($join) {
                $join->on('participants.nim', '=', 'submissions.nim')
                     ->where('submissions.is_correct', true); 
            })
            ->select(
                'participants.nim',
                'participants.nama',
                'participants.kelompok',
                'participants.email',
                \DB::raw('COALESCE(SUM(submissions.score), 0) as total_score'),
                \DB::raw('COUNT(DISTINCT submissions.question_id) as solved'),
                \DB::raw('MAX(submissions.created_at) as last_solved_at') 
            )
            ->groupBy(
                'participants.nim', 
                'participants.nama', 
                'participants.kelompok',
                'participants.email'
            );

        if ($request->filled('kelompok')) {
            $query->where('participants.kelompok', $request->input('kelompok'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('participants.nama', 'like', "%{$search}%")
                  ->orWhere('participants.nim', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('total_score', 'desc') 
            ->orderBy('last_solved_at', 'asc') 
            ->orderBy('participants.kelompok', 'asc')
            ->paginate(50);

        return view('admin.students.index', compact('students', 'kelompoks'));
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

        if ($kelompok !== null && $kelompok !== '') {
            $query->where('participants.kelompok', $kelompok);
        }

        $rekap     = $query->get();
        $kelompoks = Participant::distinct()->orderBy('kelompok')->pluck('kelompok');
        $questions = Question::orderBy('urutan')->get();

        // Ambil skor per soal per peserta
        $scorePerSoal = Submission::where('is_correct', true)
            ->select('nim', 'question_id', DB::raw('MAX(score) as score'))
            ->groupBy('nim', 'question_id')
            ->get()
            ->groupBy('nim');

        // Tambah partial score juga
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

        if ($kelompok !== null && $kelompok !== '') {
            $query->where('participants.kelompok', $kelompok);
        }

        if ($questionId !== null && $questionId !== '') {
            $query->where('submissions.question_id', $questionId);
        }

        $submissions = $query->paginate(20);
        $kelompoks   = Participant::distinct()->orderBy('kelompok')->pluck('kelompok');
        $questions   = Question::orderBy('urutan')->get();

        return view('admin.submissions', compact(
            'submissions', 'kelompoks', 'questions', 'kelompok', 'questionId'
        ));
    }

    public function exportFirstAttempt(Request $request)
    {
        $kelompok   = $request->input('kelompok');
        $questionId = $request->input('question_id');

        $query = Submission::with(['participant', 'question'])
            ->join('participants', 'submissions.nim', '=', 'participants.nim')
            ->select('submissions.*')
            ->where('submissions.attempt', 1)
            ->orderBy('submissions.created_at', 'asc');

        if ($kelompok !== null && $kelompok !== '') {
            $query->where('participants.kelompok', $kelompok);
        }

        if ($questionId !== null && $questionId !== '') {
            $query->where('submissions.question_id', $questionId);
        }

        $submissions = $query->get();

        $filename = "submissions_first_attempt_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Timestamp', 'NIM', 'Nama', 'Kelompok', 'Soal ID', 'Judul Soal', 'Query', 'Attempt', 'Is Correct', 'Score'];

        $callback = function() use($submissions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($submissions as $sub) {
                $row = [
                    $sub->created_at,
                    $sub->participant->nim ?? '-',
                    $sub->participant->nama ?? '-',
                    $sub->participant->kelompok ?? '-',
                    $sub->question_id,
                    $sub->question->judul ?? '-',
                    $sub->query,
                    $sub->attempt,
                    $sub->is_correct ? 'Yes' : 'No',
                    $sub->score
                ];
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}