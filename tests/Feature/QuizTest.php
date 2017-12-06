<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Quiz;
use App\Query;
use App\QueryQuiz;
use Carbon\Carbon;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_quizzes()
    {
        $this->signIn();

        $quizzes = create(Quiz::class, [], 5);

        $response = $this->get('/quizzes');

        foreach ($quizzes as $quiz) {
            $response->assertSeeText($quiz->title);
        }
    }

    public function test_user_cannot_view_unscheduled_quiz()
    {
        $quiz = create(Quiz::class, [
            'open' => null,
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->get("/quizzes/{$quiz->id}")
            ->assertStatus(403)
        ;
    }

    public function test_user_cannot_view_closed_quiz()
    {
        $quiz = create(Quiz::class, [
            'closed' => (new Carbon)->subHour(),
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->get("/quizzes/{$quiz->id}")
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_view_closed_quiz()
    {
        $quiz = create(Quiz::class, [
            'closed' => (new Carbon)->subHour(),
        ]);

        $this
            ->signInAdmin()
            ->get("/quizzes/{$quiz->id}")
            ->assertStatus(200)
        ;
    }

    public function test_can_show_quiz()
    {
        $this->signIn();

        $quiz = create(Quiz::class);

        $qqs = create(QueryQuiz::class, ['quiz_id' => $quiz->id], 5);

        $response = $this
            ->get("/quizzes/{$quiz->id}")
            ->assertSeeText($quiz->title)
        ;

        foreach ($qqs as $qq) {
            $response
                ->assertSeeText("Points: {$qq->points}")
                ->assertSeeText("{$qq->qquery->description}")
            ;
        }
    }

    public function test_can_show_query_quiz()
    {
        $this->signIn();

        $qq = create(QueryQuiz::class);

        $this
            ->get("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}")
            ->assertSeeText("Points: {$qq->points}")
            ->assertSeeText("{$qq->qquery->description}")
        ;
    }

    public function test_user_cannot_view_closed_query_quiz()
    {
        $quiz = create(Quiz::class, [
            'closed' => (new Carbon)->subHour(),
        ]);
        $qq = create(QueryQuiz::class, [
            'quiz_id' => $quiz->id,
        ]);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->get("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}")
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_create_quiz()
    {
        $this->signInAdmin();

        $quiz = make(Quiz::class);

        $response = $this
            ->post('/quizzes', $quiz->toArray())
            ->assertStatus(302)
        ;

        $this
            ->get($response->headers->get('Location'))
            ->assertSeeText($quiz->title)
        ;
    }

    public function test_user_can_not_create_quiz()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $quiz = make(Quiz::class);

        $this
            ->post('/quizzes', $quiz->toArray())
            ->assertStatus(403)
        ;
    }

    public function test_admin_can_add_query_to_quiz()
    {
        $this->signInAdmin();

        $query = create(Query::class);

        $quiz = create(Quiz::class);

        $response = $this
            ->post("/quizzes/{$quiz->id}/queries", [
                'query_id' => $query->id,
            ])
            ->assertStatus(302)
        ;

        $this
            ->get($response->headers->get('Location'))
            ->assertSeeText($query->description)
        ;
    }

    public function test_user_can_not_add_query_to_quiz()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $query = create(Query::class);

        $quiz = create(Quiz::class);

        $this
            ->post("/quizzes/{$quiz->id}/queries", [
                'query_id' => $query->id,
            ])
            ->assertStatus(403)
        ;
    }
}
