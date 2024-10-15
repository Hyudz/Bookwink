@extends('profile')
@section('contents')

    <div class="container-fluid">
        <!-- HERE LIES THE BOOKS -->
            <div class="row">

            @if($books->isEmpty())
                <div class="col-md-12">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img src="{{ asset('img/bored.png') }}" alt="empty" style="height: 200px; margin-bottom: 20px;">
                        <h1 class="text-center mb-3">Your bookmarks are feeling lonely. Give them some company!</h1>
                        <a href="{{ route('homepage') }}" class="btn btn-primary">Explore our collections</a>
                    </div>
                </div>
            @else
            @foreach($books as $book)
            <div class="col-md-3">
                <a href="{{route('view_books', $book->id)}}" style="text-decoration: none;">
                    <div class="card mt-5">
                        <img class="card-img-top" style="height: 200px; object-fit: cover;" src="{{asset('uploads/'.$book->cover)}}" alt="book image">
                        <div class="card-body">
                            <h5 class="card-title" id="book">{{$book->title}}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            @endif

            </div>
        </div>
@endsection