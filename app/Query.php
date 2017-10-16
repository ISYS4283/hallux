<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    protected $fillable = [
        'sql',
        'description',
        'connection_id',
    ];

    public function connection()
    {
        return $this->belongsTo(Connection::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)->using(QueryQuiz::class);
    }
}
