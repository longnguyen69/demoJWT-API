@extends('master')
@section('content')
    <div class="col-md-6">
        <br>
        <div class="card">
            <h5 class="card-header">{{ $todo->note->name }}</h5>
            <div class="card-body">
                @if($todo->desc == null)
                    <form method="post" action="{{ route('store.note',['id'=>$todo->note_id]) }}">
                        @csrf
                        <textarea name="desc" class="form-control" placeholder="Add note here!"></textarea>
                        <br>
                        <button type="submit" class="btn btn-success">Add note</button>
                    </form>
                @else
                    <form method="post" action="{{ route('store.note',['id'=>$todo->note_id])  }}">
                        @csrf
                        <textarea name="desc" class="form-control">{{ $todo->desc }}</textarea>
                        <br>
                        <button type="submit" class="btn btn-success">Edit note</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
