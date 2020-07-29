@extends('master')
@section('content')
    <div class="col-md-4">
        <h3>Login</h3>
        @if (Session::has('error'))
            <div class="alert alert-warning">{{ Session::get('error') }}</div>
        @endif
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input type="email" class="form-control" name="email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
@endsection
