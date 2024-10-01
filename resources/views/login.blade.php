<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Log In</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="d-flex flex-column min-vh-100"> <!-- Added flex-column and min-vh-100 -->

        <!-- Page Content -->
        <div class="flex-grow-1"> 
        <div class="mt-5">
            @if($errors->any())
                <div class="col-12">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                </div>
            </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            @if(session()->has('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
        </div>
            <div class="d-flex flex-row ">
                <div class=" ms-5 mt-5 d-flex flex-column w-50">
                    <div class="mt-5"></div>
                    <div class="mt-5"></div>
                    <div class="mt-5"></div>
                    <h1>Welcome back!</h1>
                    <form class="mt-5" action="{{route('login_post')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email:</label>
                        </div>
                        <div class="form-floating mt-5">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-5 w-25">SIGN IN</button>
                    </form>

                    <div class="sign-up mt-5">
                        <p>Don't have an account? <a style="text-decoration: none;" href="{{route('signup')}}">SIGN UP!</a></p>
                        <a href="{{route('reset_password')}}"> Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>

        @include('footer') 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
