<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$book->title}}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body class="min-vh-100">
        <nav>
            @include('navbar')
        </nav>

        <div class="container-fluid mt-5 d-flex">
    <div class="column">
        <img src="{{asset('uploads/'.$book->cover)}}" style="height: 500px; object-fit: contain;" alt="Book Cover">
    </div>
    <div class="column" style="margin-left: 20px;">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h5>{{$book->title}}</h5>
                <div class="container-fluid">
                    <a href="#" class="btn btn-primary">Reserve Book</a>

                    @if($isBookmarked)
                    <form action="{{route('remove_bookmark',$book->id)}}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-bookmark"></i></button>
                    </form>
                    @else
                    <form action="{{route('add_bookmark',$book->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-bookmark"></i></button>
                    </form>
                    @endif
                </div>
            </div>
            <p>Author: {{$book->author}}</p>
            <p>Summary: {{$book -> description}}</p>
        </div>
    </div>
</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>