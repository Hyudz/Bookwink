<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class admin_controller extends Controller
{
    function dashboard() {
        return view('admin.dashboard');
    }

    function add_book() {
        return view('admin.add_book');
    }

    function manage_books() {
        return view('admin.manage_books');
    }
}
