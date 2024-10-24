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
                        <a href="{{ route('view_books', $book->id) }}" style="text-decoration: none;">
                            <div class="book-card mt-3">
                                <img src="{{ asset('uploads/' . $book->cover) }}" style="object-fit: cover;" class="bg-image">
                                
                                <div class="gradient-overlay">
                                    <h5 class="overlay-title">{{ $book->title }}</h5>
                                    <h6 class="overlay-author">{{ $book->author }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif

            </div>
        </div>
@endsection