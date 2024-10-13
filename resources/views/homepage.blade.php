@extends('app')
@section('title', 'Homepage')
@section('content')
        <div class="container-fluid">
        <!-- HERE LIES THE BOOKS -->
            <div class="row">

            @foreach($books as $book)
            <div class="col-md-3">
                <a href="{{route('view_books', $book->id)}}" style="text-decoration: none;">
                    <div class="card mt-5">
                        <img class="card-img-top" style="height: 200px; object-fit: cover;" src="{{asset('uploads/'.$book->cover)}}" alt="book image">
                        <div class="card-body">
                            <h5 class="card-title" id="book">{{$book->title}}</h5>
                            <button class="btn btn-primary">Read More</button>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            </div>

        </div>
@endsection