<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password</title>
        <!-- Favicon -->
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
        
        <!-- Custom CSS for the Bookwink theme -->
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <!-- Custom Styles for consistency -->
        <style>
            body {
                font-family: 'Baskerville', serif;
                background-image: url('img/photo2.avif'); /* Consistent background image */
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                color: #333;
            }

            .form-container {
                background-color: rgba(247, 244, 240, 0.8); /* Light background */
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 600px;
                margin: auto;
                text-align: center;
            }

            h1 {
                font-family: 'Baskerville', serif;
                color: #736e67; /* Soft brown color for title */
                font-size: 36px;
                margin-bottom: 30px;
            }

            .form-floating input {
                border-radius: 5px;
                border: 1px solid #d2b48c;
            }

            .form-floating label {
                color: #333;
            }

            .btn-secondary {
                background-color: #a58b6f; /* Matching button color */
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
                max-width: 600px;
                margin: 20px auto;
            }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100">

        <!-- Page Content -->
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
            </div>

            <!-- Forgot Form -->
            <!-- IF LINK WAS ALREADY SENT THEN SHOW THIS MESSAGE INSTEAD -->
            @if(session()->has('success'))
                <div class="form-container">
                    <p>
                        An email has been sent to your email address with instructions on how to reset your password.
                    </p>
                    <a href="{{route('login')}}">
                        Back to Login
                    </a>
                </div>
            @else
                <div class="form-container">
                    <p>Enter your email to reset your password</p>
                    <form action="{{route('forgot_password_post')}}" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                            <label for="floatingInput">Email:</label>
                        </div>
                        <button type="submit" class="btn btn-secondary mt-4 w-50">Submit</button>
                    </form>

                    <div class="sign-up mt-4">
                        <a href="{{route('login')}}">
                            Back to Login
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
