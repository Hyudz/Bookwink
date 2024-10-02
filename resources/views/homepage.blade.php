<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="min-vh-100">
        <nav>
            @include('navbar')
        </nav>

        <div class="container-fluid">
        <!-- HERE LIES THE BOOKS -->
        <div class="row">

        @foreach($books as $book)
        <div class="col-md-3">
            <a href="{{route('view_books', $book->id)}}" style="text-decoration: none;">
                <div class="card mt-5">
                    <img class="card-img-top" style="height: 200px; object-fit: contain;" src="{{asset('uploads/1.png')}}" alt="book image">
                    <div class="card-body">
                        <h5 class="card-title" id="book">{{$book->title}}</h5>
                        <p class="card-text" style="text-align: justify;">{{$book->description}}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>