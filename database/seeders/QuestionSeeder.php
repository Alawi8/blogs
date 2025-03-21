<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;

class QuestionSeeder extends Seeder
{
    /**
     * update db to create qustions and answers 
     */
    public function run()
    {
        $medicalQuestions = [
            "What is the function of the liver in detoxification?",
            "Which organ is responsible for oxygenating blood?",
            "What is the primary cause of Type 2 Diabetes?",
            "Which vitamin is necessary for blood clotting?",
            "How does high blood pressure affect the heart over time?",
            "Which brain part regulates balance and coordination?",
            "What is a common symptom of a heart attack?",
            "Which hormone controls blood sugar levels?",
            "What is the medical term for high blood pressure?",
            "What is the leading cause of kidney disease globally?"
        ];

        $now = Carbon::now();

        foreach ($medicalQuestions as $questionText) {
            // إنشاء السؤال في جدول `questions`
            $question = Question::create([
                'test_id' => 1, // تأكد من أن لديك اختبار رقم 1
                'question_text' => $questionText,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            // 
            $correctAnswerIndex = rand(1, 4);

            // create 
            for ($i = 1; $i <= 4; $i++) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer_text' => "Option $i",
                    'is_correct' => ($i === $correctAnswerIndex) ? true : false,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }
    }
}
