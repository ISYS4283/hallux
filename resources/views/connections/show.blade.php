@extends('layouts.app')

@push('head')
    <meta name="description" content="Connection info for {{ $connection->name }}">
@endpush

@section('content')
    <h1>{{ $connection->name }}</h1>

    <div class="pull-right">
        <a href="{{ route('connections.edit', $connection->name) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    {{ dumpHtml($connection->config) }}
@endsection
