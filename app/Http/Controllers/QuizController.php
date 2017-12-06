<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;
use Auth;
use App\Attempt;
use jpuck\php\bootstrap\ProgressBar\ProgressBar;
use App\Blackboard;
use App\User;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Quiz::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Quiz::class);

        return view('quizzes.index', [
            'title' => 'Quizzes',
            'quizzes' => Quiz::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->castDateTimes($data);

        $quiz = Quiz::create($data);

        if (isset($quiz->blackboard_course_id)) {
            (new Blackboard($quiz))->createGradebookColumn();
        }

        return redirect(route('quizzes.show', $quiz));
    }

    protected function castDateTimes(array &$data)
    {
        foreach (['open', 'closed'] as $attribute) {
            if (isset($data[$attribute])) {
                try {
                    // ISO8601 UTC
                    $data[$attribute] = new Carbon($data[$attribute]);
                } catch (\InvalidArgumentException $e) {
                    // datetime-local
                    $data[$attribute] = Carbon::createFromFormat('Y-m-d\TH:i', $data[$attribute])->setTimezone('America/Chicago');
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $completed = null;
        $points = $quiz->getPointsForUser($user, $completed);

        $queries = $quiz->queries->map(function ($query) use ($completed) {
            $query->completed = false;
            if ($completed->contains('query_id', $query->id)) {
                $query->completed = true;
            }
            return $query;
        });

        return view('quizzes.show', [
            'title' => "Quiz #{$quiz->id}: {$quiz->title}",
            'quiz' => $quiz,
            'queries' => $queries,
            'progressBar' => $this->getProgressBar($points, $quiz->getPossiblePoints()),
        ]);
    }

    protected function getProgressBar(int $numerator, int $denominator) : ProgressBar
    {
        if (empty($numerator)) {
            return new ProgressBar(0);
        }

        if (empty($denominator)) {
            return new ProgressBar(0);
        }

        $percent = (int)round(($numerator / $denominator) * 100);

        return new ProgressBar($percent);
    }

    public function blackboard(Quiz $quiz)
    {
        $this->authorize('attempt', $quiz);

        (new Blackboard($quiz))->postGradeForStudent(Auth::user());

        flash('Your grade was successfully posted to blackboard!')->success();

        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
