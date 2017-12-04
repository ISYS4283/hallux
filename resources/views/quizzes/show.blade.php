@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $title }}">
    {!! jpuck\php\bootstrap\ProgressBar\ProgressBar::getCssEmbed() !!}
@endpush

@section('content')
    <div class="pull-right">
        @can('update', $quiz)
            <a href="{{ route('quizzes.edit', $quiz) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        @endcan
    </div>

    <h1>{{ $quiz->title }}</h1>

    {!! $progressBar !!}

    @foreach ($queries as $query)
        <div class="panel panel-{{ $query->completed ? 'success' : 'default' }}">
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

    @if ($quiz->isOnBlackboard())
        <div class="panel panel-default">
            <div class="panel-body">
                {!! $progressBar !!}

                <p class="lead">
                    Once you are happy with your score, then post your grade to blackboard.
                </p>

                <div>
                    <a href="{{ route('quizzes.blackboard', $quiz) }}" class="btn btn-primary">Post to Blackboard</a>
                </div>
            </div>
        </div>
    @endif
@endsection
