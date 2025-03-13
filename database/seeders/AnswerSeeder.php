<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;

class TestSeeder extends Seeder
{
    public function run()
    {
        $test = Test::create([
            'title' => 'اختبار تجريبي',
            'description' => 'هذا اختبار تجريبي يحتوي على بعض الأسئلة.'
        ]);

        $question1 = Question::create([
            'test_id' => $test->id,
            'question_text' => 'ما هي عاصمة فرنسا؟'
        ]);

        Answer::create(['question_id' => $question1->id, 'answer_text' => 'باريس', 'is_correct' => true]);
        Answer::create(['question_id' => $question1->id, 'answer_text' => 'لندن', 'is_correct' => false]);
        Answer::create(['question_id' => $question1->id, 'answer_text' => 'روما', 'is_correct' => false]);

        $question2 = Question::create([
            'test_id' => $test->id,
            'question_text' => 'كم عدد الكواكب في المجموعة الشمسية؟'
        ]);

        Answer::create(['question_id' => $question2->id, 'answer_text' => '8', 'is_correct' => true]);
        Answer::create(['question_id' => $question2->id, 'answer_text' => '9', 'is_correct' => false]);
        Answer::create(['question_id' => $question2->id, 'answer_text' => '7', 'is_correct' => false]);
    }
}
