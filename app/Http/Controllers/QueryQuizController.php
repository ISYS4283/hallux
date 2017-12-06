<?php

namespace App\Http\Controllers;

use App\Query;
use App\Quiz;
use App\QueryQuiz;
use App\Attempt;
use Illuminate\Http\Request;
use Auth;
use View;
use App\Validators\ResultSetComparator;
use App\Blackboard;

class QueryQuizController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Quiz::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function index(Quiz $quiz)
    {
        $this->authorize('index', Quiz::class);

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
        $query = Query::findOrFail($request->query_id);

        // default 1 point
        if ($request->has('points')) {
            $data = ['points' => $request->points];
        }

        $quiz->queries()->attach($query, $data ?? []);

        if ($quiz->isOnBlackboard()) {
            (new Blackboard($quiz))->syncPossiblePoints();
        }

        return redirect(route('quizzes.queries.show', [$quiz, $query]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int \App\Quiz id  $quiz
     * @param  int \App\Query id $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz, int $query, Request $request, $qq = null)
    {
        if (is_null($qq)) {
            $qq = $this->getQueryJoinQueryQuiz($query, $quiz->id);
        }

        return view('quizzes.queries.show', [
            'title' => "Quiz Query #{$qq->query_id}: {$qq->description}",
            'qq' => $qq,
            'expectedRows' => $qq->data()['rows'] ?? [],
            'request' => $request,
        ]);
    }

    /**
     * Checks an SQL solution attempt.
     *
     * @param  int \App\Quiz id  $quiz
     * @param  int \App\Query id $query
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attempt(Quiz $quiz, int $query, Request $request)
    {
        $this->authorize('attempt', $quiz);

        $qq = $this->getQueryJoinQueryQuiz($query, $quiz->id);
        $expectedRows = $qq->data()['rows'] ?? [];

        $queryAttempt = clone $qq;
        $queryAttempt->sql = $request->sql;
        $data = $queryAttempt->data();
        $actualRows = $data['rows'] ?? [];
        View::share('actualRows', $actualRows);
        View::share('error', $data['error'] ?? null);

        $attempt = Attempt::make([
            'query_quiz_id' => $qq->id,
            'query_id' => $query,
            'quiz_id' => $quiz->id,
            'user_id' => Auth::user()->id,
            'sql' => $request->sql,
        ]);

        $match = (new ResultSetComparator)->match($expectedRows, $actualRows);

        if (true === $match) {
            $attempt->valid = true;
            View::share('success', "Congratulations, that's a valid solution!");
        } else {
            $attempt->valid = false;
            View::share('diff', $match);
        }

        $attempt->save();

        return $this->show($quiz, $query, $request, $qq);
    }

    /**
     * Returns \App\Query hydrated with QueryQuiz attributes.
     */
    protected function getQueryJoinQueryQuiz(int $query_id, int $quiz_id)
    {
        $qq = Query::where([
            ['query_quiz.query_id', $query_id],
            ['query_quiz.quiz_id', $quiz_id],
        ])
        ->join('query_quiz', 'query_quiz.query_id', '=', 'queries.id')
        ->first();

        abort_if(empty($qq), 404);

        return $qq;
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
