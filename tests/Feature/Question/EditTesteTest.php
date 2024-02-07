<?php

use App\Models\Question;
use App\Models\User;
use Database\Factories\QuestionFactory;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

it('should be able to update a question', function () {
    //criando um user
    $user = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    //logando o user
    Sanctum::actingAs($user);

    //fazendo um post de uma new question
    putJson(route('question.update', $question), [
        'question' => 'Updating question?'
    ])->assertOk();

    //buscando no banco de dados na tabela question a questao
    assertDatabaseHas('question', [
        'id' => $question->id,
        'user_id' => $user->id,
        'question' => 'Updating question?'
    ]);
});
