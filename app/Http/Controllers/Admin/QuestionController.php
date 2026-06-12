<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\TestCase;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::withCount('testCases')->orderBy('urutan')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'poin'            => 'required|integer|min:1',
            'urutan'          => 'required|integer|min:1',
            'batas_waktu'     => 'nullable|date',
            'test_cases'      => 'required|array|min:1', // minimal ada 1 test case
            'test_cases.*.nama_test_case'  => 'required|string',
            'test_cases.*.schema_sql'      => 'required|string',
            'test_cases.*.expected_output' => 'required|json', // inputnya harus format JSON valid
            'test_cases.*.bobot_poin'      => 'required|integer|min:1',
            'test_cases.*.is_hidden'       => 'required|boolean',
        ]);

        $publicSchema = $request->test_cases[0]['schema_sql'] ?? '';

        $question = Question::create([
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'poin'            => $request->poin,
            'urutan'          => $request->urutan,
            'batas_waktu'     => $request->batas_waktu,
            'order_matters'   => $request->has('order_matters'),
            'aktif'           => $request->has('aktif'),
            
            'schema_sql'      => $publicSchema,
            'expected_sql'    => '-', // string dummy karena tidak dipakai lagi
            'expected_output' => [],  // array kosong karena udah pindah ke test_cases
        ]);

        foreach ($request->test_cases as $tc) {
            TestCase::create([
                'question_id'     => $question->id,
                'nama_test_case'  => $tc['nama_test_case'],
                'schema_sql'      => $tc['schema_sql'],
                // JSON di decode menjadi array karena di model TestCase pakai $casts => array
                'expected_output' => json_decode($tc['expected_output'], true), 
                'bobot_poin'      => $tc['bobot_poin'],
                'is_hidden'       => $tc['is_hidden'],
            ]);
        }

        return back()->with('success', 'Soal dan Test Case berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $question = \App\Models\Question::findOrFail($id);
        
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'judul'             => 'required|string|max:255',
        'deskripsi'         => 'required|string',
        'poin'              => 'required|integer|min:1',
        'urutan'            => 'nullable|integer',
        'batas_waktu'       => 'nullable|date',
        'expected_query'    => 'nullable|string',
        'required_keywords' => 'nullable|array',
    ]);

    $question = \App\Models\Question::findOrFail($id);

    $question->update([
        'judul'             => $request->judul,
        'deskripsi'         => $request->deskripsi,
        'poin'              => $request->poin,
        'urutan'            => $request->urutan,
        'batas_waktu'       => $request->batas_waktu,
        
        'aktif'             => $request->has('aktif'), 
        'expected_query'    => $request->expected_query,
        'required_keywords' => $request->required_keywords,
    ]);

    return redirect()->route('admin.questions.index')->with('success', 'Semua data soal berhasil diperbarui!');
}

    // buat menghapus soal sama test casenya
    public function destroy($id)
    {
        $question = \App\Models\Question::findOrFail($id);
        
        $question->delete();

        return back()->with('success', 'Soal dummy berhasil dihapus dari sistem!');
    }
}