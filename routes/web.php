<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web_controller;
use App\Http\Controllers\admin\admin_controller;;
use App\Http\Controllers\bookmark_controller;
use App\Http\Controllers\review_controller;
use App\Http\Controllers\reserve_controller;
use App\Http\Controllers\admin\requests_controller;
use App\Http\Controllers\admin\book_controller;
use App\Http\Controllers\forget_password_controller;

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
Route::post('/signup', [web_controller::class,'signup_post']) -> name('signup_post');

Route::get('/forgot_password', [forget_password_controller::class,'forgot_password']) -> name('forgot_password');
Route::post('/forgot_password', [forget_password_controller::class,'forgot_password_post']) -> name('forgot_password_post');
Route::get('/reset_password/{token}/{email}', [forget_password_controller::class,'reset_password']) -> name('reset_password');
Route::post('/reset_password', [forget_password_controller::class,'reset_password_post']) -> name('reset_password_post');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [web_controller::class,'home']) -> name('home');
Route::get('/homepage', [web_controller::class,'homepage']) -> name('homepage');
Route::get('/logout', [web_controller::class,'logout']) -> name('logout');
Route::get('/view_books/{id}', [web_controller::class,'view_books']) -> name('view_books');
Route::get('/services', [web_controller::class,'services']) -> name('services');
Route::get('/about_us', [web_controller::class,'about_us']) -> name('about_us');
Route::get('/profile', [web_controller::class,'profile_page']) -> name('profile');
Route::put('/update_profile/{id}', [web_controller::class,'update_profile']) -> name('update_profile');
Route::delete('/delete_profile/{id}', [web_controller::class,'delete_profile']) -> name('delete_profile');

Route::get('/bookmarks', [bookmark_controller::class,'bookmark']) -> name('bookmark');
Route::post('/add_bookmark/{id}', [bookmark_controller::class,'bookmarks']) -> name('add_bookmark');
Route::delete('/remove_bookmark/{id}', [bookmark_controller::class,'remove_bookmark']) -> name('remove_bookmark');

Route::post('/add_review',[review_controller::class,'add_review'])->name('add_rrs');
Route::put('/update_review/{id}',[review_controller::class,'update_review'])->name('update_rrs');
Route::delete('/delete_review/{id}',[review_controller::class,'delete_review'])->name('delete_rrs');

Route::post('/reserve_book/{id}',[reserve_controller::class,'request_reserve'])->name('reserve_book');
Route::put('/return_book/{id}',[reserve_controller::class,'return_book'])->name('return_book');
Route::get('/my_borrows/returned', [reserve_controller::class,'my_borrows']) -> name('my_borrows');
Route::get('/my_borrows/pending', [reserve_controller::class,'pending_books']) -> name('my_borrows.pending');
Route::get('/my_borrows/approved', [reserve_controller::class,'approved_books']) -> name('my_borrows.approved');
Route::get('/my_borrows/rejected', [reserve_controller::class,'rejected_books']) -> name('my_borrows.rejected');
Route::get('/my_borrows/cancelled', [reserve_controller::class,'cancelled_books']) -> name('my_borrows.cancelled');
Route::get('/my_borrows/returning', [reserve_controller::class,'returning_books']) -> name('my_borrows.returning');
Route::get('/my_borrows/extend', [reserve_controller::class,'extend_book']) -> name('my_borrows.extend');
Route::post('/pickup/{id}', [reserve_controller::class,'pickup']) -> name('pickup');
Route::post('/cancel/{id}', [reserve_controller::class,'cancel_reservation']) -> name('cancel');
Route::post('/return/{id}', [reserve_controller::class,'return_book']) -> name('return');
Route::post('/extend/{id}', [reserve_controller::class,'request_extend']) -> name('extend');

Route::post('/change_password', [admin_controller::class,'change_password_post']) -> name('change_password');

});

Route::post('/search', [web_controller::class,'search']) -> name('search');
Route::get('/search_results', [web_controller::class,'search_results']) -> name('search_results');


// admin

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin/dashboard', [admin_controller::class,'dashboard']) -> name('admin.dashboard');
Route::get('/admin/dashboard', [admin_controller::class,'dashboard']) -> name('admin.dashboard');
Route::get('/admin/notification/{id}', [admin_controller::class,'read_notification']) -> name('admin.read_notification');

Route::get('/admin/add_book', [book_controller::class,'add_book']) -> name('admin.add_books');
Route::post('/admin/add_book', [book_controller::class,'add_book_post']) -> name('admin.add_books_post');
Route::get('/admin/manage_books', [book_controller::class,'manage_books']) -> name('admin.manage_books');
Route::get('/admin/edit_book/{id}', [book_controller::class,'edit_book']) -> name('admin.edit_book');
Route::post('/admin/edit_book/{id}', [book_controller::class,'edit_book_post']) -> name('admin.edit_book_post');
Route::delete('/admin/delete_book/{id}', [book_controller::class,'delete_book']) -> name('admin.delete_book');
Route::get('/admin/manage_books/pending', [book_controller::class,'reserved_books']) -> name('admin.reserved_books');
Route::get('/admin/manage_books/approved', [book_controller::class,'approved_books']) -> name('admin.approved_books');
Route::get('/admin/manage_books/rejected', [book_controller::class,'rejected_books']) -> name('admin.rejected_books');
Route::get('/admin/manage_books/returning', [book_controller::class,'returning_books']) -> name('admin.returning_books');
Route::get('/admin/manage_books/returned', [book_controller::class,'returned_books']) -> name('admin.returned_books');
Route::get('/admin/manage_books/cancelled', [book_controller::class,'cancelled_borrow']) -> name('admin.cancelled_borrow');
Route::get('/admin/manage_books/extend', [book_controller::class,'extend_book']) -> name('admin.extension_request');

Route::post('/admin/approve_reservation/{id}', [requests_controller::class,'approve_request']) -> name('admin.approve_reservation');
Route::post('/admin/approve_return/{id}', [requests_controller::class,'approve_return']) -> name('admin.approve_return');
Route::post('/admin/reject_return/{id}', [requests_controller::class,'reject_return']) -> name('admin.reject_return');
Route::post('/admin/reject_reservation/{id}', [requests_controller::class,'disapprove_request']) -> name('admin.reject_reservation');
Route::post('/admin/approve_extend/{id}', [requests_controller::class,'approve_extend']) -> name('admin.approve_extend');
Route::post('/admin/reject_extend/{id}', [requests_controller::class,'reject_extend']) -> name('admin.reject_extend');

Route::get('/admin/export_data', [admin_controller::class,'export_data']) -> name('admin.export_data');
});
