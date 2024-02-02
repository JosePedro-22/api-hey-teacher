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
    postJson(route('question.store', [
        'question' => 'Teste Teste Teste ?'
    ]))->assertSuccessful();

    //buscando no banco de dados na tabela question a questao
    assertDatabaseHas('question', [
        'user_id' => $user->id,
        'question' => 'Teste Teste Teste ?'
    ]);
});

it('after create a new question, create a status that draft', function () {
    //criando um user
    $user = User::factory()->create();

    //logando o user
    Sanctum::actingAs($user);

    //fazendo um post de uma new question
    postJson(route('question.store', [
        'question' => 'Teste Teste Teste ?'
    ]))->assertSuccessful();

    //buscando no banco de dados na tabela question a questao
    assertDatabaseHas('question', [
        'user_id' => $user->id,
        'status' => 'draft',
        'question' => 'Teste Teste Teste ?'
    ]);
});

describe('validation rules', function () {

    test('question::required', function () {
        //criando um user
        $user = User::factory()->create();

        //logando o user
        Sanctum::actingAs($user);

        //fazendo um post de uma new question
        postJson(route('question.store', []))
            ->assertJsonValidationErrors([
                'question' => 'required'
            ]);
    });

});
