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

        <div class="col-md-3">
            <a href="{{route('view_books')}}" style="text-decoration: none;">
                <div class="card mt-5">
                    <img class="card-img-top" style="height: 200px; object-fit: contain;" src="{{asset('uploads/1.png')}}" alt="book image">
                    <div class="card-body">
                        <h5 class="card-title" id="book1">Harry Potter and the Philosopher's Stone</h5>
                        <p class="card-text" style="text-align: justify;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta quasi deserunt corrupti voluptates? Sit tenetur, non dignissimos, obcaecati quos animi nesciunt officiis cupiditate beatae a natus odio aliquid officia hic!</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="" style="text-decoration: none;">
                <div class="card mt-5">
                    <img class="card-img-top" style="height: 200px; object-fit: contain;" src="{{asset('uploads/2.png')}}" alt="book image">
                    <div class="card-body">
                        <h5 class="card-title" id="book2">Harry Potter and the Chamber of Secrets</h5>
                        <p class="card-text" style="text-align: justify;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta quasi deserunt corrupti voluptates? Sit tenetur, non dignissimos, obcaecati quos animi nesciunt officiis cupiditate beatae a natus odio aliquid officia hic!</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="" style="text-decoration: none;">
                <div class="card mt-5">
                    <img class="card-img-top" style="height: 200px; object-fit: contain;" src="{{asset('uploads/3.png')}}" alt="book image">
                    <div class="card-body">
                        <h5 class="card-title" id="book3">Harry Potter and the Prisoner of Azkaban</h5>
                        <p class="card-text" style="text-align: justify;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta quasi deserunt corrupti voluptates? Sit tenetur, non dignissimos, obcaecati quos animi nesciunt officiis cupiditate beatae a natus odio aliquid officia hic!</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">
            <a href="" style="text-decoration: none;">
                <div class="card mt-5">
                    <img class="card-img-top" style="height: 200px; object-fit: contain;" src="{{asset('uploads/4.png')}}" alt="book image">
                    <div class="card-body">
                        <h5 class="card-title" id="book4">Harry Potter and the Goblet of Fire</h5>
                        <p class="card-text" style="text-align: justify;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Soluta quasi deserunt corrupti voluptates? Sit tenetur, non dignissimos, obcaecati quos animi nesciunt officiis cupiditate beatae a natus odio aliquid officia hic!</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>