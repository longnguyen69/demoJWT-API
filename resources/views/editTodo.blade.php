@extends('master')
@section('content')
    <div class="col-md-6">
        <h3>Edit todo</h3>
        <form method="post" action="{{ route('update.todo',['id'=>$todo->id]) }}">
            @csrf
            <div class="form-group">
                <label>Name job</label>
                <input type="text" class="form-control" name="name" value="{{ $todo->name }}">
            </div>
            <div class="form-group">
                <label>Select workplace</label>
                <select class="form-control" id="exampleFormControlSelect1" name="category">
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @if($category->id == $todo->category_id)
                                selected
                                @endif
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="exampleFormControlSelect1" name="status">
                    <option value="1">Do not</option>
                    <option value="2">Doing</option>
                    <option value="3">Done</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
