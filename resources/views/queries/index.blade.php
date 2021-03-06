@extends('layouts.app')

@push('head')
    <meta name="description" content="List of queries.">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('queries.create') }}" class="btn btn-success">Create <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </div>

    <h1>Queries</h1>

    <p class="lead">Here is a list of queries.</p>

    @foreach($queries as $query)
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('queries.show', $query) }}">Query #{{$query->id}}</a>
            </div>
            <div class="panel-body">
                <p>{!! nl2br(e($query->description)) !!}</p>
                <pre class="prettyprint lang-sql linenums">{{ $query->sql }}</pre>
            </div>
            <div class="panel-footer">
                <p>{{ $query->connection->name }}</p>
            </div>
        </div>
    @endforeach
@endsection
