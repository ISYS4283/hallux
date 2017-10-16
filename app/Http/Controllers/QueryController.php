<?php

namespace App\Http\Controllers;

use App\Query;
use App\Quiz;
use App\Connection;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class QueryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queries = Query::with('connection')->get();

        return view('queries.index', compact('queries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $connections = Connection::all();

        if ($request->has('sql')) {
            $connection = $connections->first(function($connection) use ($request){
                return $connection->id == $request->connection_id;
            });

            abort_if(empty($connection), 404);

            // remove the connection
            $connections = $connections->filter(function ($connection) use ($request){
                return $connection->id != $request->connection_id;
            });

            // TODO: I wish we could pass a closure to `pull` instead of just a key

            $query = new Query($request->all());

            extract($query->data());
        }

        return view('queries.create', compact('rows', 'error', 'connections', 'connection', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = Query::create($request->all());

        return redirect(route('queries.show', $query));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function show(Query $query)
    {
        $quizzes = Quiz::all();

        return view('queries.show', compact('query', 'quizzes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function edit(Query $query)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Query $query)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function destroy(Query $query)
    {
        //
    }
}
