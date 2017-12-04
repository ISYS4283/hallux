@extends('layouts.app')

@push('head')
    <meta name="description" content="Test your SQL skills by querying datasets.">
@endpush

@section('content')
    <h1>Welcome to Query Quizzer</h1>

    @include('flash::message')

    <p class="lead">
        This is an SQL exploration environment for learning how to query a
        database for answers to common business questions.
    </p>
@endsection
