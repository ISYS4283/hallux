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
}
