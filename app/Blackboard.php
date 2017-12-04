<?php

namespace App;

use razorbacks\blackboard\rest\Api;
use Exception;

class Blackboard
{
    protected $api;
    protected $quiz;

    public function __construct(Quiz $quiz)
    {
        $server = config('blackboard.server');
        $applicationId = config('blackboard.applicationId');
        $secret = config('blackboard.secret');
        $this->api = new Api($server, $applicationId, $secret);

        $this->quiz = $quiz;
    }

    public function createGradebookColumn()
    {
        $courseId = $this->quiz->blackboard_course_id;
        $gradeColumn = [
            'name' => $this->quiz->title,
            'score' => [
                'possible' => 0,
            ],
            'availability' => [
                'available' => 'Yes',
            ],
        ];

        $gradeColumn = $this->api->post("/courses/$courseId/gradebook/columns", $gradeColumn);

        $this->quiz->blackboard_gradebook_column_id = $gradeColumn['id'];
        $this->quiz->save();
    }

    public function syncPossiblePoints()
    {
        if (!$this->quiz->isOnBlackboard()) {
            throw new NotOnBlackboard;
        }

        $courseId = $this->quiz->blackboard_course_id;
        $columnId = $this->quiz->blackboard_gradebook_column_id;
        $gradeColumn = [
            'score' => [
                'possible' => $this->quiz->getPossiblePoints(),
            ],
        ];

        $this->api->patch("/courses/$courseId/gradebook/columns/$columnId", $gradeColumn);
    }

    public function postGradeForStudent(User $user)
    {
        if (!$this->quiz->isOnBlackboard()) {
            throw new NotOnBlackboard;
        }

        $courseId = $this->quiz->blackboard_course_id;
        $columnId = $this->quiz->blackboard_gradebook_column_id;
        $username = $user->getUsername();
        $score = $this->quiz->getPointsForUser($user);

        $endpoint = "/courses/$courseId/gradebook/columns/$columnId/users/userName:$username";
        $this->api->patch($endpoint, [
            'score' => $score,
        ]);
    }
}

class NotOnBlackboard extends Exception {}
