@extends('layouts.app')

@push('head')
    <meta name="description" content="Test your SQL skills by querying datasets.">
@endpush

@section('content')
    <h1>Welcome to Query Quizzer</h1>

    @include('flash::message')

    <p class="lead">
        SQL testing environment for learning how to query a database
    </p>

    <p>
        Herein you will find business questions, and their result sets.
        Your objective is to write SQL queries that produce the given result sets.
    </p>

    <p>
        It will probably be more efficient and faster to work on your solutions
        in a dedicated querying environment such as SQL Server Management Studio.
        Once you have a working solution, then check your work by submitting here.
    </p>

    <p>
        Some quizzes are integrated with Blackboard.
        To get credit, be sure to submit your work when you see
        <button type="button" class="btn btn-primary">Post to Blackboard</button>
    </p>
@endsection
