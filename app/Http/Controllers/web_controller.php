<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users_table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\bookmarks;
use App\Models\books_table;

class web_controller extends Controller
{

    //THIS CONTROLLER IS FOR THE CLIENT SIDE OF THE APPLICATION
    function landing() {
        //REDIRECTS TO THE LANDING PAGE
        return view('welcome');
    }

    function login() {
        //REDIRECTS TO THE LOGIN PAGE
        return view('login');
    }

    function signup() {

        //REDIRECTS TO THE SIGNUP PAGE
        return view('signup');
    }

    function homepage() {

        //SELECTS ALL THE BOOKS FROM THE DATABASE AND RETURNS IT WITH THE VIEW

        $books = books_table::all();
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

        return view('view_book', ['book' => $book, 'isBookmarked' => $isBookmarked]);
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

        //SELECT * FROM BOOKMARKS_TABLE WHERE USER_ID = $id
        // QUERY THE BOOKMARKS OF THE USER
        $book = books_table::find($id);

        bookmarks::create([
            'user_id' => Auth::user()->id,
            'book_id' => $id
        ]);

        //SELECT * FROM BOOKS_TABLE WHERE ID = $id
        // SELECT THE BOOK FROM THE DB WITH ITS ID AND RETURN IT WITH THE VIEW
        $book = books_table::find($id);
        return view('view_book', ['book' => $book]);
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
    
}
