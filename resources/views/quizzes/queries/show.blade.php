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
@endsection
