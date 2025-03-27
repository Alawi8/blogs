<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Test;

class AdminQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('test')->get();
        return view('admin.questions_list', compact('questions'));
    }

    public function create()
    {
        $tests = Test::all();
        return view('admin.questions', compact('tests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
            'question_text' => 'required|string|max:255',
        ]);

        Question::create([
            'test_id' => $request->test_id,
            'question_text' => $request->question_text,
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تمت إضافة السؤال بنجاح!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', 'تم حذف السؤال بنجاح!');
    }
}
