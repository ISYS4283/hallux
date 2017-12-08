<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\QueryQuiz;
use App\User;
use App\Attempt;
use App\Quiz;

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

    public function test_attempt_requires_sql()
    {
        $qq = create(QueryQuiz::class);

        $user = create(User::class);

        $this
            ->withExceptionHandling()
            ->signIn($user)
            ->post("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}")
            ->assertSessionHasErrors('sql')
        ;
    }

    public function test_user_only_gets_points_for_one_success()
    {
        $user = create(User::class);

        $quiz = create(Quiz::class);

        $points1 = 1;
        $qq1 = create(QueryQuiz::class, ['points' => $points1, 'quiz_id' => $quiz->id]);
        create(Attempt::class, [
            'query_quiz_id' => $qq1->id,
            'query_id' => $qq1->query_id,
            'quiz_id' => $qq1->quiz_id,
            'user_id' => $user->id,
            'valid' => true,
        ], 3);

        $points2 = 1;
        $qq2 = create(QueryQuiz::class, ['points' => $points2, 'quiz_id' => $quiz->id]);
        create(Attempt::class, [
            'query_quiz_id' => $qq2->id,
            'query_id' => $qq2->query_id,
            'quiz_id' => $qq2->quiz_id,
            'user_id' => $user->id,
            'valid' => true,
        ], 3);

        $expected = $points1 + $points2;

        $this->assertSame($expected, $quiz->getPointsForUser($user));
    }
}
