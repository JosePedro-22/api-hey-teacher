<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\FormQuestions;
use App\Models\questions;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FormQuestions $request)
    {
        dd($request->all());

        questions::created([
            'user_id' => auth()->user()->id,
            'questions' => $request->question
        ]);
    }
}
