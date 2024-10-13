@extends('profile')
@section('title', 'My Borrows')
@section('contents')
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
@endsection