<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsListController;
use App\Http\Controllers\QuizApiController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\UserAnswersController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware(["auth","role:admin"])->group(function(){
    Route::get('/questions', [QuestionsListController::class, 'index'])->middleware('qnf');
    Route::get('/questions', [QuizApiController::class, 'getQuestions']);
    Route::post('/submit-answer', [UserAnswersController::class, 'submitAnswer']);
    Route::get('/user-answers', [UserAnswerSController::class, 'getUserAnswers']);
    Route::get('/final-result', [QuizApiController::class, 'finalResult']);
    Route::post('/clear-answers', [UserAnswersController::class, 'clearAnswers']);

    Route::get('/tests', [TestController::class, 'index'])->name('admin.tests');
    Route::post('/tests', [TestController::class, 'store'])->name('admin.tests.store');
    Route::get('/admin/tests/{test}/questions', [TestController::class, 'questions'])->name('admin.tests.questions');
    Route::resource('admin/questions', QuestionController::class)->names('admin.questions');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/users/roles', [UserRoleController::class, 'index'])->name('roles.users');
    Route::post('/users/{id}/roles', [UserRoleController::class, 'update'])->name('roles.users.update');
});