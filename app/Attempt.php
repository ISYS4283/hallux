<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = [
        'query_quiz_id',
        'user_id',
        'sql',
        'valid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function queryQuiz()
    {
        return $this->belongsTo(QueryQuiz::class);
    }
}
