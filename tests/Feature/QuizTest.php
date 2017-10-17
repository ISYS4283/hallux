<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Quiz;
use App\Query;
use App\QueryQuiz;

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

    public function test_can_show_quiz()
    {
        $this->signIn();

        $qq = create(QueryQuiz::class);

        $response = $this
            ->get("/quizzes/{$qq->quiz_id}")
            ->assertSeeText($qq->quiz->title)
        ;

        $response
            ->assertSeeText("Points: {$qq->points}")
            ->assertSeeText("{$qq->qquery->description}")
        ;
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

    public function test_can_create_quiz()
    {
        $this->signIn();

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

    public function test_can_add_query_to_quiz()
    {
        $this->signIn();

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
}
