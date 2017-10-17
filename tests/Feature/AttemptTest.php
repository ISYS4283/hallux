<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\QueryQuiz;
use App\User;

class AttemptTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_attempt_query_quiz()
    {
        $qq = create(QueryQuiz::class);

        $user = create(User::class);

        $this
            ->signIn($user)
            ->post("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}", [
                'sql' => $qq->qquery->sql,
            ])
        ;

        $this->assertDatabaseHas('attempts', [
            'query_quiz_id' => $qq->id,
            'user_id' => $user->id,
            'valid' => true,
        ]);
    }
}
