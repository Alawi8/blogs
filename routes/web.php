<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizApiController;
use App\Http\Controllers\QuestionsListController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\QuestionController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('home');

// dashboard routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

//  qustions && answers routes
// use App\Http\Controllers\UserAnswersController;
// Route::middleware(["auth","role:admin"])->group(function(){
//     Route::get('/questions', [QuestionsListController::class, 'index'])->middleware('qnf');
//     Route::get('api/questions', [QuizApiController::class, 'getQuestions']);
//     Route::post('api/submit-answer', [UserAnswersController::class, 'submitAnswer']);
//     Route::get('/api/user-answers', [UserAnswerSController::class, 'getUserAnswers']);
//     Route::get('/api/final-result', [QuizApiController::class, 'finalResult']);
//     Route::post('/api/clear-answers', [UserAnswersController::class, 'clearAnswers']);

//     Route::get('/tests', [TestController::class, 'index'])->name('admin.tests');
//     Route::post('/tests', [TestController::class, 'store'])->name('admin.tests.store');
//     Route::get('/admin/tests/{test}/questions', [TestController::class, 'questions'])->name('admin.tests.questions');
//     // Route::resource('admin/questions', QuestionController::class)->names('admin.questions');

// });
// route admin page
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/questions/index', 'admin.questions.index')->name('about');
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


use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;





