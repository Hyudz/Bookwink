<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <nav>
        @include('navbar')
    </nav>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Book Name</th>
                <th scope="col">Status</th>
                <th scope="col">Date Borrowed</th>
                <th scope="col">Due Date</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($borrowedBooks as $borrowedBook)
            <tr>
                <td>{{$borrowedBook->title}}</td>
                <td>
                    @if($borrowedBook->status == 'request return')
                        <p class="text-danger">Waiting for approval</p>
                    @elseif($borrowedBook->status == 'Rejected')
                        <p class="text-danger" title="The book is not yet confirmed to that it is returned.">Rejected</p>
                    @else
                    {{$borrowedBook->status}}
                    @endif
                </td>
                <td>{{$borrowedBook->borrow_date}}</td>
                <td>{{$borrowedBook->return_date}}</td>
                <td>
                    @if($borrowedBook->status == 'pending')
                    <form action="{{route('cancel',$borrowedBook->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                        <button type="submit" class="btn btn-danger">Cancel</button>
                    </form>
                    @elseif($borrowedBook->status == 'approved')
                    <form action="{{route('pickup',$borrowedBook->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                        <button type="submit" class="btn btn-success">Picked Up</button>
                    </form>
                    @elseif($borrowedBook->status == 'borrowed' || $borrowedBook->status == 'rejected')
                    <form action="{{route('return',$borrowedBook->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                        <button type="submit" class="btn btn-success">Return</button>
                    </form>
                    @elseif($borrowedBook->status == 'request return')
                    
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-5Z5Zg5z4l3h6bXrZj7z0nflz9fZz9z0>
</body>
</html>