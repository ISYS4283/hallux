<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'open',
        'closed',
        'blackboard_course_id',
    ];

    protected $dates = [
        'open',
        'closed',
    ];

    public function queries()
    {
        return $this->belongsToMany(Query::class)->withPivot('points')->using(QueryQuiz::class);
    }

    public function getPossiblePoints() : int
    {
        $total = 0;

        foreach ($this->queries()->get() as $query) {
            $total += $query->pivot->points;
        }

        return $total;
    }

    public function isOnBlackboard() : bool
    {
        return isset($this->attributes['blackboard_gradebook_column_id']);
    }

    /**
     * @param $attempts - will set the reference variable equal to collection
     */
    public function getPointsForUser(User $user, &$attempts = null) : int
    {
        $attempts = Attempt::with('qq')
            ->where('user_id', $user->id)
            ->where('quiz_id', $this->attributes['id'])
            ->where('valid', true)
            ->get();

        $points = [];
        foreach ($attempts as $attempt) {
            $points[$attempt->qq->id] = $attempt->qq->points;
        }

        return array_sum($points);
    }

    public function isOpen() : bool
    {
        $open = $this->__get('open');
        $closed = $this->__get('closed');

        if (empty($open)) {
            return false;
        }

        if (empty($closed)) {
            return true;
        }

        if ($closed->lt(new Carbon)) {
            return false;
        }

        return true;
    }
}
