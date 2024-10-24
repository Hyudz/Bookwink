@extends('app')
@section('title', $book->title)
@section('content')

<!-- Book Details Section -->
<div class="container-fluid mt-5 d-flex flex-column flex-md-row">

    <!-- Book Cover -->
    <div class="column" style="flex: 1; max-width: 30%;">
        <img src="{{ asset('uploads/' . $book->cover) }}" style="height: 500px; object-fit: contain; width: 100%;" alt="Book Cover">
    </div>

    <!-- Book Information and Actions -->
    <div class="column ms-4" style="flex: 2;">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <h3 class="book-title">{{ $book->title }}</h3>

                <!-- Book Actions -->
                <div class="d-flex flex-column">
                    <!-- Reserve Book Button -->
                    @if(!$isBorrowed)
                    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#reserveModal">Reserve Book</button>
                    @elseif($isBorrowed || $isBorrowedByOthers)
                    <button type="button" disabled class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#reserveModal">Reserve Book</button>
                    @endif
                    
                    <!-- Reserve Book Modal -->
                    <div class="modal fade" id="reserveModal" tabindex="-1" aria-labelledby="reserveModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="reserveModalLabel">Reserve {{ $book->title }}</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    By reserving this book, you agree to the terms and conditions of the library. You will be notified once the book is available for pickup.
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('reserve_book', $book->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Reserve</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookmark Button -->
                    @if($isBookmarked)
                    <form action="{{ route('remove_bookmark', $book->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger mb-2"><i class="fa-solid fa-bookmark"></i> Remove Bookmark</button>
                    </form>
                    @else
                    <form action="{{ route('add_bookmark', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-bookmark"></i> Add to Bookmarks</button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Book Details -->
            <div class="mt-3">
                <p><strong>Author:</strong> {{ $book->author }}</p>
                <p><strong>Status:</strong> {{ $book->status }}</p>
                <p><strong>Average Rating:</strong> {{ $book->rating }}</p>
                <p><strong>Description:</strong> {{ $book->description }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Reviews and Ratings Section -->
<div class="container mt-5">
    <h5>Reviews & Ratings</h5>

    <div class="row">
        <!-- Ratings and Reviews Form -->
        <div class="col-md-6" style="max-height: 400px; overflow-y: auto;">
            <h6>Your Review</h6>
            @if (!$isReviewed)
            <form action="{{ route('add_rrs') }}" method="post">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <!-- Rating -->
                <div class="form-group mb-3">
                    <label for="rating">Rating</label>
                    <div class="star-rating">
                        <input type="radio" name="rating" id="star5" value="5" required><label for="star5">&#9733;</label>
                        <input type="radio" name="rating" id="star4" value="4"><label for="star4">&#9733;</label>
                        <input type="radio" name="rating" id="star3" value="3"><label for="star3">&#9733;</label>
                        <input type="radio" name="rating" id="star2" value="2"><label for="star2">&#9733;</label>
                        <input type="radio" name="rating" id="star1" value="1"><label for="star1">&#9733;</label>
                    </div>
                </div>

                <!-- Review -->
                <div class="form-group">
                    <label for="review">Review</label>
                    <textarea name="review" class="form-control" id="review" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Submit</button>
            </form>
            @else
            @foreach($reviews as $review)
            @if($review->user_id == Auth::user()->id)
            <form action="{{ route('update_rrs', $review->id) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="rr_id" value="{{ $review->id }}">

                <!-- Rating -->
                <div class="form-group mb-3">
                    <label for="rating">Rating</label>
                    <div class="star-rating">
                        <input type="radio" name="rating" id="star5-{{ $review->id }}" value="5" {{ $review->rating == 5 ? 'checked' : '' }} required><label for="star5-{{ $review->id }}">&starf;</label>
                        <input type="radio" name="rating" id="star4-{{ $review->id }}" value="4" {{ $review->rating == 4 ? 'checked' : '' }}><label for="star4-{{ $review->id }}">&starf;</label>
                        <input type="radio" name="rating" id="star3-{{ $review->id }}" value="3" {{ $review->rating == 3 ? 'checked' : '' }}><label for="star3-{{ $review->id }}">&starf;</label>
                        <input type="radio" name="rating" id="star2-{{ $review->id }}" value="2" {{ $review->rating == 2 ? 'checked' : '' }}><label for="star2-{{ $review->id }}">&starf;</label>
                        <input type="radio" name="rating" id="star1-{{ $review->id }}" value="1" {{ $review->rating == 1 ? 'checked' : '' }}><label for="star1-{{ $review->id }}">&starf;</label>
                    </div>
                </div>

                <!-- Review -->
                <div class="form-group">
                    <label for="review-{{ $review->id }}">Review</label>
                    <textarea name="review" class="form-control" id="review-{{ $review->id }}" rows="3" required>{{ $review->review }}</textarea>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Update</button>
            </form>

            <!-- Delete Review -->
            <form action="{{ route('delete_rrs', $review->id) }}" method="post" class="mt-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            @endif
            @endforeach
            @endif
        </div>

        <!-- Display Other Reviews -->
        <div class="col-md-6" style="max-height: 400px; overflow-y: auto;">
            @foreach($reviews as $review)
            @if($review->user_id != Auth::user()->id)
            <div class="border-bottom pb-3 mb-3">
                <p><strong>By:</strong> {{ $review->user->username }}</p>
                <p><strong>Rating:</strong> {{ $review->rating }} &#9733;</p>
                <p><strong>Review:</strong> {{ $review->review }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

@endsection
