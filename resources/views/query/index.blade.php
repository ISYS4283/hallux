@extends('layouts.app')

@push('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <h1>Query</h1>

    <table class="datatable">
        <thead>
            <tr>
            @foreach ($rows[0] as $name => $column)
                <th>{{ $name }}</th>
            @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
                <tr>
                    @foreach($row as $column)
                        <td>{{ $column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $('.datatable').DataTable();
    </script>
@endpush
