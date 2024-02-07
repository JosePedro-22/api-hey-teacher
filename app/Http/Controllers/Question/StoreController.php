<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\FormQuestions;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FormQuestions $request)
    {
        $question = Question::create([
            'user_id' => auth()->user()->id,
            'status' => 'draft',
            'question' => $request->question,
        ]);

        return QuestionResource::make($question);
    }
}
