@extends('admin.manage_books') 

@section('admin.book_contents')
<table class="table table-striped">
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Status</th>
        <th>Manage</th>
    </tr>
    @foreach($books as $book)
        <tr>
            <td>{{$book->title}}</td>
            <td>{{$book->author}}</td>
            <td>{{$book->category}}</td>
            <td>{{$book->status}}</td>
            <td class="d-flex flex-row">
                <!-- <a href="{{route('admin.edit_book', $book->id)}}" class="btn btn-primary">Edit</a> -->
                <a data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit_book_{{$book->id}}">
                    <button type="button" class="btn btn-primary">EDIT</button>
                </a>
                <div class="modal fade" id="edit_book_{{$book->id}}" tabindex="-1" aria-labelledby="add_book_label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="add_book_label">Edit {{$book->title}}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('admin.edit_book_post', $book->id) }}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="row">
                                        <!-- Book Cover -->
                                        <div class="col-md-4 text-center">
                                            <div class="p-3 bg-secondary text-white rounded">
                                                <h5 class="mb-3">Book Cover</h5>
                                                <img src="{{ asset('uploads/'.$book->cover) }}" class="img-fluid mb-3" alt="Book Cover" style="max-height: 300px; object-fit: contain;">
                                                <input type="file" class="form-control" name="book_cover" id="floatingCover">
                                            </div>
                                        </div>

                                        <!-- Book Details -->
                                        <div class="col-md-8">
                                            <div class="row">
                                                <!-- Book Title -->
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" class="form-control" name="book_name" value="{{ $book->title }}" id="floatingTitle">
                                                        <label for="floatingTitle">Book Title:</label>
                                                    </div>
                                                </div>

                                                <!-- Book Category -->
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select" name="book_category" id="floatingCategory" aria-label="Select a book category">
                                                            <option selected disabled></option>
                                                            <option value="Fiction" {{ $book->category == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                                                            <option value="Sci-Fi" {{ $book->category == 'Sci-Fi' ? 'selected' : '' }}>Science-Fiction</option>
                                                            <option value="Science" {{ $book->category == 'Science' ? 'selected' : '' }}>Science</option>
                                                            <option value="Romance" {{ $book->category == 'Romance' ? 'selected' : '' }}>Romance</option>
                                                            <option value="Mystery" {{ $book->category == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                                                            <option value="Non-Fiction" {{ $book->category == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                                                            <option value="Biography" {{ $book->category == 'Biography' ? 'selected' : '' }}>Biography</option>
                                                            <option value="Historical Fiction" {{ $book->category == 'Historical Fiction' ? 'selected' : '' }}>Historical Fiction</option>
                                                            <option value="Fantasy" {{ $book->category == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                                                            <option value="Self-Help" {{ $book->category == 'Self-Help' ? 'selected' : '' }}>Self-Help</option>
                                                            <option value="Thriller" {{ $book->category == 'Thriller' ? 'selected' : '' }}>Thriller</option>
                                                            <option value="Adventure" {{ $book->category == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                                            <option value="Young Adult" {{ $book->category == 'Young Adult' ? 'selected' : '' }}>Young Adult</option>
                                                            <option value="Manga" {{ $book->category == 'Manga' ? 'selected' : '' }}>Manga</option>
                                                            <option value="Education" {{ $book->category == 'Education' ? 'selected' : '' }}>Education</option>
                                                            <!-- <option value="Poetry" {{ $book->category == 'Poetry' ? 'selected' : '' }}>Poetry</option>
                                                            <option value="Graphic Novels" {{ $book->category == 'Graphic Novels' ? 'selected' : '' }}>Graphic Novels</option>
                                                            <option value="Horror" {{ $book->category == 'Horror' ? 'selected' : '' }}>Horror</option>
                                                            <option value="Philosophy" {{ $book->category == 'Philosophy' ? 'selected' : '' }}>Philosophy</option>
                                                            <option value="Health and Wellness" {{ $book->category == 'Health and Wellness' ? 'selected' : '' }}>Health and Wellness</option>
                                                            <option value="Travel" {{ $book->category == 'Travel' ? 'selected' : '' }}>Travel</option>
                                                            <option value="Cooking" {{ $book->category == 'Cooking' ? 'selected' : '' }}>Cooking</option>
                                                            <option value="Children" {{ $book->category == 'Children' ? 'selected' : '' }}>Children</option>
                                                            <option value="Art" {{ $book->category == 'Art' ? 'selected' : '' }}>Art</option>
                                                            <option value="Dark Fantasy" {{ $book->category == 'Dark Fantasy' ? 'selected' : '' }}>Dark Fantasy</option>
                                                            <option value="Manhua" {{ $book->category == 'Manhua' ? 'selected' : '' }}>Manhua</option>
                                                            <option value="Webtoon" {{ $book->category == 'Webtoon' ? 'selected' : '' }}>Webtoon</option> -->
                                                        </select>
                                                        <label for="floatingCategory">Category:</label>
                                                    </div>

                                                    <div class="form-floating mb-3">
                                                    <select class="form-select" name="book_status" id="floatingCategory" aria-label="Select a book category" 
                                                            {{ $book->status == 'reserved' ? 'disabled' : '' }}>
                                                        <option selected disabled></option>
                                                        <option value="available" {{ $book->status == 'available' ? 'selected' : '' }}>Available</option>
                                                        <option value="hidden" {{ $book->status == 'hidden' ? 'selected' : '' }}>Hidden</option>
                                                    </select>

                                                    @if ($book->status == 'reserved')
                                                        <span class="text-danger">Reserved</span>
                                                    @endif


                                                        <label for="floatingStatus">Status:</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Author -->
                                            <div class="form-floating mb-3">
                                                <input type="text" name="book_author" value="{{ $book->author }}" class="form-control" id="floatingAuthor">
                                                <label for="floatingAuthor">Author:</label>
                                            </div>

                                            <!-- Description -->
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" name="book_description" id="floatingDescription" style="height: 150px;">{{ $book->description }}</textarea>
                                                <label for="floatingDescription">Description:</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Update Button -->
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <form class="ms-3" action="{{route('admin.delete_book', $book->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
@endsection
