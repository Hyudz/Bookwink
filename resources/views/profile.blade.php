@extends('app')
@section('title', 'Profile')
@section('content')

<div class="container-fluid">
    <div class="d-flex flex-column align-items-center mt-5">
        <!-- Profile Section -->
        <div class="ms-5 mt-2 d-flex flex-column align-items-center">
            <div class="row align-items-center">
                <div class="col">
                    <img src="{{ asset('img/pfp.png') }}" style="height: 100px; object-fit: contain;" alt="User Profile">
                </div>
                <div class="col">
                    <h4>{{ $user_details->username }}</h4>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profile</button>
                    
                    <!-- Edit Profile Modal -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Profile</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('update_profile', $user_details->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Username and Birthday -->
                                        <div class="d-flex flex-row w-100 mb-3">
                                            <div class="form-floating w-50">
                                                <input type="text" name="username" required class="form-control" value="{{$user_details->username}}" id="floatingInput" placeholder="Username">
                                                <label for="floatingInput">Username:</label>
                                            </div>
                                            <div class="form-floating w-50 ms-2">
                                                <input type="date" name="birthday" required class="form-control" value="{{$user_details->birthday}}" id="floatingInput" placeholder="Birthday">
                                                <label for="floatingInput">Birthday:</label>
                                            </div>
                                        </div>

                                        <!-- Address and Phone -->
                                        <div class="d-flex flex-row w-100 mb-3">
                                            <div class="form-floating w-50">
                                                <input type="text" name="address" required class="form-control" value="{{$user_details->address}}" id="floatingInput" placeholder="Address">
                                                <label for="floatingInput">Address:</label>
                                            </div>
                                            <div class="form-floating w-50 ms-2">
                                                <div class="input-group">
                                                    <span class="input-group-text">+63</span>
                                                    <input type="tel" name="phone_number" required class="form-control" maxlength="10" value="{{$user_details->phone_number}}" id="floatingInput" placeholder="Phone">
                                                </div>
                                                <label for="floatingInput">Phone:</label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id" value="{{$user_details->id}}">
                                        <button type="submit" class="btn btn-secondary mt-3 w-50">Update</button>
                                    </form>

                                    <!-- Delete Profile Form -->
                                    <form action="{{route('delete_profile', $user_details->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="id" value="{{$user_details->id}}">
                                        <button type="submit" class="btn btn-danger mt-3 w-50">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Modal -->
                </div>
            </div>
        </div>

        <!-- Bookmark and My Borrows Section -->
        <div class="container-fluid mt-3">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <div class="w-50 text-center">
                        <a href="{{route('bookmark')}}" style="color: inherit;">
                            <i class="fa-solid fa-bookmark"></i>
                        </a>
                    </div>
                    <div class="w-50 text-center">
                        <a href="{{route('my_borrows')}}" style="color: inherit;">
                            <i class="fas fa-history"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('contents')
</div>

@endsection
