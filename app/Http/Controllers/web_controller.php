<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users_table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\books_table;

class web_controller extends Controller
{
    function landing() {
        return view('welcome');
    }

    function login() {
        return view('login');
    }

    function signup() {
        return view('signup');
    }

    function homepage() {

        $books = books_table::all();
        return view('homepage',['books' => $books]);
    }

    function login_post(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        log::info($request->email);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->user_type == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful');
            }
            return redirect()->route('homepage')->with('success', 'Login successful');
        }
        return redirect()->route('login')->with(['error' => 'Invalid email or password']);
    }
    

    function signup_post(Request $request) {

        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
            'birthday' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'phone_number' => 'required'
        ]);
        
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
        

        if ($user) {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];
    
            if (Auth::attempt($credentials)) {   
                return redirect()->route('homepage')->with('success', 'User created successfully');
            }
        } else {
            echo "failed";
            return redirect()->route('signup')->with('error', 'User not created');
        }

    }
    

    function view_books($id) {

        $book = books_table::find($id);
        return view('view_book', ['book' => $book]);
    }

    function services() {
        return view('services');
    }

    function about_us() {
        return view('about');
    }

    function profile_page() {
        $user_details = Auth::user();
        return view('profile', ['user_details' => $user_details]);
    }

    function forgot_password() {
        return view('forgot');
    }
    function update_profile(Request $request, $id){
        $request->validate([
            'username' => 'required',
            'birthday' => 'required|date',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        $userProfile = users_table::find($id);
    
        $userProfile->update([
            'username' => $request->username,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'contactNo' => $request->contactNo,
        ]);
    
        return redirect()->route('homepage')->with('success', 'Profile updated successfully');
    }

    function delete_profile($id){
        $userProfile = users_table::find($id);
        $userProfile->delete();
        return redirect()->route('login')->with('success', 'Profile deleted successfully');
    }
    
}
