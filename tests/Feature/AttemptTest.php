<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\QueryQuiz;

class AttemptTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_attempt_query_quiz()
    {
        $qq = create(QueryQuiz::class);

        $this
            ->signIn()
            ->post("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}")

        ;
    }
}
