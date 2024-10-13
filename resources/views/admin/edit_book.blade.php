<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Book</title>
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav>
            @include('admin/navbar')
        </nav>

        <form class="mt-5 d-flex" action="{{route('admin.edit_book_post',$book->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="ms-5 bg-primary">
                <div class="bg-secondary text-white p-3 text-center" style="height: 500px; width: 500px;">
                    <h3>Book Cover</h3>
                    <img src="{{asset('uploads/'.$book->cover)}}" style="height: 300px; object-fit: contain; margin: 25px;" alt="Book Cover">
                    <input type="file" class="form-control" name="book_cover" value="{{$book->cover}}" id="floatingCover">
                </div>
            </div>
            <div class=" container ms-5 me-5">
                    <div class="d-flex justify-content-between">
                        <div class="form-floating mb-3 flex-grow-1 me-2">
                            <input type="text" class="form-control" name="book_name" value="{{$book->title}}" id="floatingTitle">
                            <label for="floatingTitle">Book Title:</label>
                        </div>

                        <div class="form-floating mb-3 flex-grow-1 me-2">
                            <select class="form-select" name="book_category" id="floatingCategory">
                                <option selected>Category:</option>
                                <option value="Fiction">Fiction</option>
                                <option value="Sci-Fi">Science-Fiction</option>
                                <option value="Science">Science</option>
                                <option value="Romance">Romance</option>
                                <option value="Mystery">Mystery</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" name="book_author" value="{{$book->author}}" class="form-control" id="floatingAuthor">
                        <label for="floatingAuthor">Author:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="book_description" id="floatingDescription" style="height: 150px;">{{$book->description}}</textarea>
                        <label for="floatingDescription">Description:</label>
                    </div>

                    <div class="align-self-center">
                        <button type="submit" class="btn btn-secondary">UPDATE</button>
                        <a type="button" href="{{route('admin.manage_books')}}" class="btn btn-danger">CANCEL</a>
                    </div>
            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>