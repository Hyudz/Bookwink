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
use App\Models\notifs_table;
use App\Models\rrs_table;

class web_controller extends Controller
{

    //THIS CONTROLLER IS FOR THE CLIENT SIDE OF THE APPLICATION
    function index() {
        //REDIRECTS TO THE LANDING PAGE
        $books = books_table::all()->where('status', 'available');
        return view('index', ['books' => $books]);
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
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();
        return view('homepage',['books' => $books, 'notifications' => $notifications]);
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

            $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();
            return redirect()->route('homepage', ['notifications' => $notifications])->with('success', 'Login successful');
        }
        return redirect()->route('login')->with(['error' => 'Invalid email or password']);
    }
    

    function signup_post(Request $request) {

        $birthday = new \DateTime($request->birthday);
        $today = new \DateTime();
        $age = $today->diff($birthday)->y;

        $minimumAge = 13;
    
        // VALIDATE THE REQUEST
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'birthday' => 'required|date',
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        if ($age < $minimumAge) {
            return redirect()->route('signup')->withErrors(['birthday' => 'You must be at least ' . $minimumAge . ' years old to sign up.']);
        }
    
        // CREATE A NEW USER
        $user = users_table::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $age,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'address' => $request->address,
            'user_type' => 'user',
            'phone_number' => $request->phone_number
        ]);
    
        // AUTO LOGIN AFTER CREATING A NEW USER
        if ($user) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::attempt($credentials)) {   
                return redirect()->route('homepage')->with('success', 'User created successfully');
            }
        } else {
            // ELSE REDIRECT TO SIGNUP PAGE WITH ERROR
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

        //SELECT * FROM BORROWS_TABLE WHERE USER_ID = Auth::user()->id AND BOOK_ID = $id
        $isBorrowed = borrows_table::where('user_id', Auth::user()->id)->where('book_id', $id)->where('status', 'pending')->exists();

        $isBorrowedByOthers = borrows_table::where('book_id', $id)
        ->where('status', 'approved')
        ->where('user_id', '!=', Auth::user()->id)
        ->exists();
        //dd($isBorrowed);

        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();
        
        return view('view_book', ['book' => $book, 'isBookmarked' => $isBookmarked, 'reviews' => $reviews, 'isReviewed' => $isReviewed, 'isBorrowed' => $isBorrowed, 'notifications' => $notifications, 'isBorrowedByOthers' => $isBorrowedByOthers]);
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
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        $bookmarked = bookmarks::where('user_id', Auth::user()->id)->get();
        $bookIds = $bookmarked->pluck('book_id');
        $books = books_table::whereIn('id', $bookIds)->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('bookmarks', ['books' => $books, 'user_details' => $user_details, 'notifications' => $notifications]);
    
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
}
