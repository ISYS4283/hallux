@extends('layouts.app')

@push('head')
    <meta name="description" content="Connection info for {{ $connection->name }}">
@endpush

@section('content')
    <div class="pull-right">
        <a href="{{ route('connections.edit', $connection->name) }}" class="btn btn-default">Edit <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
    </div>

    <h1>{{ $connection->name }}</h1>

    {{ dumpHtml($connection->config) }}
@endsection
