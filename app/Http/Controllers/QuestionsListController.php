<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;

class QuestionsListController extends Controller
{
    public function index()
    {
        $questions = Question::with('answers')->get();
        return view('layouts.questions', compact('questions'));
        // return response(Auth::id());

    }
    
    public function store(Request $request) {
        foreach ($request->answers as $questionId => $answerId) {
            UserAnswer::create([
                'user_id' => Auth::id(), // Assuming user authentication
                'question_id' => $questionId,
                'answer_id' => $answerId
            ]);
        }
    
        return response()->json(['message' => 'Answers saved successfully']);
    }
}
