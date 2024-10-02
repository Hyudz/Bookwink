<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\books_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class admin_controller extends Controller
{
    function dashboard() {
        return view('admin.dashboard');
    }

    function add_book() {
        return view('admin.add_book');
    }

    function add_book_post(Request $request) {
        $request->validate([
            'book_name' => 'required',
            'book_author' => 'required',
            'book_category' => 'required',
            'book_description' => 'required',
            'book_cover' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

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
    
        return redirect()->route('admin.add_books')->with('success', 'Book added successfully');
    }
    

    function edit_book($id) {
        $book = books_table::find($id);

        return view('admin.edit_book', ['book' => $book]);
    }

    function edit_book_post(Request $request) {

        $request->validate([
            'book_name' => 'required',
            'book_author' => 'required',
            'book_category' => 'required',
            'book_description' => 'required',
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

        $books = DB::table('books_tables')->get();

        return view('admin.manage_books', ['books' => $books]);
    }

    function delete_book($id) {
        $book = books_table::find($id);
        $book->delete();

        return redirect()->route('admin.manage_books')->with('success', 'Book deleted successfully');
    }
}
