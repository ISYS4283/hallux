<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class QueryController extends Controller
{
    public function run(Request $request)
    {
        if ($request->has('sql')) {
            $sql = $request->sql;

            $rows = DB::select( DB::raw($sql) );

            // limit to 1000 rows
            $rows = array_slice($rows, 0, 1000);
        }
        return view('query.index', compact('rows', 'sql'));
    }
}