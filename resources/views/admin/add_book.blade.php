<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Book</title>
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav>
            @include('admin/navbar')
        </nav>

        <!-- THIS FILE IS UNUSED AS IT IS MOVED IN A MODAL INSIDE THE MANAGE BOOKS FILE -->

        <div class="container mt-5">
            <h1 class="text-center">Add Book</h1>

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
        </div>

        <form class="mt-5 d-flex" action="{{route('admin.add_books_post')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="ms-5 bg-primary">
                <div class="bg-secondary text-white p-3 text-center" style="height: 500px; width: 500px;">
                    <h3>Book Cover</h3>
                    <input type="file" class="form-control" name="book_cover" id="floatingCover">
                </div>
            </div>
            <div class=" container ms-5 me-5">
                    <div class="d-flex justify-content-between">
                        <div class="form-floating mb-3 flex-grow-1 me-2">
                            <input type="text" maxlength="10" class="form-control" name="book_name" id="floatingTitle">
                            <label for="floatingTitle">Book Title:</label>
                        </div>

                        <div class="form-floating mb-3 flex-grow-1 me-2">
                            <select class="form-select" name="book_category" id="floatingCategory">
                                <option selected>Categoy:</option>
                                <option value="Fiction">Fiction</option>
                                <option value="Sci-Fi">Science-Fiction</option>
                                <option value="Science">Science</option>
                                <option value="Romance">Romance</option>
                                <option value="Mystery">Mystery</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="book_author" class="form-control" id="floatingAuthor">
                        <label for="floatingAuthor">Author:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="book_description" id="floatingDescription" style="height: 150px;"></textarea>
                        <label for="floatingDescription">Description:</label>
                    </div>

                    <div class="align-self-center">
                        <button type="submit" class="btn btn-secondary">ADD BOOK</button>
                    </div>

            </div>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>