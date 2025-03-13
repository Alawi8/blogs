<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Test;
use App\Models\Answer;

class QuizComponent extends Component
{
    public $test;
    public $answers = [];
    public $score = null;

    public function mount($id)
    {
        $this->test = Test::with('questions.answers')->findOrFail($id);
    }

    public function submitQuiz()
    {
        $correctAnswers = 0;
        $totalQuestions = count($this->test->questions);

        foreach ($this->test->questions as $question) {
            if (isset($this->answers[$question->id])) {
                $selectedAnswer = Answer::find($this->answers[$question->id]);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $correctAnswers++;
                }
            }
        }

        $this->score = "$correctAnswers / $totalQuestions";
    }

    public function render()
    {
        return view('livewire.quiz-component');
    }
}

