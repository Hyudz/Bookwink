<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class book_controller extends Controller
{
    function add_book_post(Request $request) {
        $request->validate([
            'book_name' => 'required',
            'book_author' => 'required',
            'book_category' => 'required',
            'book_description' => 'required|max:65535',
            'book_cover' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        //SQL CODE: INSERT INTO books_table (title, author, category, description, cover, status, rating) VALUES ($request->book_name, $request->book_author, $request->book_category, $request->book_description, $filename, 'available', 0)

        $file = $request->file('book_cover');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        books_table::create([
            'title' => $request->book_name,
            'author' => $request->book_author,
            'category' => $request->book_category,
            'description' => $request->book_description,
            'cover' => $filename, 
            'status' => 'available',
            'rating' => 0,
        ]);
    
        return redirect()->route('admin.manage_books')->with('success', 'Book added successfully');
    }
    

    function edit_book($id) {

        //SQL CODE: SELECT * FROM books_table WHERE id = $id
        $book = books_table::find($id);
        return view('admin.edit_book', ['book' => $book]);
    }

    function edit_book_post(Request $request) {

        //SQL CODE: UPDATE books_table SET title = $request->book_name, author = $request->book_author, category = $request->book_category, description = $request->book_description WHERE id = $request->id

        $request->validate([
            'book_name' => 'required',
            'book_author' => 'required',
            'book_category' => 'required',
            'book_description' => 'required|max:65535',
            'book_cover' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);
    
        $book = books_table::find($request->id);
        $book->title = $request->book_name;
        $book->author = $request->book_author;
        $book->category = $request->book_category;
        $book->description = $request->book_description;
    
        if ($request->hasFile('book_cover')) {
            $filename = time() . '.' . $request->file('book_cover')->getClientOriginalExtension();
            $request->file('book_cover')->move(public_path('uploads'), $filename);
            $book->cover = $filename;
        }
    
        $book->save();
    
        return redirect()->route('admin.manage_books')->with('success', 'Book updated successfully');
    }
    

    function manage_books() {

        //SQL CODE: SELECT * FROM books_table

        $books = DB::table('books_tables')->get();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('admin.manage_books', ['books' => $books, 'notifications' => $notifications]);
    }

    function delete_book($id) {

        //SQL CODE: DELETE FROM books_table WHERE id = $id
        $book = books_table::find($id);
        $book->delete();

        return redirect()->route('admin.manage_books')->with('success', 'Book deleted successfully');
    }

    function reserved_books() {

        //DISPLAY ALL THE RESERVED/BORROWED BOOKS

        //SQL CODE:
        // SELECT * FROM borrows_table, books_table.title, users_table.username
        // FROM borrows_table
        //INNER JOIN books_table ON borrows_table.book_id = books_table.id
        //INNER JOIN users_table ON borrows_table.user_id = users_table.id

        $borrowed_book = DB::table('borrows_table')->where('borrows_table.status', '!=' ,'returned')
            ->where('borrows_table.status', '!=' ,'disapproved')
            ->where('borrows_table.status', '!=' ,'rejected')
            ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
            ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
            ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
            ->get();

            $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('admin.reserved_books', ['borrowed_book' => $borrowed_book, 'notifications' => $notifications]);
    }
}
