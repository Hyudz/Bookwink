@extends('app')
@section('title', 'Profile')
@section('content')

        <nav>
            <div class="bg-secondary">
                &nbsp;
            </div>
        </nav>

        <div class="d-flex">
            <div class=" d-flex flex-column">
                <h1>Profile Page</h1>
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
@endsection