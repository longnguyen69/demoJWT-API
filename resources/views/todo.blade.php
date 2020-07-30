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
                <tr>
                    <th scope="row">{{ ++$key }}</th>
                    <td><a href="{{ route('show.note',['id'=>$todo->id]) }}">{{ $todo->name }}</a></td>
                    <td>{{ $todo->category->name }}</td>
                    <td>{{ $todo->created_at }}</td>
                    <td>
                        <form method="post" action="#">
                            @csrf
                            <select name="status" id="status" class="form-control">

                                <option value="{{ $todo->status }}">
                                    @if($todo->status == 0)
                                        <span style="color: red;" >Waiting</span>
                                    @elseif($todo->status == 1)
                                        <span style="color: green;">Doing</span>
                                    @else
                                        <span style="color: blue;">Done</span>
                                    @endif
                                </option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($todo->status == 2)
                            <a class="btn btn-warning" onclick="return confirm('You sure delete todo?')" href="{{ route('delete.todo',['id'=>$todo->id]) }}">Delete</a>
                        @else
                            <a class="btn btn-success" href="{{ route('edit.todo',['id'=>$todo->id]) }}">Edit</a>
                            <a class="btn btn-warning" onclick="return confirm('You sure delete todo?')" href="{{ route('delete.todo',['id'=>$todo->id]) }}">Delete</a>
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
