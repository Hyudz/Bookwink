<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Book</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav>
            @include('admin/navbar')
        </nav>

        <div class="container-fluid mt-5 d-flex">
            <div class="column">
                <div class="bg-secondary text-white p-3 text-center" style="height: 500px; width: 500px;">
                    <h3>Book Cover</h3>
                </div>
            </div>
            <div class="column" style="margin-left: 20px;">
                <div class="col">
                    <div class="d-flex justify-content-between">
                        <div class="form-floating mb-3 flex-grow-1 me-2">
                            <input type="text" class="form-control" id="floatingTitle">
                            <label for="floatingTitle">Book Title:</label>
                        </div>

                        <div class="align-self-center">
                            <button type="submit" class="btn btn-secondary">ADD BOOK</button>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingAuthor">
                        <label for="floatingAuthor">Author:</label>
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="floatingDescription" style="height: 150px;"></textarea>
                        <label for="floatingDescription">Description:</label>
                    </div>
                </div>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>