@extends('layouts.app')

@push('head')
    <meta name="description" content="Quiz yourself on your SQL skills.">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('quizzes.create') }}" class="btn btn-success">Create <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </div>

    <h1>Quizzes</h1>

    <ul>
        @foreach ($quizzes as $quiz)
            <li><a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->title }}</a></li>
        @endforeach
    </ul>
@endsection
