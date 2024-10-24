@extends('admin.manage_books') <!-- This should extend the main layout -->

@section('admin.book_contents') 
    <table class="table table-striped">

        <thead>
            <tr>
                <th scope="col">Book ID</th>
                <th scope="col">Author</th>
                <th scope="col">Reserved By</th>
                <th scope="col">Pickup Date </th>
                <th scope="col">Return Date</th>
                <th scope="col">Status</th>
                @foreach($borrowed_book as $book)
                    @if(!$book->status == 'pending' || $book->status == 'request return')
                        <th scope="col">Action</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            
            @foreach($borrowed_book as $book)
            <tr>
                <td>{{$book->book_id}}</td>
                <td>{{$book->title}}</td>
                <td>{{$book->username}}</td>
                <td>{{$book->borrow_date}}</td>
                <td>{{$book->return_date}}</td>
                <td>{{$book->status}}</td>
                @if($book->status == 'pending')
                    <td class="d-flex flex-row">
                        <form action="{{route('admin.reject_reservation', $book->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Disapprove</button>
                        </form>

                        <form class="ms-3" action="{{route('admin.approve_reservation', $book->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </td>
                @elseif($book->status == 'request return')
                    <td class="d-flex flex-row">
                        <form action="{{route('admin.approve_return', $book->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve Return</button>
                        </form>

                        <form class="ms-3" action="{{route('admin.reject_return', $book->id)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Disapprove Return</button>
                        </form>
                    </td>
                @endif
                
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection