<?php

namespace App\Http\Controllers;

use App\Query;
use App\Quiz;
use App\QueryQuiz;
use Illuminate\Http\Request;

class QueryQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz)
    {
        return redirect(route('quizzes.show', $quiz));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function create(Quiz $quiz)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @param  \App\QueryQuiz  $queryQuiz
     * @return \Illuminate\Http\Response
     */
    public function show($quiz, $query)
    {
        $qq = QueryQuiz::where([
            ['query_id', $query],
            ['quiz_id', $quiz],
        ])
        ->with('qquery')
        ->with('quiz')
        ->first();

        abort_if(empty($qq), 404);

        return view('quizzes.queries.show', [
            'title' => "Quiz Query #{$qq->qquery->id}: {$qq->qquery->description}",
            'qq' => $qq,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @param  \App\QueryQuiz  $queryQuiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz, Query $query)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @param  \App\QueryQuiz  $queryQuiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Query $query)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @param  \App\QueryQuiz  $queryQuiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz, Query $query)
    {
        //
    }
}
