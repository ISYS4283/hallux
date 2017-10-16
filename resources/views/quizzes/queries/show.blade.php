@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $qq->qquery->description }}">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('quizzes.show', $qq->quiz) }}" class="btn btn-default">Back to Quiz</a>
        <a href="{{ route('quizzes.queries.edit', [$qq->quiz, $qq->qquery]) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>Query #{{ $qq->qquery->id }}</h1>
    <p>Points: {{ $qq->points }}</p>

    <p class="lead">{{ $qq->qquery->description }}</p>

    <button type="button" class="btn btn-default" onclick="$('#expectedData').toggle()">Show/Hide Data</button>
    <table id="expectedData" class="table table-striped table-bordered table-responsive">
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
@endsection
