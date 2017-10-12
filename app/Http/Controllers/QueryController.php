<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class QueryController extends Controller
{
    public function run()
    {
        $sql = 'SELECT * FROM Genre';
        $rows = DB::select( DB::raw($sql) );
        return view('query.index', compact('rows'));
    }
}
