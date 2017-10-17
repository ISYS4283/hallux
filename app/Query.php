<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

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

    public function data() : array
    {
        $connection = $this->connection()->first();

        config(["database.connections.{$connection->name}" => $connection->config]);

        try {
            $rows = DB::connection($connection->name)->select( DB::raw($this->attributes['sql']) );
            // limit to 1000 rows
            $rows = array_slice($rows, 0, 1000);
        } catch (QueryException $e) {
            $error = $e->getMessage();
        }

        return compact('rows', 'error');
    }
}
