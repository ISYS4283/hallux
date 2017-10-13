@extends('layouts.app')

@push('head')
    <meta name="description" content="Connection info for {{ $connection->name }}">
@endpush

@section('content')
    <h1>{{ $connection->name }}</h1>

    {{ dumpHtml($connection->config) }}
@endsection
