<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\FormQuestions;
use App\Models\Question;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FormQuestions $request)
    {
        Question::create([
            'user_id' => auth()->user()->id,
            'status' => 'draft',
            'question' => $request->question,
        ]);
    }
}
