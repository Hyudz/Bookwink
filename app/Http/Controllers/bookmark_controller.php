<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bookmarks;
use App\Models\books_table;
use App\Models\rrs_table;
use App\Models\users_table;
use App\Models\borrows_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class bookmark_controller extends Controller
{
    function bookmarks($id) {

        //this is to add a bookmark to the user
        $book = books_table::find($id);

        bookmarks::create([
            'user_id' => Auth::user()->id,
            'book_id' => $id
        ]);

        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        $isBookmarked = $bookIds->contains($id);

        $reviews = rrs_table::where('book_id', $id)->get();
        $userIds = $reviews->pluck('user_id');

        $usernames = users_table::whereIn('id', $userIds)->pluck('username', 'id');

        foreach ($reviews as $review) {
            $review->username = $usernames[$review->user_id] ?? 'Unknown';
        }

        $reviewed = rrs_table::where('user_id', Auth::user()->id)->get();
        $reviewIds = $reviewed->pluck('book_id');
        $isReviewed = $reviewIds->contains($id);
        $isBorrowed = borrows_table::where('user_id', Auth::user()->id)->where('book_id', $id)->where('status', 'pending')->get();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        //SELECT * FROM BOOKS_TABLE WHERE ID = $id
        // SELECT THE BOOK FROM THE DB WITH ITS ID AND RETURN IT WITH THE VIEW

        //PARANG SAME FUNCTION LANG DIN KAY VIEW BOOK PERO ITO YUNG FUNCTION PARA SA BOOKMARKS
        return view('view_book', ['book' => $book, 'isBookmarked' => $isBookmarked,  'reviews' => $reviews, 'isReviewed' => $isReviewed, 'isBorrowed' => $isBorrowed, 'notifications' => $notifications]);
    }

    function bookmark() { 

        //returns the bookmarks of the user
        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        $books = books_table::whereIn('id', $bookIds)->get();

        $user_details = Auth::user();

        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('bookmarks', ['books' => $books, 'user_details' => $user_details, 'notifications' => $notifications]);
    }

    function remove_bookmark($id) {

        //SELECT * FROM BOOKMARKS_TABLE WHERE USER_ID = $id
        // DELETE FROM BOOKMARKS_TABLE WHERE USER_ID = $id AND BOOK_ID = $id
        bookmarks::where('user_id', Auth::user()->id)->where('book_id', $id)->delete();

        //REDIRECT TO THE BOOKMARKS PAGE WITH SUCCESS MESSAGE
        return redirect()->route('bookmark')->with('success', 'Bookmark removed successfully');
    }
}
