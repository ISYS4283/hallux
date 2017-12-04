<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Quiz;
use App\QueryQuiz;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_possible_points()
    {
        $quiz = create(Quiz::class);
        create(QueryQuiz::class, [
            'quiz_id' => $quiz->id,
            'points' => 5,
        ], 5);
        $expected = 25;

        $this->assertSame($expected, $quiz->getPossiblePoints());
    }

    public function test_can_determine_if_on_blackboard()
    {
        $quizOff = create(Quiz::class);
        $this->assertFalse($quizOff->isOnBlackboard());

        $quizOn = create(Quiz::class, [
            'blackboard_course_id' => '_123_1',
            'blackboard_gradebook_column_id' => '_123_1',
        ]);
        $this->assertTrue($quizOn->isOnBlackboard());
    }
}
