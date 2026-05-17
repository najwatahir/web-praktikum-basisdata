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
    public function submit(Request $request)
    {
        // Cek session
        if (!session('nim')) {
            return response()->json(['status' => 'error', 'message' => 'Session habis, silakan login ulang.'], 401);
        }

        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'query'       => 'required|string|max:5000',
        ]);

        $nim      = session('nim');
        $question = Question::findOrFail($request->question_id);

        // Hitung attempt ke berapa
        $attempt = Submission::where('nim', $nim)
            ->where('question_id', $question->id)
            ->count() + 1;

        // Jalankan query di sandbox
        $sandbox = new SqlSandboxService();
        $result  = $sandbox->run($question->schema_sql, $request->query);

        // Kalau error syntax
        if ($result['status'] === 'error') {
            // Simpan submission yang error
            Submission::create([
                'nim'         => $nim,
                'question_id' => $question->id,
                'query'       => $request->query,
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

        // Validasi hasil
        $validator = new SqlValidatorService();
        $isCorrect = $validator->validate(
            $result['data'],
            $question->expected_output,
            $question->order_matters
        );

        $feedback = null;
        $score    = 0;

        if ($isCorrect) {
            // Cek apakah sudah pernah benar sebelumnya
            $alreadySolved = Submission::where('nim', $nim)
                ->where('question_id', $question->id)
                ->where('is_correct', true)
                ->exists();

            // Skor hanya dihitung sekali
            $score = $alreadySolved ? 0 : $question->poin;

        } else {
            // Panggil Gemini untuk feedback
            try {
                $gemini   = new GeminiService();
                $feedback = $gemini->getFeedback(
                    $question->deskripsi,
                    $request->query
                );
            } catch (\Exception $e) {
                $feedback = 'Coba periksa kembali query kamu.';
            }
        }

        // Simpan submission
        Submission::create([
            'nim'         => $nim,
            'question_id' => $question->id,
            'query'       => $request->query,
            'is_correct'  => $isCorrect,
            'score'       => $score,
            'attempt'     => $attempt,
            'feedback'    => $feedback,
        ]);

        return response()->json([
            'status'   => $isCorrect ? 'correct' : 'wrong',
            'message'  => $isCorrect ? 'Jawaban benar! 🎉' : 'Jawaban belum tepat.',
            'score'    => $score,
            'feedback' => $feedback,
            'result'   => $result['data'],
        ]);
    }
}