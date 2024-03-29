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
    Route::post('/questions', Question\StoreController::class)->name('questions.store');
    //end question
});
