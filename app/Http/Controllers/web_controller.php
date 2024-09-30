<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    function login_post(){
        return view('homepage');
    }

    function signup_post() {

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

        return view('profile');
    }

    function forgot_password() {
        return view('forgot');
    }
    
}
