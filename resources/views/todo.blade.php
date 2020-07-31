@extends('master')
@section('content')

    <div class="col-md-10">
        <br>
        <div class="col-md-8">
            <a class="btn btn-primary" href="{{ route('show.create') }}">Add Todo</a>
        </div>
        <br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Todo</th>
                <th scope="col">Category</th>
                <th scope="col">Created</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($todos as $key => $todo)
                <tr id="{{ $todo->id }}">
                    <th scope="row">{{ ++$key }}</th>
                    <td><a href="{{ route('show.note',['id'=>$todo->id]) }}">{{ $todo->name }}</a></td>
                    <td>{{ $todo->category->name }}</td>
                    <td>{{ $todo->created_at }}</td>
                    <td>
                        <select name="status" data-id="{{ $todo->id }}" class="data form-control">
                            @foreach($status as $value)
                                <option value="{{ $value->id }}"
                                        @if($todo->status == $value->id)
                                        selected
                                    @endif
                                >
                                    {{ $value->status }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        @if($todo->status == 3)
                            <a class="btn btn-warning" onclick="return confirm('You sure delete todo?')" href="{{ route('delete.todo',['id'=>$todo->id]) }}">Delete</a>
                        @else
                            <a class="btn btn-success" id="edit-{{$todo->id}}" href="{{ route('edit.todo',['id'=>$todo->id]) }}" >Edit</a>
                            <a class="btn btn-warning delete" data-id="{{ $todo->id }}" href="{{ route('delete.todo',['id'=>$todo->id]) }}">Delete</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <th scope="row">No Data</th>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
