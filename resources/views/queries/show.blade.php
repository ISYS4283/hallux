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

    <p class="lead">{!! nl2br(e($query->description)) !!}</p>

    <pre class="prettyprint lang-sql linenums">{{ $query->sql }}</pre>

    <div class="panel panel-default">
        <div class="panel-heading">
            Add to Quiz
        </div>
        <div class="panel-body">
            <form id="addToQuizForm" method="post">
                {{ csrf_field() }}

                <input type="hidden" name="query_id" value="{{ $query->id }}">

                <div class="form-group">
                    <label for="quiz">Select Quiz:</label>
                    <select id="quiz" class="form-control" required>
                        <option disabled selected></option>
                        @foreach ($quizzes as $quiz)
                            <option value="{{ $quiz->id }}">{{ $quiz->id }}:{{ $quiz->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="points">Points:</label>
                    <input id="points" class="form-control" type="number" name="points" value="1" min="0" step="1" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#quiz').change(function(e){
            $('#addToQuizForm').attr('action', `/quizzes/${this.value}/queries`);
        });
    </script>
@endpush
