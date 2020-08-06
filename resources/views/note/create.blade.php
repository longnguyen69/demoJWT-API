@extends('master')
@section('content')
    <div class="col-md-6">
        <h3>Add new todo</h3>
        @if (Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <form method="post" action="{{ route('store.todo') }}">
            @csrf
            <div class="form-group">
                <label>Name job</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>Select workplace</label>
                <select class="form-control" id="exampleFormControlSelect1" name="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
