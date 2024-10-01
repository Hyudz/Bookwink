<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web_controller;
use App\Http\Controllers\admin\admin_controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [web_controller::class,'login']) -> name('login');
Route::get('/signup', [web_controller::class,'signup']) -> name('signup');
Route::post('/home', [web_controller::class,'login_post']) -> name('login_post');
Route::get('/homepage', [web_controller::class,'homepage']) -> name('homepage');
Route::get('/view_books', [web_controller::class,'view_books']) -> name('view_books');
Route::get('/services', [web_controller::class,'services']) -> name('services');
Route::get('/about_us', [web_controller::class,'about_us']) -> name('about_us');
Route::get('/profile', [web_controller::class,'profile_page']) -> name('profile');
Route::get('/forgot_password', [web_controller::class,'forgot_password']) -> name('reset_password');
Route::post('/signup', [web_controller::class,'signup_post']) -> name('signup_post');


// admin

Route::get('/admin/dashboard', [admin_controller::class,'dashboard']) -> name('admin.dashboard');
Route::get('/admin/add_book', [admin_controller::class,'add_book']) -> name('admin.add_books');
Route::get('/admin/manage_books', [admin_controller::class,'manage_books']) -> name('admin.manage_books');
