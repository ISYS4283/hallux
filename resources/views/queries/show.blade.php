@extends('layouts.app')

@push('head')
    <meta name="description" content="{{ $query->description }}">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('queries.edit', $query) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>Query #{{ $query->id }}</h1>
    <p>{{ $query->connection->name }}</p>

    <p class="lead">{{ $query->description }}</p>

    <pre class="prettyprint lang-sql linenums">{{ $query->sql }}</pre>
@endsection
