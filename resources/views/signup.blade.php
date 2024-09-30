<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Page Content -->
        <div class="flex-grow-1"> 
            <div class="d-flex flex-row ">
                <div class=" ms-5 mt-5 d-flex flex-column w-50">
                    <div class="mt-5"></div>
                    <div class="mt-5"></div>
                    <div class="mt-5"></div>
                    <form class="mt-5" action="{{route('login_post')}}" method="get">
                        <div class="d-flex flex-row w-100">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email:</label>
                            </div>

                            <div class="form-floating mb-3 ms-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">Username:</label>
                            </div>
                        </div>

                        <div class="d-flex flex-row w-100">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="form-floating mb-3 ms-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Confirm Password</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-5 w-25">SIGN UP</button>
                    </form>

                    <div class="sign-up mt-5">
                        <p>Already have an account? <a style="text-decoration: none;" href="{{route('login')}}">SIGN IN!</a></p>
                    </div>
                </div>
            </div>
        </div>

        @include('footer') 

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
