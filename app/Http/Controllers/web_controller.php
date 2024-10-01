<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users_table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        return view('homepage');
    }

    function login_post(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        log::info($request->email);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
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

        $data['username'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['birthday'] = $request->birthday;
        $data['gender'] = $request ->gender;
        $data['address'] = $request->address;
        $data['phone_number'] = $request->phone_number;

        $user = users_table::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'age' => 18,
            'birthday' => $data['birthday'],
            'gender' => $data['gender'],
            'address' => $data['address'],
            'user_type' => 'user',
            'phone_number' => $data['phone_number']
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
    

    function view_books() {
        return view('view_book');
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
