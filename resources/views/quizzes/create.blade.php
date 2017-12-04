@extends('layouts.app')

@push('head')
    <meta name="description" content="Create new Quiz">
@endpush

@section('content')
    <h1>Create Quiz</h1>

    <p class="lead">Enter the title below and optionally add the grade to Blackboard.</p>

    <p class="lead">
        After it has been created,
        then <a href="{{ route('queries.index') }}">add queries</a> to the quiz.
    </p>

    <form action="{{ route('quizzes.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label" for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter quiz title." required autofocus>
        </div>

        <div class="form-group">
            <label class="control-label" for="blackboard_course_id">Blackboard Course ID:</label>
            <input type="text" class="form-control" id="blackboard_course_id" name="blackboard_course_id" placeholder="e.g. _123_1">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
