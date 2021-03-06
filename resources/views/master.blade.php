<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('index') }}">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                @else
                    <a class="nav-link" href="{{route('show.login')}}">Login <span class="sr-only">(current)</span></a>
                @endif
            </li>
            <li class="nav-item active">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <a class="nav-link" href="{{ route('log') }}">Log Activity</a>
                @endif
            </li>
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <a class="nav-link" href="{{ route('recent') }}">Recent</a>
                @else
                    <a class="nav-link" href="{{route('show.register')}}">Register</a>
                @endif
            </li>
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <a class="nav-link" href="{{ route('total') }}">Category</a>
                @endif
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    @if(\Illuminate\Support\Facades\Auth::user())
                        {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    @else
                        Dropdown
                    @endif
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Log Activity</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('search.todo') }}">
            @csrf
            <input class="form-control mr-sm-2" type="text" placeholder="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
<div class="col-md-12 col-sm-6">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
{{--
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
--}}

<script>
    $(document).ready(function () {
        $(".data").on("change", function () {
            let todoId = $(this).data('id');
            let status = $(this).val();
            if (confirm(`Are you sure ?`)) {
                $.ajax({
                    url: `{{ route('todo.change_status') }}/${todoId}`,
                    data: {
                        status: status
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.status_todo == 3) {
                            console.log(result);
                            // window.location.reload();
                            $("#edit-" + todoId).hide();
                        } else {
                            $("#edit-" + todoId).show();
                        }
                    },
                    error: (error) => {
                        alert(JSON.stringify(error));
                    }
                });
            }
        });

        $(".delete").on("click", function (e) {
            e.preventDefault();
            let todoId = $(this).attr('data-id');
            if (confirm("Are you sure delete todo?")) {
                $.ajax({
                    url: $(this).attr("href"),
                    type: 'get',
                    success: function (result) {
                        if (result.status == 'success') {
                            $("#" + todoId).fadeOut();
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>
