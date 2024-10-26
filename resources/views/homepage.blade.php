@extends('app')
@section('title', 'Homepage')
@section('content')
    <div class="container-fluid">
        @php
            $booksByCategory = $books->groupBy('category');
        @endphp

        @foreach($booksByCategory as $category => $books)
            <div class="category-title m-3 text-white text-center p-3" style="background-color: #835D1C;">
                <h3 class="m-0">{{ strtoupper($category) }}</h3>
            </div>
            
            <div class="row">

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

            </div>
        @endforeach
    </div>
@endsection
