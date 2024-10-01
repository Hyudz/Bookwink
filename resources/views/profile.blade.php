<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

        <nav>
            <div class="bg-secondary">
                &nbsp;
            </div>
        </nav>

        <div class="d-flex">
            <div class=" d-flex flex-column">
                <h1>Profile Page</h1>

                <a href="{{route('login')}}" type="button" class="btn btn-primary">Logout</a>
            </div>

            <div class="ms-5 d-flex flex-column">
                <h1>PROFILE</h1>


                <form action="{{route('update_profile', $user_details -> id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="d-flex flex-row w-100">

                        <!-- name age bday sex address cp number -->

                        <div class="form-floating mb-3">
                            <input type="text" name="username" required class="form-control" value="{{$user_details -> username}}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Username:</label>
                        </div>

                        <div class="form-floating mb-3 ms-1">
                            <input type="date" name="birthday" required class="form-control" value="{{$user_details -> birthday}}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Birthday:</label>
                        </div>
                    </div>

                    <div class="d-flex flex-row w-100">

                        <!-- name age bday sex address cp number -->

                        <div class="form-floating mb-3">
                            <input type="text" name="address" required class="form-control" value="{{$user_details -> address}}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Addres:</label>
                        </div>

                        <div class="mb-3 mt-3 ms-3">
                            +63
                        </div>

                        <div class="form-floating mb-3 ms-1">
                            <input type="number" name="phone_number" required class="form-control" maxlength="10" value="{{$user_details -> phone_number}}" id="floatingInput" placeholder="">
                            <label for="floatingInput">Phone:</label>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{$user_details -> id}}">

                    <button type="submit" class="btn btn-primary mt-5 w-25">Update</button>
                </form>

                <form action="{{route('delete_profile', $user_details -> id)}}" method="POST">
                    @csrf
                    @method('DELETE')

                    <input type="hidden" name="id" value="{{$user_details -> id}}">

                    <button type="submit" class="btn btn-danger mt-5 w-25">Delete</button>
                </form>

            </div>
            
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
</body>
</html>