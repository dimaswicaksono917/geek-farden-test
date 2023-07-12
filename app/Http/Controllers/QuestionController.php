<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', null);

        $query = Question::query();

        if ($limit !== null && is_numeric($limit)) {
            $query->take($limit);
        }

        $questions = $query->get();

        return response()->json(['questions' => $questions], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'options' => 'required|array',
            'correct_option' => 'required|integer|min:0|max:' . (count($request->input('options')) - 1),
        ]);

        $question = Question::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'options' => $validatedData['options'],
            'correct_option' => $validatedData['correct_option'],
        ]);

        return response()->json(['message' => 'Pertanyaan berhasil dibuat', 'question' => $question], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Pertanyaan tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'attributes' => 'required|array',
        ]);

        $question = Question::findOrFail($id);

        $question->fill($validatedData['attributes']);
        $question->save();

        return response()->json(['message' => 'Pertanyaan berhasil diperbarui', 'question' => $question], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        return response()->json(['message' => 'Pertanyaan berhasil dihapus'], 200);
    }
}
