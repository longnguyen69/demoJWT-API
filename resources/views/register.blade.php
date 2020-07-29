@extends('master')
@section('content')
    <div class="col-md-6">
        <h3>Register</h3>
        @if (Session::has('error'))
            <div class="alert alert-warning">{{ Session::get('error') }}</div>
        @endif
        <form method="post" action="#">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="name">
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
@endsection
