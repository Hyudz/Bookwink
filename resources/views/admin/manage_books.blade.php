@extends('admin.app')
@section('title', 'Manage Books')
@section('content')
<div class="min-vh-100 mt-5">
        <div class="mt-5">
            <div>
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
    
    <div class="modal fade" id="add_book" tabindex="-1" aria-labelledby="add_book_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add_book_label">Add Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.add_books_post') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Book Cover -->
                            <div class="col-md-4 text-center">
                                <div class="bg-secondary text-white p-3">
                                    <h5>Book Cover</h5>
                                    <input type="file" required class="form-control" name="book_cover" id="floatingCover">
                                </div>
                            </div>

                            <!-- Book Details -->
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Book Title -->
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" maxlength="50" minlength="3" name="book_name" id="floatingTitle">
                                            <label for="floatingTitle">Book Title:</label>
                                        </div>
                                    </div>

                                    <!-- Book Category -->
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="book_category" id="floatingCategory" aria-label="Select a book Category">
                                                <option selected disabled></option>
                                                <option value="Fiction">Fiction</option>
                                                <option value="Sci-Fi">Science-Fiction</option>
                                                <option value="Science">Science</option>
                                                <option value="Romance">Romance</option>
                                                <option value="Mystery">Mystery</option>
                                                <option value="Non-Fiction">Non-Fiction</option>
                                                <option value="Biography">Biography</option>
                                                <option value="Historical Fiction">Historical Fiction</option>
                                                <option value="Fantasy">Fantasy</option>
                                                <option value="Self-Help">Self-Help</option>
                                                <option value="Thriller">Thriller</option>
                                                <option value="Adventure">Adventure</option>
                                                <option value="Young Adult">Young Adult</option>
                                                <option value="Manga">Manga</option>
                                                <option value="Education">Education</option>
                                                <!-- <option value="Poetry">Poetry</option>
                                                <option value="Graphic Novels">Graphic Novels</option>
                                                <option value="Horror">Horror</option>
                                                <option value="Philosophy">Philosophy</option>
                                                <option value="Health and Wellness">Health and Wellness</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Cooking">Cooking</option>
                                                <option value="Children">Children</option>
                                                <option value="Art">Art</option>
                                                <option value="Dark Fantasy">Dark Fantasy</option>
                                                <option value="Manhua">Manhua</option>
                                                <option value="Webtoon">Webtoon</option> -->
                                            </select>
                                            <label for="floatingCategory">Category:</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Author -->
                                <div class="form-floating mb-3">
                                    <input type="text" required name="book_author" pattern="^[a-zA-Z\s\.\-]+$" title="The book author must contain only letters, spaces, dashes, and periods." class="form-control" minlength="3" maxlength="50" id="floatingAuthor">
                                    <label for="floatingAuthor">Author:</label>
                                </div>

                                <!-- Description -->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" required name="book_description" minlength="50" maxlength="2000" id="floatingDescription" style="height: 100px;"></textarea>
                                    <label for="floatingDescription">Description:</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Book</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.manage_books')}}">Books</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.reserved_books')}}">Pending</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.cancelled_borrow')}}">Cancelled</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.approved_books')}}">Approved</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.rejected_books')}}">Rejected</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.returning_books')}}">Returned Books</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.returned_books')}}">Returned</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('admin.extension_request')}}">Extension Requests</a>
        </li>

        <li class="nav-item">
            <a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#add_book">
                <i class="fa-solid fa-plus me-3"></i><span>Add Book</span>
            </a>
        </li>
    </ul>

    <!-- Table of Books -->
    @yield('admin.book_contents')

</div>
@endsection
