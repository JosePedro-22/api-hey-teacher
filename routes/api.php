<?php

use App\Http\Controllers\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', function () {
    return User::get();
});

Route::middleware('auth:sanctum')->group(function () {

    //started create a new question
    Route::post('/question', Question\StoreController::class)->name('question.store');
    //end question

    //started updating a question
    Route::put('/question/{question}', Question\UpdateController::class)->name('question.update');
    //end updating a question
});
