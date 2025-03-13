<?php

use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// create and desplay questions 
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionsController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // استخدام Route::resource لإدارة الأسئلة
    Route::resource('/questions', AdminQuestionsController::class)->except(['show', 'edit', 'update']);
});



Route::get('admin/questions', function () {
    return view('admin.questions', ['tests' => \App\Models\Test::all()]);
})->name('admin.questions');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


use Spatie\Permission\Middleware\PermissionMiddleware;

// admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// editor routes
Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/editor-dashboard', function () {
        return view('editor.dashboard');
    })->name('editor.dashboard');
});

Route::get('/test/{id}', function ($id) {
    return view('frontend.test', ['id' => $id]);
});

// quiz routes
use App\Http\Controllers\Frontend\QuizController;
use App\Http\Controllers\Frontend\QuizAttemptController;

Route::prefix('quizzes')->name('quizzes.')->group(function () {
    Route::get('/', [QuizController::class, 'index'])->name('index'); // عرض قائمة الاختبارات
    Route::get('/{test}', [QuizController::class, 'show'])->name('show'); // بدء الاختبار
    Route::post('/submit/{test}', [QuizAttemptController::class, 'store'])->name('submit'); // إرسال الإجابات
});


// import csv file route
use App\Http\Controllers\CSVImportController;
Route::post('import-questions', [CSVImportController::class, 'importQuestions']);

use Illuminate\Http\Request;
use App\Models\Answer;

Route::post('/submit-test/{id}', function (Request $request, $id) {
    $correctAnswers = 0;
    $totalQuestions = count($request->except('_token'));

    foreach ($request->except('_token') as $questionId => $answerId) {
        $answer = Answer::where('id', $answerId)->where('is_correct', true)->first();
        if ($answer) {
            $correctAnswers++;
        }
    }

    return redirect()->back()->with('message', "لقد أجبت على $correctAnswers من أصل $totalQuestions إجابة صحيحة!");
});

// // quiz routes
use App\Models\Test;
Route::get('/test/{id}', function ($id) {
    $test = Test::with('questions.answers')->findOrFail($id);
    return view('frontend.test', compact('test'));
});

