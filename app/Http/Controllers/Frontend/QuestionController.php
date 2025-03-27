<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request, $testId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'exists:answers,id',
        ]);

        // حساب النتيجة
        $score = 0;
        foreach ($validated['answers'] as $questionId => $answerId) {
            $question = Question::find($questionId);
            if ($question && $question->answers()->where('id', $answerId)->where('is_correct', true)->exists()) {
                $score++;
            }
        }

        return redirect()->route('quizzes.index')->with('success', "تم إرسال الاختبار! نتيجتك: $score / " . count($validated['answers']));
    }
}
