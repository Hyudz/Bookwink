<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users_table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\bookmarks;
use Illuminate\Support\Facades\DB;
use App\Models\books_table;
use App\Models\borrows_table;
use App\Models\rrs_table;

class web_controller extends Controller
{

    //THIS CONTROLLER IS FOR THE CLIENT SIDE OF THE APPLICATION
    function index() {
        //REDIRECTS TO THE LANDING PAGE
        return view('index');
    }

    function login() {
        //REDIRECTS TO THE LOGIN PAGE
        return view('login');
    }

    function logout() {
        //LOGOUT THE USER AND REDIRECT TO THE LANDING PAGE
        Auth::logout();
        return redirect()->route('login');
    }

    function signup() {

        //REDIRECTS TO THE SIGNUP PAGE
        return view('signup');
    }

    function homepage() {

        //SELECTS ALL THE BOOKS FROM THE DATABASE AND RETURNS IT WITH THE VIEW

        $books = books_table::all()->where('status', 'available');
        return view('homepage',['books' => $books]);
    }

    function login_post(Request $request){

        //VALIDATES THE REQUEST AND ATTEMPTS TO LOGIN THE USER
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // ATTEMP TO CHECK THE USER IS ADMIN AND REDIRECT TO ITS PROPER VIEW
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful');
            }
            return redirect()->route('homepage')->with('success', 'Login successful');
        }
        return redirect()->route('login')->with(['error' => 'Invalid email or password']);
    }
    

    function signup_post(Request $request) {

        //VALIDATES THE REQUEST AND CREATES A NEW USER

        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'birthday' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        //INSERT INTO USERS_TABLES VALUES ('username', 'email', 'password', 'age', 'birthday','gender', 'address', 'user_type', 'phone_number');
        
        $user = users_table::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => 18,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'user_type' => 'user',
            'phone_number' => $request->phone_number
        ]);

        //AUTO LOGIN AFTER CREATING A NEW USER

        if ($user) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::attempt($credentials)) {   
                return redirect()->route('homepage')->with('success', 'User created successfully');
            }
        } else {
            //ELSE REDIRECT TO SIGNUP PAGE WITH ERROR
            return redirect()->route('signup')->with('error', 'User not created');
        }

    }
    

    function view_books($id) {

        //SELECTS THE DETAILS OF THE BOOK WITH THE ID PASSED AND RETURNS IT WITH THE VIEW

        $book = books_table::find($id);

        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        
        $isBookmarked = $bookIds->contains($id);

        //eto naman para ma-retrieve yung reviews and ratings ng book
        $reviews = rrs_table::where('book_id', $id)->get();
        $userIds = $reviews->pluck('user_id');
        $usernames = users_table::whereIn('id', $userIds)->pluck('username', 'id');

        foreach ($reviews as $review) {
            $review->username = $usernames[$review->user_id];
        }

        $reviewed = rrs_table::where('user_id', Auth::user()->id)->get();
        $reviewIds = $reviewed->pluck('book_id');
        $isReviewed = $reviewIds->contains($id);
        return view('view_book', ['book' => $book, 'isBookmarked' => $isBookmarked, 'reviews' => $reviews, 'isReviewed' => $isReviewed]);
    }

    function services() {
        return view('services');
    }

    function about_us() {
        return view('about');
    }

    function profile_page() {

        //NAVIGATES TO THE PROFILE PAGE OF THE USER WITH ITS OWN DETAILS
        $user_details = Auth::user();
        return view('profile', ['user_details' => $user_details]);
    }

    function forgot_password() {
        return view('forgot');
    }

    function update_profile(Request $request, $id){

        //VALIDATES THE REQUEST
        $request->validate([
            'username' => 'required',
            'birthday' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        //SELECT * FROM USERS_TABLE WHERE ID = $id
        $userProfile = users_table::find($id);
    
        //UPDATE USERS_TABLE SET username = $request->username, birthdate = $request->birthdate, address = $request->address, contactNo = $request->contactNo WHERE ID = $id
        $userProfile->update([
            'username' => $request->username,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'contactNo' => $request->contactNo,
        ]);

        //REDIRECTS TO THE PROFILE PAGE WITH SUCCESS MESSAGE
    
        return redirect()->route('homepage')->with('success', 'Profile updated successfully');
    }

    function delete_profile($id){

        //SELECT * FROM USERS_TABLE WHERE ID = $id
        $userProfile = users_table::find($id);

        //DELETE FROM USERS_TABLE WHERE ID = $id
        $userProfile->delete();

        //LOGOUT THE USER AND REDIRECT TO THE LOGIN PAGE WITH SUCCESS MESSAGE
        return redirect()->route('login')->with('success', 'Profile deleted successfully');
    }

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

        //SELECT * FROM BOOKS_TABLE WHERE ID = $id
        // SELECT THE BOOK FROM THE DB WITH ITS ID AND RETURN IT WITH THE VIEW

        //PARANG SAME FUNCTION LANG DIN KAY VIEW BOOK PERO ITO YUNG FUNCTION PARA SA BOOKMARKS
        return view('view_book', ['book' => $book, 'isBookmarked' => $isBookmarked,  'reviews' => $reviews, 'isReviewed' => $isReviewed]);
    }

    function bookmark() { 

        //returns the bookmarks of the user
        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        $books = books_table::whereIn('id', $bookIds)->get();

        return view('bookmarks', ['books' => $books]);
    }

    function remove_bookmark($id) {

        //SELECT * FROM BOOKMARKS_TABLE WHERE USER_ID = $id
        // DELETE FROM BOOKMARKS_TABLE WHERE USER_ID = $id AND BOOK_ID = $id
        bookmarks::where('user_id', Auth::user()->id)->where('book_id', $id)->delete();

        //REDIRECT TO THE BOOKMARKS PAGE WITH SUCCESS MESSAGE
        return redirect()->route('bookmark')->with('success', 'Bookmark removed successfully');
    }

    //THE FOLLOWING FUNCTIONS ARE FOR THE FUNCTIONALITY OF RATINGS AND REVIEWS FOR THE BOOK

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

        //SQL CODE: UPDATE RRS_TABLE SET REVIEW = $request->review, RATING = $request->rating WHERE ID = $id

        $review = rrs_table::find($request->id);
        $review->update([
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('view_books', ['id' => $review->book_id])->with('success', 'Review updated successfully');

    }

    function delete_review($id){

        //SQL CODE: DELETE FROM RRS_TABLE WHERE ID = $id

        $review = rrs_table::find($id);
        $review->delete();

        return redirect()->route('view_books', ['id' => $review->book_id])->with('success', 'Review deleted successfully');

    }

    function request_reserve($id) {

    //ETO YUNG MAG NO NOTIFY KAY ADMIN IF MAY NAG REQUEST NG RESERVATION
    //SQL CODE: INSERT INTO BORROWS_TABLE VALUES ('user_id', 'book_id', 'status', 'borrow_date', 'return_date')
    borrows_table::create([
        'user_id' => Auth::user()->id,
        'book_id' => $id,
        'status' => 'pending',
        'borrow_date' => date('Y-m-d'),
        'return_date' => date('Y-m-d', strtotime('+7 days')),
    ]);

    return redirect()->route('homepage')->with('success', 'Reservation requested successfully');

    }

    function cancel_reservation($id) {  

        //USER CANCELS THE RESERVATION

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'cancelled' WHERE ID = $id

        $borrow_status = borrows_table::findorFail($id);
        $borrow_status-> status = 'cancelled';
        $borrow_status->save();

        //SQL CODE: UPDATE BOOKS_TABLE SET STATUS = 'available' WHERE ID = $borrow_status->book_id

        $book = books_table::find($borrow_status->book_id);
        $book->status = 'available';
        $book->save();

        return redirect()->route('homepage')->with('success', 'Reservation cancelled successfully');

    }

    function pickup($id) {

        //ETO NAMAN PAG NAKUHA NA NI CLIENT YUNG BOOK

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'borrowed' WHERE ID = $id

        $borrow_status = borrows_table::findorFail($id);
        $borrow_status-> status = 'borrowed';
        $borrow_status->save();

        return redirect()->route('homepage')->with('success', 'Book picked up successfully');

    }

    function return_book($id) {

    //ETO YUNG MAG NONOTIFY SI ADMIN IF NIRETURN NA NI CLIENT YUNG BOOK TAS SI ADMIN NA BAHALA MAG APPROVE

    //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'request return' WHERE ID = $id
    $borrow_status = borrows_table::findorFail($id);
    $borrow_status-> status = 'request return';
    $borrow_status->save();

    return redirect()->route('homepage')->with('success', 'Book returned successfully');

    }

    function my_borrows() {

        //SELECTS ALL THE BORROWED BOOKS OF THE USER AND RETURNS IT WITH THE VIEW

        //SQL CODE:
        // SELECT borrows_table.*, books_tables.title, users_tables.username 
        // FROM borrows_table
        // INNER JOIN books_tables ON borrows_table.book_id = books_tables.id
        // INNER JOIN users_tables ON borrows_table.user_id = users_tables.id;

        $borrowedBooks = DB::table('borrows_table')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks]);

    }

    
}
