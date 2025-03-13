<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        return view('frontend.quiz', compact('tests'));
    }

    public function show($id)
    {
        $test = Test::with('questions.answers')->findOrFail($id);
        return view('frontend.take_quiz', compact('test'));
    }
}
