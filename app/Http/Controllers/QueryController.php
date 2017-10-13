<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Database\QueryException;
use App\Contracts\DataSource;

class QueryController extends Controller
{
    protected $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function run(Request $request)
    {
        if ($request->has('sql')) {
            $sql = $request->sql;

            try {
                $rows = DB::connection($dataSource->getConnectionName())->select( DB::raw($sql) );
                // limit to 1000 rows
                $rows = array_slice($rows, 0, 1000);
            } catch (QueryException $e) {
                $error = $e->getMessage();
            }
        }
        return view('query.index', compact('rows', 'sql', 'error'));
    }
}
