@extends('razorbacks::layout')

@section('navbar')
    <li><a href="{{ route('quizzes.index') }}">Quizzes</a></li>
    <li><a href="{{ route('query') }}">Query</a></li>
@endsection
