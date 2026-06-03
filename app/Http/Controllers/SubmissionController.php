<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Submission;
use App\Services\SqlSandboxService;
use App\Services\SqlValidatorService;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    // buat test query
    public function test(Request $request)
    {
        if (!session('nim')) {
            return response()->json(['status' => 'error', 'message' => 'Session habis.'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'query'       => 'required|string|max:5000',
        ]);

        $question = Question::with('testCases')->findOrFail($request->question_id);
        
        // ambil test case public (is_hidden = false) untuk diujicobakan
        $publicTestCase = $question->testCases->where('is_hidden', false)->first();

        if (!$publicTestCase) {
            return response()->json(['status' => 'error', 'message' => 'Test case public tidak ditemukan untuk soal ini.'], 404);
        }

        $sandbox  = new SqlSandboxService();
        $result   = $sandbox->run($publicTestCase->schema_sql, $request->input('query'));

        if ($result['status'] === 'error') {
            return response()->json([
                'status'  => 'error',
                'message' => $result['message'],
            ]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Query berhasil dijalankan. Cek hasilnya sebelum submit.',
            'result'  => $result['data'],
        ]);
    }

    // submit query (langsung keluar nilai)
    public function submit(Request $request)
    {
        if (!session('nim')) {
            return response()->json(['status' => 'error', 'message' => 'Session habis.'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'query'       => 'required|string|max:5000',
        ]);

        $nim      = session('nim');
        $question = Question::with('testCases')->findOrFail($request->question_id);

        // poin maksimal dari gabungan test case adalah 100
        $maxScore = 100; 

        // cek apakah sudah pernah dapat 100
        $alreadyPerfect = Submission::where('nim', $nim)
            ->where('question_id', $question->id)
            ->where('score', $maxScore)
            ->exists();

        // hitung attempt
        $attempt = Submission::where('nim', $nim)
            ->where('question_id', $question->id)
            ->count() + 1;

        $sandbox = new SqlSandboxService();
        $validator = new SqlValidatorService();

        $totalScore = 0;
        $isSyntaxError = false;
        $errorMessage = '';
        $finalResultData = null;

        foreach ($question->testCases as $tc) {
            $result = $sandbox->run($tc->schema_sql, $request->input('query'));

            if ($result['status'] === 'error') {
                $isSyntaxError = true;
                $errorMessage = $result['message'];
                break; 
            }

            if (!$tc->is_hidden) {
                $finalResultData = $result['data'];
            }

            $isMatch = $validator->validate(
                $result['data'],
                $tc->expected_output,
                $question->order_matters,
                $request->input('query')
            );

            if ($isMatch) {
                $totalScore += $tc->bobot_poin;
            }
        }

        if ($isSyntaxError) {
            Submission::create([
                'nim'         => $nim,
                'question_id' => $question->id,
                'query'       => $request->input('query'),
                'is_correct'  => false,
                'score'       => 0,
                'attempt'     => $attempt,
                'feedback'    => $errorMessage,
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => $errorMessage,
            ]);
        }

        $isCorrect  = $totalScore == $maxScore;
        $finalScore = $alreadyPerfect ? 0 : $totalScore;
        $feedback   = null;

        Submission::create([
            'nim'         => $nim,
            'question_id' => $question->id,
            'query'       => $request->input('query'),
            'is_correct'  => $isCorrect,
            'score'       => $finalScore,
            'attempt'     => $attempt,
            'feedback'    => $feedback,
        ]);

        return response()->json([
            'status'   => $isCorrect ? 'correct' : ($totalScore > 0 ? 'partial' : 'wrong'),
            'score'    => $finalScore,
            'message'  => $isCorrect
                ? ($alreadyPerfect
                    ? 'Jawaban benar! Tapi kamu sudah pernah mendapat nilai penuh untuk soal ini.'
                    : 'Jawaban sempurna! Berhasil melewati semua Test Case.')
                : ($totalScore > 0
                    ? "Jawaban sebagian benar. Kamu lolos di beberapa Test Case dan mendapat {$finalScore} poin."
                    : 'Jawaban belum tepat. Gagal di semua Test Case.'),
            'feedback' => $feedback,
            'result'   => $finalResultData,
        ]);
    }
}