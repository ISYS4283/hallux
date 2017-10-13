@extends('layouts.app')

@push('head')
    <meta name="description" content="Create new Connection">
@endpush

@section('content')
    <h1>Create Connection</h1>

    <p class="lead">Enter the name and configuration attributes below.</p>

    <form action="{{ route('connections.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="control-label" for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter connection name." required>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                Configuration Attributes
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <label for="driver">Select Driver:</label>
                    <select id="driver" class="form-control">
                        <option value="sqlsrv">Microsoft SQL Server</option>
                        <option value="mysql">MySQL</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
