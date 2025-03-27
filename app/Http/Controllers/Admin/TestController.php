<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return view('admin.tests.index', compact('tests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $test = Test::create([
            'title' => $request->title,
        ]);

        return response()->json(['test' => $test]);
    }

    public function questions(Test $test)
    {
        $questions = $test->questions()->with('answers')->get();

        return view('admin.tests.questions', compact('test', 'questions'));
    }

    public function storeQuestion(Request $request, Test $test)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'answers' => 'required|array|size:4',
            'correct_answer' => 'required|integer|min:0|max:3',
        ]);

        $question = $test->questions()->create([
            'question_text' => $validated['question_text'],
        ]);

        foreach ($validated['answers'] as $i => $text) {
            $question->answers()->create([
                'answer_text' => $text,
                'is_correct' => $i === $validated['correct_answer'],
            ]);
        }

        $question->load('answers');

        return response()->json(['question' => $question]);
    }
}
