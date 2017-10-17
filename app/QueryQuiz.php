<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QueryQuiz extends Pivot
{
    protected $fillable = [
        'points',
        'query_id',
        'quiz_id',
    ];

    public function qquery()
    {
        return $this->belongsTo(Query::class, 'query_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
