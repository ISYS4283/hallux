<?php

namespace App\Policies;

use App\User;
use App\Quiz;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the quiz list.
     *
     * @param  \App\User  $user
     * @param  \App\Connection  $connection
     * @return mixed
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function view(User $user, Quiz $quiz)
    {
        if (!$quiz->isOpen()) {
            return false;
        }

        return true;
    }

    public function attempt(User $user, Quiz $quiz)
    {
        return true;
    }

    /**
     * Determine whether the user can create quizzes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function update(User $user, Quiz $quiz)
    {
        //
    }

    /**
     * Determine whether the user can delete the quiz.
     *
     * @param  \App\User  $user
     * @param  \App\Quiz  $quiz
     * @return mixed
     */
    public function delete(User $user, Quiz $quiz)
    {
        //
    }
}
