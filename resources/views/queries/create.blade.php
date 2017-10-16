@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style media="screen">
        .center {
            display:block;
            margin:auto;
        }
        thead tr {
            background-color: white;
        }
    </style>
@endpush

@section('content')
    <h1>Query</h1>

    @unless(empty($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @endunless

    <form id="query" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="connection_id">Connection:</label>
            <select id="connection_id" name="connection_id" class="form-control" required>
                @if(empty($connection))
                    <option disabled selected></option>
                @else
                    <option value="{{$connection->id}}" selected>{{ $connection->name }}</option>
                @endif
                @foreach($connections as $connection)
                    <option value="{{$connection->id}}">{{ $connection->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="8" class="form-control">{{ $request->description }}</textarea>
        </div>

        <div class="form-group">
            <input type="hidden" name="sql">
            <label for="sql">SQL:</label>
            <textarea id="sql" rows="8" class="form-control">{{ $request->sql or '-- write your query here' }}</textarea>
        </div>

        <button type="submit" class="btn btn-default">Execute</button>
        <button type="submit" formaction="{{ route('queries.store') }}" class="btn btn-primary">Save</button>
    </form>

    @unless(empty($rows))
        <h2>Results</h2>
        <p class="lead">Results are limited to the first 1,000 rows.</p>
        <img id="loadingSpinner" src="{{ asset('images/spinner.gif') }}" class="center">
        <table class="datatable" style="display:none">
            <thead>
                <tr>
                @foreach ($rows[0] as $name => $column)
                    <th>{{ $name }}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr>
                        @foreach($row as $column)
                            <td>{{ $column }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endunless
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var editor = ace.edit("sql");
        editor.setOptions({
            mode: "ace/mode/sql",
            maxLines: Infinity,
            fontSize: 18,
        });
    </script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $('#query').submit(function() {
            $('#query input[name="sql"]').val(editor.getSession().getValue());
        });

        $('.datatable').DataTable({
            "processing": true,
            "initComplete": function(settings, json) {
                $('#loadingSpinner').hide();
                $('.datatable').show();
            }
        });
    </script>
@endpush
