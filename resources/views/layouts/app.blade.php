@extends('razorbacks::layout')

@section('head')
    <style>
        pre.prettyprint {
            font-size: 18px;
        }
    </style>
@endsection

@section('navbar')
    <li><a href="{{ route('quizzes.index') }}">Quizzes</a></li>
    <li><a href="{{ route('queries.index') }}">Queries</a></li>
    <li><a href="{{ route('connections.index') }}">Connections</a></li>
@endsection

@section('scripts')
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?lang=sql&skin=sons-of-obsidian"></script>
@endsection
