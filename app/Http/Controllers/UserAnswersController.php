<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class userAnswersController extends Controller
{
    public function submitAnswer(Request $request)
    {
        // validation 
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
        ]);

        // fetch answer from db 
        $answer = Answer::where('id', $validated['answer_id'])
            ->where('question_id', $validated['question_id']) // check answer and questions 
            ->first();

        // answer is currect ?
        if (!$answer) {
            return response()->json([
                'message' => 'Invalid answer for this question.'
            ], 422);
        }

        // save or update answer 
        UserAnswer::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'question_id' => $validated['question_id'],
            ],
            [
                'answer_id' => $answer->id,
                'is_correct' => $answer->is_correct,
            ]
        );

        return response()->json([
            'message' => 'Answer saved successfully.',
            'correct' => $answer->is_correct,
        ]);
    }

    public function getUserAnswers()
    {
        $userId = Auth::id();

        $answers = UserAnswer::where('user_id', $userId)
            ->select('question_id', 'answer_id')
            ->with('answer')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->question_id => $item->answer->answer_text];
            });

        return response()->json($answers);
    }

    public function clearAnswers(Request $request)
    {
        $userId = Auth::id(); 
        UserAnswer::where('user_id', $userId)->delete();
        return response()->json(['message' => 'Answers cleared']);
    }
}
