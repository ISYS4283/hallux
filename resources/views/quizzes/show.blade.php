@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $title }}">
@endpush

@section('content')
    <div class="pull-right">
        @can('update', $quiz)
            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        @endcan
    </div>

    <h1>{{ $quiz->title }}</h1>

    @foreach ($quiz->queries as $query)
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('quizzes.queries.show', [$quiz->id, $query->id]) }}">Query #{{$query->id}}</a>
                <br>
                Points: {{ $query->pivot->points }}
            </div>
            <div class="panel-body">
                {{ $query->description }}
            </div>
        </div>
    @endforeach
@endsection
