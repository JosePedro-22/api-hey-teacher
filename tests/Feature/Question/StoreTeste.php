<?php

use App\Models\Question;
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
        'question' => 'Lorem ipsum, jose pedro ?'
    ]))->assertSuccessful();

    //buscando no banco de dados na tabela question a questao
    assertDatabaseHas('question', [
        'user_id' => $user->id,
        'question' => 'Lorem ipsum, jose pedro ?'
    ]);
});

it('with the creation of the question, we need to make sure that it creates with status _draft_', function () {
    //criando um user
    $user = User::factory()->create();

    //logando o user
    Sanctum::actingAs($user);

    //fazendo um post de uma new question
    postJson(route('question.store', [
        'question' => 'Lorem ipsum, jose pedro ?'
    ]))->assertSuccessful();

    //buscando no banco de dados na tabela question a questao
    assertDatabaseHas('question', [
        'user_id' => $user->id,
        'status' => 'draft',
        'question' => 'Lorem ipsum, jose pedro ?'
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

    test('question::ending with question mark', function () {

        $user = User::factory()->create();


        Sanctum::actingAs($user);

        postJson(route('question.store', [
            'question' => 'Question without a question mark'
        ]))
            ->assertJsonValidationErrors([
                'question' => 'The :atributes should end with question mark (?).'
            ]);

    });

    test('question::min characters should be 10', function () {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('question.store', [
            'question' => 'Question?'
        ]))
            ->assertJsonValidationErrors([
                'question' => 'The question field must be at least 10 characters.',
            ]);

    });

    test('question::should be unique', function () {

        $user = User::factory()->create();

        Question::factory()->create(
            [
                'question' => 'Lorem ipsum, jose pedro ?',
                'status' => 'draft',
                'user_id' => $user->id
            ]
        );

        Sanctum::actingAs($user);

        postJson(route('question.store', [
            'question' => 'Lorem ipsum, jose pedro ?'
        ]))
            ->assertJsonValidationErrors([
                'question' => 'The question has already been taken.'
            ]);

    });
});

test('after creating we return a status 201 with the created question', function () {
    //criando um user
    $user = User::factory()->create();

    //logando o user
    Sanctum::actingAs($user);

    //fazendo um post de uma new question
    $request = postJson(route('question.store', [
        'question' => 'Lorem ipsum, jose pedro ?'
    ]))->assertCreated();

    $question = Question::latest()->first();

    $request->assertJson([
        'data' => [
            'id' => $question->id,
            'question' => $question->question,
            'status' => $question->status,
            'created_by' => [
                'user_id' => $user->id,
                'name' => $user->name,
            ],
            'created_at' => $question->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $question->updated_at->format('Y-m-d H:i:s'),
        ]
    ]);
});
