@extends('layouts.app')

@push('head')
    <meta name="description" content="Create new Quiz">
@endpush

@section('content')
    <h1>Create Quiz</h1>

    <p class="lead">Enter the title below and add queries with point values.</p>

    <form action="{{ route('quizzes.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label" for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter quiz title." required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
