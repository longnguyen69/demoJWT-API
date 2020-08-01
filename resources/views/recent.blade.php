@extends('master')
@section('content')
    <div class="col-md-6">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code todo</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
            </tr>
            </thead>
            <tbody>
            @if($todos)
                @forelse($todos as $todo)
                    <tr>
                        <th scope="row"></th>
                        <td>{{ $todo['id'] }}</td>
                        <td>{{ $todo['name'] }}</td>
                        <td>{{ $todo['category_id'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>No recent</td>
                    </tr>
                @endforelse
            @else
                <tr>
                    <td>No recent</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
