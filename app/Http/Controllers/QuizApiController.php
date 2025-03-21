<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuizApiController extends Controller
{
    /**
     * Retrieve all quiz questions along with their possible answers.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions()
    {
        // Fetch all questions with their related answers
        $questions = Question::with('answers')->get();

        // Return the data as a JSON response
        return response()->json($questions);
    }

    /**
     * Store or update user-submitted answers for the quiz.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);
    
        $answer = Answer::find($request->answer_id);
    
        $userAnswer = UserAnswer::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'question_id' => $request->question_id,
            ],
            [
                'answer_id' => $answer->id,
                'is_correct' => $answer->is_correct,
            ]
        );
    
        return response()->json([
            'message' => 'تم حفظ الإجابة',
            'correct' => $answer->is_correct,
        ]);
    }
    public function finalResult(){
    $totalQuestions = UserAnswer::where('user_id', auth()->id())->count();
    $correctAnswers = UserAnswer::where('user_id', auth()->id())->where('is_correct', true)->count();

    $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

    return response()->json([
        'score' => $score,
        'correct' => $correctAnswers,
        'total' => $totalQuestions,
    ]);
    }

}