@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <style media="screen">
        .center {
            display:block;
            margin:auto;
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
        <input type="hidden" name="sql">
        <textarea id="sql" rows="8" class="form-control">{{ $sql or '-- write your query here' }}</textarea>
        <br>
        <button type="submit" class="btn btn-primary">Execute</button>
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
