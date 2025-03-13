<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        Question::create([
            'test_id' => 1,
            'question_text' => 'ما هو الإصدار الأخير من PHP؟'
        ]);

        Question::create([
            'test_id' => 1,
            'question_text' => 'ما الفرق بين `include` و `require` في PHP؟'
        ]);
    }
}
