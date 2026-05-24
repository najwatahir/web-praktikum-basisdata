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
    // ── TEST: jalankan query tapi tidak simpan skor ──
    public function test(Request $request)
    {
        if (!session('nim')) {
            return response()->json(['status' => 'error', 'message' => 'Session habis.'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'query'       => 'required|string|max:5000',
        ]);

        $question = Question::findOrFail($request->question_id);
        $sandbox  = new SqlSandboxService();
        $result   = $sandbox->run($question->schema_sql, $request->input('query'));

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

    // ── SUBMIT: jalankan query dan simpan skor ──
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
        $question = Question::findOrFail($request->question_id);

        // Cek apakah sudah pernah dapat 100
        $alreadyPerfect = Submission::where('nim', $nim)
            ->where('question_id', $question->id)
            ->where('score', $question->poin)
            ->exists();

        // Hitung attempt
        $attempt = Submission::where('nim', $nim)
            ->where('question_id', $question->id)
            ->count() + 1;

        // Jalankan di sandbox
        $sandbox = new SqlSandboxService();
        $result  = $sandbox->run($question->schema_sql, $request->input('query'));

        // Error syntax
        if ($result['status'] === 'error') {
            Submission::create([
                'nim'         => $nim,
                'question_id' => $question->id,
                'query'       => $request->input('query'),
                'is_correct'  => false,
                'score'       => 0,
                'attempt'     => $attempt,
                'feedback'    => $result['message'],
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => $result['message'],
            ]);
        }

        // Hitung skor
        $validator = new SqlValidatorService();
        $score     = $validator->score(
            $result['data'],
            $question->expected_output,
            $question->order_matters
        );

        $isCorrect = $score === 100;
        $finalScore = $alreadyPerfect ? 0 : $score;
        $feedback   = null;

        // Kalau tidak sempurna, minta hint dari Gemini
        if (!$isCorrect) {
            try {
                $gemini   = new GeminiService();
                $feedback = $gemini->getFeedback(
                    $question->deskripsi,
                    $request->input('query')
                );
            } catch (\Exception $e) {
                $feedback = 'Coba periksa kembali query kamu.';
            }
        }

        // Simpan submission
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
    'status'   => $isCorrect ? 'correct' : ($score > 0 ? 'partial' : 'wrong'),
    'score'    => $finalScore,
    'message'  => $isCorrect
        ? ($alreadyPerfect
            ? 'Jawaban benar! Tapi kamu sudah pernah mendapat nilai penuh untuk soal ini.'
            : 'Jawaban benar!')
        : ($score > 0
            ? "Jawaban sebagian benar. Kamu mendapat {$finalScore} poin."
            : 'Jawaban belum tepat.'),
    'feedback' => $feedback,
    'result'   => $result['data'],
]);
    }
}