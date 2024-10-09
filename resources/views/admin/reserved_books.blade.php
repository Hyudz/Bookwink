@extends('admin.app')

@section('title', 'Reserved Books') 
@section('content')
    <h1 class="text-center">Reserved Books</h1>
    <div class="mt-5">
        @if(session()->has('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif

        @if(session()->has('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
    </div>
    <table class="table table-striped">

        <thead>
            <tr>
                <th scope="col">Book ID</th>
                <th scope="col">Author</th>
                <th scope="col">Reserved By</th>
                <th scope="col">Pickup Date </th>
                <th scope="col">Return Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($borrowed_book as $book)
            
            @if($book->status != 'cancelled')
            <tr>
                <td>{{$book->book_id}}</td>
                <td>{{$book->title}}</td>
                <td>{{$book->username}}</td>
                <td>{{$book->borrow_date}}</td>
                <td>{{$book->return_date}}</td>
                <td>{{$book->status}}</td>
                <td class="d-flex flex-row">
                    @if($book->status == 'borrowed')

                    @elseif($book->status == 'request return')
                    <form action="{{route('admin.approve_return',$book->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$book->id}}">
                        <button type="submit" class="btn btn-success">Approve Return</button>
                    </form>

                    <form class="ms-3" action="{{route('admin.reject_return',$book->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$book->id}}">
                        <button type="submit" class="btn btn-danger">Disapprove Return</button>
                    </form>
                    
                    @elseif($book->status != 'approved')
                    <form action="{{route('admin.reject_reservation',$book->id)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Disaprove</button>
                    </form>
                    <form class="ms-3" action="{{route('admin.approve_reservation',$book->id)}}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{$book->id}}">
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>

                    @endif
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
@endsection