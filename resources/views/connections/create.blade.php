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
                    <label for="driver">Select Template:</label>
                    <select id="driver" class="form-control" required>
                        <option disabled selected></option>
                        @foreach($templates as $key => $template)
                            <option>{{ $key }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="template-container"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="hidden">
        @foreach($templates as $key => $template)
            <div id="template-{{$key}}" class="panel panel-default">
                <div class="panel-body">
                @foreach($template as $name => $attribute)
                    <div class="form-group">
                        <label for="config-{{$name}}" class="control-label">{{ $name }}:</label>
                        <input type="text"
                            id="config-{{$name}}"
                            name="config[{{$name}}]"
                            value="{{$attribute}}"
                            placeholder="Enter {{$name}}."
                            class="form-control">
                    </div>
                @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        $('#driver').change(function(e){
            $('#template-container').html($(`#template-${this.value}`).html());
        });
    </script>
@endpush
