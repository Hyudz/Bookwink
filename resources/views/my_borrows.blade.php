@extends('profile')
@section('title', 'My Borrows')
@section('contents')

<div class="container-fluid d-flex justify-content-center">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows')}}">Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.pending')}}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.cancelled')}}">Cancelled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.approved')}}">Approved</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.rejected')}}">Rejected</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.returning')}}">Return Books</a>
        </li>
    </ul>
</div>


<div class="mt-5">
    @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
            @endforeach
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
</div>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Book Name</th>
            <th scope="col">Status</th>
            <th scope="col">Date Borrowed</th>
            <th scope="col">Due Date</th>
            
            @if(!request()->is('my_borrows/returned', 'my_borrows/cancelled', 'my_borrows/rejected'))
                <th scope="col">Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($borrowedBooks->isEmpty())
            <tr>
                <td colspan="5">
                    <div class="col-md-12">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img src="{{ asset('img/jeyk.png') }}" alt="empty" style="height: 200px; margin-bottom: 20px;">
                            <h1 class="text-center mb-3">Your reading journey starts here. Borrow a book!</h1>
                            <a href="{{ route('homepage') }}" class="btn btn-primary">Explore our collections</a>
                        </div>
                    </div>
                </td>
            </tr>
        @else
            @foreach($borrowedBooks as $borrowedBook)
            <tr>
                <td>{{$borrowedBook->title}}</td>
                <td>
                    @if($borrowedBook->status == 'request return')
                        <p class="text-danger">Waiting for approval</p>
                    @elseif($borrowedBook->status == 'return rejected')
                        <p class="text-danger" title="The book is not yet confirmed to that it is returned.">Rejected</p>
                    @else
                        {{$borrowedBook->status}}
                    @endif
                </td>
                <td>{{$borrowedBook->borrow_date}}</td>
                <td>{{$borrowedBook->return_date}}</td>

                {{-- Show Action buttons only if the route is not 'books', 'cancelled', or 'rejected' --}}
                @if(!request()->is('my_borrows', 'my_borrows/cancelled', 'my_borrows/rejected'))
                    <td>
                        @if($borrowedBook->status == 'pending')
                            <form action="{{route('cancel', $borrowedBook->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                        @elseif($borrowedBook->status == 'approved')
                            <form action="{{route('pickup', $borrowedBook->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                                <button type="submit" class="btn btn-success">Picked Up</button>
                            </form>
                        @elseif($borrowedBook->status == 'borrowed' || $borrowedBook->status == 'return rejected')
                            <form action="{{route('return', $borrowedBook->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                                <button type="submit" class="btn btn-success">Return</button>
                            </form>
                        @endif
                    </td>
                @endif
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

@endsection
