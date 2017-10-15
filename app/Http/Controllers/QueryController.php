<?php

namespace App\Http\Controllers;

use App\Query;
use App\Connection;
use Illuminate\Http\Request;
use DB;
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
        if ($request->has('sql')) {
            $connection = Connection::findOrFail($request->connection_id);
            config(["database.connections.{$connection->name}" => $connection->config]);

            $sql = $request->sql;

            try {
                $rows = DB::connection($connection->name)->select( DB::raw($sql) );
                // limit to 1000 rows
                $rows = array_slice($rows, 0, 1000);
            } catch (QueryException $e) {
                $error = $e->getMessage();
            }
        }

        $connections = Connection::all();

        return view('queries.create', compact('rows', 'sql', 'error', 'connections'));
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
        return view('queries.show', compact('query'));
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
