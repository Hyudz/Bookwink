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
        <li class="nav-item">
            <a class="nav-link" href="{{route('my_borrows.extend')}}">Extend Borrow</a>
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
            
            @if(!request()->is('my_borrows/returned', 'my_borrows/cancelled', 'my_borrows/rejected', 'my_borrows/extend'))
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
                    @elseif($borrowedBook->status == 'extend')
                        <p class="text-warning">Waiting for Extension approval.</p>
                    @else
                        {{$borrowedBook->status}}
                    @endif
                </td>
                <td>{{$borrowedBook->borrow_date}}</td>
                <td>{{$borrowedBook->return_date}}</td>
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
                        @elseif($borrowedBook->status == 'borrowed' || $borrowedBook->status == 'return rejected' || $borrowedBook->status == 'extendsion rejected || $borrowedBook->status == 'extended')
                            <form action="{{route('return', $borrowedBook->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                                <button type="submit" class="btn btn-success">Return</button>
                            </form>

                            <!--  -->

                            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#reserveModal">Extend Borrow</button>

                            <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="reserveModalLabel">Extend the date to borrow {{ $borrowedBook->title }}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                        <form action="{{route('extend', $borrowedBook->id)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{$borrowedBook->id}}">
                                            <button type="submit" class="btn btn-primary">Extend Borrow</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif($borrowedBook->status == 'extend')
                        @endif
                    </td>
                @endif
            </tr>
            @endforeach
        @endif
    </tbody>
</table>

@endsection
