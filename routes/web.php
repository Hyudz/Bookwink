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

Route::get('/', [web_controller::class,'index']) -> name('index');
Route::get('/login', [web_controller::class,'login']) -> name('login');
Route::get('/signup', [web_controller::class,'signup']) -> name('signup');
Route::post('/home', [web_controller::class,'login_post']) -> name('login_post');
Route::get('/homepage', [web_controller::class,'homepage']) -> name('homepage');
Route::get('/logout', [web_controller::class,'logout']) -> name('logout');
Route::get('/view_books/{id}', [web_controller::class,'view_books']) -> name('view_books');
Route::get('/services', [web_controller::class,'services']) -> name('services');
Route::get('/about_us', [web_controller::class,'about_us']) -> name('about_us');
Route::get('/profile', [web_controller::class,'profile_page']) -> name('profile');
Route::get('/forgot_password', [web_controller::class,'forgot_password']) -> name('reset_password');
Route::post('/signup', [web_controller::class,'signup_post']) -> name('signup_post');
Route::put('/update_profile/{id}', [web_controller::class,'update_profile']) -> name('update_profile');
Route::delete('/delete_profile/{id}', [web_controller::class,'delete_profile']) -> name('delete_profile');
Route::get('/bookmarks', [web_controller::class,'bookmark']) -> name('bookmark');
Route::post('/add_bookmark/{id}', [web_controller::class,'bookmarks']) -> name('add_bookmark');
Route::delete('/remove_bookmark/{id}', [web_controller::class,'remove_bookmark']) -> name('remove_bookmark');
Route::post('/add_review',[web_controller::class,'add_review'])->name('add_rrs');
Route::put('/update_review/{id}',[web_controller::class,'update_review'])->name('update_rrs');
Route::delete('/delete_review/{id}',[web_controller::class,'delete_review'])->name('delete_rrs');
Route::post('/reserve_book/{id}',[web_controller::class,'request_reserve'])->name('reserve_book');
Route::delete('/cancel_reservation/{id}',[web_controller::class,'cancel_reservation'])->name('cancel_reservation');
Route::put('/return_book/{id}',[web_controller::class,'return_book'])->name('return_book');
Route::get('/my_borrows', [web_controller::class,'my_borrows']) -> name('my_borrows');
Route::post('/search', [web_controller::class,'search']) -> name('search');
Route::get('/search_results', [web_controller::class,'search_results']) -> name('search_results');
Route::post('/pickup/{id}', [web_controller::class,'pickup']) -> name('pickup');
Route::post('/cancel/{id}', [web_controller::class,'cancel_reservation']) -> name('cancel');
Route::post('/return/{id}', [web_controller::class,'return_book']) -> name('return');


// admin

Route::get('/admin/dashboard', [admin_controller::class,'dashboard']) -> name('admin.dashboard');
Route::get('/admin/add_book', [admin_controller::class,'add_book']) -> name('admin.add_books');
Route::post('/admin/add_book', [admin_controller::class,'add_book_post']) -> name('admin.add_books_post');
Route::get('/admin/manage_books', [admin_controller::class,'manage_books']) -> name('admin.manage_books');
Route::get('/admin/edit_book/{id}', [admin_controller::class,'edit_book']) -> name('admin.edit_book');
Route::post('/admin/edit_book/{id}', [admin_controller::class,'edit_book_post']) -> name('admin.edit_book_post');
Route::delete('/admin/delete_book/{id}', [admin_controller::class,'delete_book']) -> name('admin.delete_book');
Route::post('/admin/approve_reservation/{id}', [admin_controller::class,'approve_request']) -> name('admin.approve_reservation');
Route::post('/admin/approve_return/{id}', [admin_controller::class,'approve_return']) -> name('admin.approve_return');
Route::post('/admin/reject_return/{id}', [admin_controller::class,'reject_return']) -> name('admin.reject_return');
Route::post('/admin/reject_reservation/{id}', [admin_controller::class,'disapprove_request']) -> name('admin.reject_reservation');
Route::get('/admin/reserved_books', [admin_controller::class,'reserved_books']) -> name('admin.reserved_books');
