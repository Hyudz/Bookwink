<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>

        <!-- Favicon -->
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Custom Styles for consistency with Bookwink -->
        <style>
            body {
                font-family: 'Baskerville', serif;
                background-image: url('img/photo2.avif');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                color: #333;
            }

            .form-container {
                background-color: rgba(247, 244, 240, 0.8);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 800px;
                margin: auto;
                text-align: center;
            }

            h1 {
                font-family: 'Baskerville', serif;
                color: #736e67;
                font-size: 36px;
                margin-bottom: 30px;
            }

            .form-floating input, .form-floating select {
                border-radius: 5px;
                border: 1px solid #d2b48c;
            }

            .form-floating label {
                color: #333;
            }

            .btn-secondary {
                background-color: #a58b6f;
                color: #f8f5f2;
                border: none;
                padding: 10px 30px;
                border-radius: 5px;
                transition: background-color 0.3s, transform 0.3s;
            }

            .btn-secondary:hover {
                background-color: #8b7157;
                transform: scale(1.05);
            }

            .sign-up a {
                color: #736e67;
                text-decoration: none;
                font-weight: bold;
                transition: color 0.3s;
            }

            .sign-up a:hover {
                color: #d2b48c;
            }

            .alert {
                max-width: 800px;
                margin: 20px auto;
            }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100">

        <div class="flex-grow-1 d-flex justify-content-center align-items-center mt-5">
            <!-- Flash Messages -->
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

            <!-- Sign Up Form -->
            <div class="form-container">
                <h1>Sign Up</h1>
                <form action="{{route('signup_post')}}" method="post">
                    @csrf
                    <div class="d-flex flex-row w-100">
                        <div class="form-floating mb-3 w-50">
                            <input type="email" maxlength="254" minlength="5" name="email" required class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email:</label>
                        </div>

                        <div class="form-floating mb-3 ms-3 w-50">
                            <input type="text" name="username" maxlength="50" minlength="3" required class="form-control" id="floatingInput" placeholder="Username">
                            <label for="floatingInput">Username:</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row w-100">
                        <div class="form-floating mb-3 w-50">
                            <input type="password" name="password" required class="form-control" minlength="8" maxlength="16" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>

                        <div class="form-floating mb-3 ms-3 w-50">
                            <input type="password" name="password_confirmation" required class="form-control" minlength="8" maxlength="16" id="floatingPassword" placeholder="Confirm Password">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row w-100">
                        <div class="form-floating mb-3 w-50">
                            <input type="date" name="birthday" required class="form-control" id="floatingInput" placeholder="Birthday">
                            <label for="floatingInput">Birthday:</label>
                        </div>

                        <div class="d-flex flex-column mb-3 ms-3 w-50">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-row w-100">
                        <div class="form-floating mb-3 w-75">
                            <input type="text" name="address" maxlength="255" minlength="10" required class="form-control" id="floatingInput" placeholder="Address">
                            <label for="floatingInput">Address:</label>
                        </div>

                        <div class="form-floating mb-3 ms-3 w-25">
                            <div class="input-group">
                                <span class="input-group-text">+63</span>
                                <input type="tel" name="phone_number" maxlength="10" class="form-control" pattern="[9]{1}[0-9]{9}" id="floatingInput" placeholder="9123456789">
                            </div>
                            <label for="floatingInput">Phone:</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-secondary mt-4 w-50">Sign Up</button>
                </form>

                <div class="sign-up mt-4">
                    <p>Already have an account? <a href="{{route('login')}}">Sign In!</a></p>
                </div>
            </div>
        </div>

        <!-- Include Footer -->
        @include('footer') 

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
