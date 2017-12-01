<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'blackboard_course_id',
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
}
