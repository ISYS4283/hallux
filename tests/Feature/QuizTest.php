<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Quiz;

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

        $this
            ->get("/quizzes/{$quiz->id}")
            ->assertSeeText($quiz->title)
        ;
    }
}
