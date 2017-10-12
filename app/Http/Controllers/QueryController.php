<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;

class QueryController extends Controller
{
    public function run(Request $request)
    {
        if ($request->has('sql')) {
            $sql = $request->sql;

            try {
                $rows = DB::connection('hallux')->select( DB::raw($sql) );
                // limit to 1000 rows
                $rows = array_slice($rows, 0, 1000);
            } catch (QueryException $e) {
                $error = $e->getMessage();
            }
        }
        return view('query.index', compact('rows', 'sql', 'error'));
    }
}
