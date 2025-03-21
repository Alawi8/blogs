<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizApiController;
use App\Http\Controllers\QuestionsListController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('api/questions', [QuizApiController::class, 'getQuestions']);
    Route::get('/questions', [QuestionsListController::class, 'index']);
    Route::post('/submit-answer', [QuizApiController::class, 'submitAnswer']);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    //mangment questions
    Route::resource('/questions', AdminQuestionsController::class)->except(['show', 'edit', 'update']);
});



Route::get('admin/questions', function () {
    return view('admin.questions', ['tests' => \App\Models\Test::all()]);
})->name('admin.questions');


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


// import csv file route
// use App\Http\Controllers\CSVImportController;
// Route::post('import-questions', [CSVImportController::class, 'importQuestions']);

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





/**
 * Fetch all quiz questions along with their answers.
 * GET /api/questions
 */


/**
 * Secure route example (requires authentication via Sanctum or Passport)
 * GET /api/user
 */
Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});