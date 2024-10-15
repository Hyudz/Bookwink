@extends('app')
@section('title', $book->title)
@section('content')

    <div class="container-fluid mt-5 d-flex">
        <div class="column">
            <img src="{{asset('uploads/'.$book->cover)}}" style="height: 500px; object-fit: contain;" alt="Book Cover">
        </div>
    <div class="column" style="margin-left: 20px;">
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h5>{{$book->title}}</h5>
                <div class="container-fluid">

                    @if($isBorrowed->isNotEmpty())
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelReserve">Cancel Reservation</button>
                    <div class="modal fade" id="cancelReserve" tabindex="-1" aria-labelledby="cancelReserveLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="reservModalLabel">Cancel Reserving {{$book->title}}?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to cancel your reservation for {{$book->title}}?
                                </div>
                            <div class="modal-footer">

                                @foreach($isBorrowed as $borrowed)
                                <form action="{{route('cancel',$borrowed->id)}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{$book->id}}">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- else statement -->
                    @else
                        @if($book->status == 'available')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserveModal">Reserve Book</button>
                            <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reservModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="reservModalLabel">Reserve {{$book->title}}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            By reserving this book, you agree to the terms and conditions of the library. You will be notified once the book is available for pickup.
                                        </div>
                                    <div class="modal-footer">

                                        <form action="{{route('reserve_book',$book->id)}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Reserve</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reserveModal" disabled>Reserve Book</button>
                        @endif
                    @endif
                    <!-- endif -->
                </div>
            
                @if($isBookmarked)
                <form action="{{route('remove_bookmark',$book->id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-bookmark"></i></button>
                </form>
                @else
                <form action="{{route('add_bookmark',$book->id)}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-bookmark"></i></button>
                </form>
                @endif
            </div>
        </div>

        <div class="d-flex">
            <p>Author: {{$book->author}}</p>
            <p class="ms-3">Average Rating: {{$book->rating}}</p>
            <p class="ms-3">Category: {{$book->category}}</p>
            <p class="ms-3">Status: 
                @if($book->status == 'available')
                    <p class="text-success ms-1">Available</p>
                @else
                    <p class="text-danger ms-1">Unavailable</p>
                @endif
            </p>
        </div>
        <p>Summary: {{$book -> description}}</p>
    </div>

        <div class="container mt-5">
            @if (!$isReviewed)
            <div class="container mb-3">
                <h6>Your Review</h6>
                <form action="{{ route('add_rrs') }}" method="post">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <div class="star-rating">
                            <input type="radio" name="rating" id="star5" value="5" required><label for="star5">&#9733;</label>
                            <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
                            <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
                            <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
                            <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea name="review" class="form-control" id="review" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h6>Reviews</h6>
                @foreach($reviews as $review)
                <div class="container mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>Rating: {{$review->rating}}</p>
                            <p>Review: {{$review->review}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else

            <div class="container mb-3">
                @foreach($reviews as $review)
                @if($review->user_id == Auth::user()->id)
                    <h6>Your Review</h6>
                    <form action="{{ route('update_rrs', $review->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="rr_id" value="{{ $review->id }}">
                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="star-rating">
                                <input type="radio" name="rating" id="star5-{{ $review->id }}" value="5" {{ $review->rating == 5 ? 'checked' : '' }} required><label for="star5-{{ $review->id }}">&starf;</label>
                                <input type="radio" name="rating" id="star4-{{ $review->id }}" value="4" {{ $review->rating == 4 ? 'checked' : '' }}><label for="star4-{{ $review->id }}">&starf;</label>
                                <input type="radio" name="rating" id="star3-{{ $review->id }}" value="3" {{ $review->rating == 3 ? 'checked' : '' }}><label for="star3-{{ $review->id }}">&starf;</label>
                                <input type="radio" name="rating" id="star2-{{ $review->id }}" value="2" {{ $review->rating == 2 ? 'checked' : '' }}><label for="star2-{{ $review->id }}">&starf;</label>
                                <input type="radio" name="rating" id="star1-{{ $review->id }}" value="1" {{ $review->rating == 1 ? 'checked' : '' }}><label for="star1-{{ $review->id }}">&starf;</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="review-{{ $review->id }}">Review</label>
                            <textarea name="review" class="form-control" id="review-{{ $review->id }}" rows="3" required>{{ $review->review }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                    <form action="{{ route('delete_rrs', $review->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
                @endforeach
            </div>
            @foreach($reviews as $review)
                <div class="container mb-3">
                    @if($review->user_id != Auth::user()->id)
                    <!-- For other users' reviews, display as static content -->
                    <div>
                        <p>By: {{$review->user->username}}</p>
                        <p>Rating: {{$review->rating}}</p>
                        <p>Review: {{$review->review}}</p>
                    </div>
                    @endif
                </div>
            @endforeach
            @endif
        </div>


    </div>
</div>

@endsection