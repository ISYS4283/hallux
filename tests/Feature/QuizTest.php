<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Quiz;
use App\QueryQuiz;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_quizzes()
    {
        $quizzes = create(Quiz::class, [], 5);

        $response = $this->get('/quizzes');

        foreach ($quizzes as $quiz) {
            $response->assertSeeText($quiz->title);
        }
    }

    public function test_can_show_quiz()
    {
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
        $qq = create(QueryQuiz::class);

        $this
            ->get("/quizzes/{$qq->quiz_id}/queries/{$qq->query_id}")
            ->assertSeeText("Points: {$qq->points}")
            ->assertSeeText("{$qq->qquery->description}")
        ;
    }
}
