<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;

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




    public function finalResult()
    {
        $totalQuestions = UserAnswer::where('user_id', Auth::id())->count();
        $correctAnswers = UserAnswer::where('user_id', Auth::id())->where('is_correct', true)->count();

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        return response()->json([
            'score' => $score,
            'correct' => $correctAnswers,
            'total' => $totalQuestions,
        ]);
    }
}
