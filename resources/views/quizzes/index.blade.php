@extends('layouts.app')

@push('head')
    <meta name="description" content="Quiz yourself on your SQL skills.">
@endpush

@section('content')
    <div class="pull-right">
        @can('create', App\Quiz::class)
            <a href="{{ route('quizzes.create') }}" class="btn btn-success">Create <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
        @endcan
    </div>

    <h1>Quizzes</h1>

    @foreach ($quizzes as $quiz)
        @can('view', $quiz)
            <div class="panel panel-{{ $quiz->isOpen() ? 'default' : 'danger' }}">
                <div class="panel-heading">
                    <a href="{{ route('quizzes.show', $quiz) }}">{{ $quiz->title }}</a>
                </div>
                <div class="panel-body">
                    <strong>Points</strong>: {{ $quiz->getPossiblePoints() }}
                    <br>
                    <strong>Open</strong>: {{ isset($quiz->open) ? $quiz->open->timezone('America/Chicago') : 'Not Scheduled' }}
                    <br>
                    <strong>Due</strong>: {{ isset($quiz->closed) ? $quiz->closed->timezone('America/Chicago') : 'Not Scheduled' }}
                </div>
            </div>
        @endcan
    @endforeach
@endsection
