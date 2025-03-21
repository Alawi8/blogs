<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;

class QuestionsListController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();
        return view('layouts.questions', compact('questions'));

    }
    
    public function store(Request $request) {
        foreach ($request->answers as $questionId => $answerId) {
            UserAnswer::create([
                'user_id' => auth()->id(), // Assuming user authentication
                'question_id' => $questionId,
                'answer_id' => $answerId
            ]);
        }
    
        return response()->json(['message' => 'Answers saved successfully']);
    }
}
