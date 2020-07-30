@extends('master')
@section('content')
    <div class="col-md-6">
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">user</th>
                <th scope="col">subject</th>
                <th scope="col">date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <th scope="row"></th>
                    <td>{{ $log->causer_id }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
