@extends('master')
@section('content')
    <div class="col-md-6">
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $key => $category)
                <tr>
                    <th scope="row">{{ ++$key }}</th>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->total() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
