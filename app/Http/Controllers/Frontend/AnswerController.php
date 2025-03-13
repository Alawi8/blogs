<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function index()
    {
        return response()->json(Answer::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string',
            'is_correct' => 'required|boolean'
        ]);

        $answer = Answer::create($request->all());

        return response()->json($answer, 201);
    }

    public function show($id)
    {
        return response()->json(Answer::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);
        $answer->update($request->all());

        return response()->json($answer);
    }

    public function destroy($id)
    {
        Answer::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الإجابة بنجاح']);
    }
}

