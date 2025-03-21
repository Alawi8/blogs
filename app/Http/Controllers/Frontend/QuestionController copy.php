<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        return response()->json(Question::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string'
        ]);

        $question = Question::create($request->all());

        return response()->json($question, 201);
    }

    public function show($id)
    {
        return response()->json(Question::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $question->update($request->all());

        return response()->json($question);
    }

    public function destroy($id)
    {
        Question::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف السؤال بنجاح']);
    }
}

