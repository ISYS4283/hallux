@extends('layouts.app')

@push('head')
    <meta name="description" content="List of available database connections.">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('connections.create') }}" class="btn btn-success">Create <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
    </div>

    <h1>Connections</h1>

    <p class="lead">Here is a list of available database connections.</p>

    <ul>
        @foreach($connections as $connection)
            <li><a href="{{ route('connections.show', $connection->name) }}">{{ $connection->name }}</a></li>
        @endforeach
    </ul>
@endsection
