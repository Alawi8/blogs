<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use Carbon\Carbon;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // ✅ إنشاء اختبار أو جلبه لو موجود
        $test = Test::firstOrCreate(
            ['title' => 'Medical Test'], // شرط التحقق
            [
                'description' => 'A test about medical knowledge',
                'duration' => 30, // دقيقة
            ]
        );

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
            $question = $test->questions()->create([
                'question_text' => $questionText,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            $correctIndex = rand(1, 4);

            for ($i = 1; $i <= 4; $i++) {
                $question->answers()->create([
                    'answer_text' => "Option $i",
                    'is_correct' => $i === $correctIndex,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }

        echo "✅ Seeded medical test with questions and answers.\n";
    }
}
