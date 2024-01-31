<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('should be able to store a new question', function () {
    //criando um user
    $user = User::factory()->create();

    //logando o user
    Sanctum::actingAs($user);

    //fazendo um post de uma new question
    postJson(route('questions.store', [
        'question' => 'Teste Teste Teste ?'
    ]))->assertSuccessful();

    //buscando no banco de dados na tabela questions a questao
    assertDatabaseHas('questions', [
        'user_id' => $user->id,
        'questions' => 'Teste Teste Teste ?'
    ]);
});
