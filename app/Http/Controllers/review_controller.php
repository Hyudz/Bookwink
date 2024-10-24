<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rrs_table;
use App\Models\books_table;
use App\Models\bookmarks;
use App\Models\users_table;
use Illuminate\Support\Facades\Auth;

class review_controller extends Controller
{
    function add_review(Request $request){

        $request->validate([
            'review' => 'required',
            'rating' => 'required',
        ]);

        //SQL CODE: INSERT INTO RRS_TABLE VALUES ('user_id', 'book_id', 'review', 'rating')

        rrs_table::create([
            'user_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        //COUNTS THE NUMBER OF USERS WHO RATED THE BOOK
        //SQL CODE: SELECT COUNT(*) FROM RRS_TABLE WHERE BOOK_ID = $request->book_id
        $usersRated = rrs_table::where('book_id', $request->book_id)->get()->count();

        //SUMS ALL THE RATINGS OF THE BOOK
        //SQL CODE: SELECT SUM(RATING) FROM RRS_TABLE WHERE BOOK_ID = $request->book_id
        $sumRatings = rrs_table::where('book_id', $request->book_id)->sum('rating');

        //COMPUTES THE AVERAGE RATING OF THE BOOK
        $averageRating = $sumRatings / $usersRated;

        //UPDATES THE AVERAGE RATING OF THE BOOK
        //SQL CODE: UPDATE BOOKS_TABLE SET RATING = $averageRating WHERE ID = $request->book_id
        $book = books_table::find($request->book_id);
        $book->update([
            'rating' => $averageRating,
        ]);

        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        $isBookmarked = $bookIds->contains($request->book_id);

        $reviews = rrs_table::where('book_id')->get();
        $userIds = $reviews->pluck('user_id');

        $usernames = users_table::whereIn('id', $userIds)->pluck('username', 'id');

        foreach ($reviews as $review) {
            $review->username = $usernames[$review->user_id] ?? 'Unknown';
        }

        $reviewed = rrs_table::where('user_id', Auth::user()->id)->get();
        $reviewIds = $reviewed->pluck('book_id');
        $isReviewed = $reviewIds->contains($request->book_id);

        return redirect()->route('view_books', ['id' => $request->book_id, 'isBookmarked' => $isBookmarked, 'isReviewed' => $isReviewed ])->with('success', 'Review added successfully');

    }

    function update_review(Request $request, $id){

        $request->validate([
            'review' => 'required',
            'rating' => 'required',
        ]);
    
        // FIND THE REVIEW USING THE ID PASSED
        $review = rrs_table::find($id);
    
        $review->update([
            'review' => $request->review,
            'rating' => $request->rating,
        ]);
    
        $book_id = $review->book_id;
        // COUNT THE NUMBER OF USERS WHO RATED THE BOOK
        $usersRated = rrs_table::where('book_id', $book_id)->count();
    
        // SUM ALL THE RATINGS OF THE BOOK
        $sumRatings = rrs_table::where('book_id', $book_id)->sum('rating');
    
        $averageRating = $usersRated > 0 ? $sumRatings / $usersRated : 0;
        $book = books_table::find($book_id);
        $book->update([
            'rating' => $averageRating,
        ]);
    
        return redirect()->route('view_books', ['id' => $book_id])->with('success', 'Review updated successfully');
    }

    function delete_review($id){

        $review = rrs_table::find($id);
        $book_id = $review->book_id;
        $review->delete();
    
        $usersRated = rrs_table::where('book_id', $book_id)->count();
        $sumRatings = rrs_table::where('book_id', $book_id)->sum('rating');
        $averageRating = $usersRated > 0 ? $sumRatings / $usersRated : 0;

        $book = books_table::find($book_id);
        $book->update([
            'rating' => $averageRating,
        ]);
    
        return redirect()->route('view_books', ['id' => $book_id])->with('success', 'Review deleted successfully');
    }
}
