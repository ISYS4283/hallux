@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $qq->description }}">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('quizzes.show', $qq->quiz_id) }}" class="btn btn-default">Back to Quiz</a>
        <a href="{{ route('quizzes.queries.edit', [$qq->quiz_id, $qq->query_id]) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>Query #{{ $qq->query_id }}</h1>
    <p>Points: {{ $qq->points }}</p>

    <p class="lead">{{ $qq->description }}</p>

    <section>
        <h2>Expected Data</h2>
        <button type="button" class="btn btn-default" onclick="$('#expectedData').toggle()">Show/Hide</button>
        <table id="expectedData" class="table table-striped table-bordered table-responsive">
            <thead>
                <tr>
                @foreach ($expectedRows[0] as $name => $column)
                    <th>{{ $name }}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($expectedRows as $row)
                    <tr>
                        @foreach($row as $column)
                            <td>{{ $column }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section>
        <h2>Solution</h2>
        <form id="query" method="post">
            {{ csrf_field() }}

            <div class="form-group">
                <input type="hidden" name="sql">
                <label for="sql">SQL:</label>
                <textarea id="sql" rows="8" class="form-control">{{ $request->sql or '-- write your query here' }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Execute</button>
        </form>
    </section>
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

        $('#query').submit(function() {
            $('#query input[name="sql"]').val(editor.getSession().getValue());
        });
    </script>
@endpush
