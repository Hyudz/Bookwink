<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\books_table;
use App\Models\borrows_table;
use App\Models\users_table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class admin_controller extends Controller
{
    //THIS CONTROLLER IS FOR THE ADMIN SIDE OF THE APPLICATION
    function dashboard() {

        $books = DB::table('books_tables')->get()->count();
        $reserved_books = DB::table('borrows_table')->where('status', '!=', 'returned')->get()->count();
        $users = DB::table('users_tables')->get();
        return view('admin.dashboard', ['books' => $books, 'reserved_books' => $reserved_books, 'users' => $users]);
    }

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

        return view('admin.manage_books', ['books' => $books]);
    }

    function delete_book($id) {

        //SQL CODE: DELETE FROM books_table WHERE id = $id
        $book = books_table::find($id);
        $book->delete();

        return redirect()->route('admin.manage_books')->with('success', 'Book deleted successfully');
    }

    function approve_request($id) {

        //APPROVE THE REQUEST OF THE USER TO BORROW THE BOOK

        //SQL CODE: UPDATE borrows_table SET status = 'approved' WHERE id = $id
        $borrow = borrows_table::find($id);
        $borrow->status = 'approved';
        $borrow->save();

        //SQL CODE: UPDATE books_table SET status = 'reserved' WHERE id = $borrow->book_id
        $book = books_table::find($borrow->book_id);
        $book->status = 'reserved';
        $book->save();

        //SQL CODE:
        // SELECT * FROM borrows_table, books_table.title, users_table.username 
        // FROM borrows_table
        //INNER JOIN books_table ON borrows_table.book_id = books_table.id
        //INNER JOIN users_table ON borrows_table.user_id = users_table.id

        $borrowed_book = DB::table('borrows_table')
            ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
            ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
            ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
            ->get();

        return redirect()->route('admin.reserved_books', ['borrowed_book' => $borrowed_book])->with('success', 'Request approved successfully');

    }

    function disapprove_request($id){

        //SAME LANG DIN SA APPROVE PERO OPPOSITE

        //SQL CODE: UPDATE borrows_table SET status = 'disapproved' WHERE id = $id
        $borrow = borrows_table::find($id);
        $borrow->status = 'disapproved';
        $borrow->save();

        //SQL CODE: UPDATE books_table SET status = 'available' WHERE id = $borrow->book_id
        $book = books_table::find($borrow->book_id);
        $book->status = 'available';
        $book->save();

        //SQL CODE:
        // SELECT * FROM borrows_table, books_table.title, users_table.username 
        // FROM borrows_table
        //INNER JOIN books_table ON borrows_table.book_id = books_table.id
        //INNER JOIN users_table ON borrows_table.user_id = users_table.id

        $borrowed_book = DB::table('borrows_table')->where('borrows_table.status', '!=' ,'returned')
            ->where('borrows_table.status', '!=' ,'disapproved')
            ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
            ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
            ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
            ->get();

        return redirect()->route('admin.reserved_books', ['borrowed_book' => $borrowed_book])->with('success', 'Request disapproved successfully');
    }

    function approve_return($id) {

        //IF THE USER RETURNED THE BOOK, THE ADMIN WILL APPROVE THE RETURN

        //SQL CODE: UPDATE borrows_table SET status = 'returned' WHERE id = $id
        $borrow = borrows_table::find($id);
        $borrow->status = 'returned';
        $borrow->save();

        //SQL CODE: UPDATE books_table SET status = 'available' WHERE id = $borrow->book_id
        $book = books_table::find($borrow->book_id);
        $book->status = 'available';
        $book->save();

        return redirect()->route('admin.reserved_books')->with('success', 'Book returned successfully');

    }

    function reject_return($id) {

        //QUITE THE OPPOSITE

        //SQL CODE: UPDATE borrows_table SET status = 'rejected' WHERE id = $id
        $borrow = borrows_table::find($id);
        $borrow->status = 'rejected';
        $borrow->save();

        //SQL CODE: UPDATE books_table SET status = 'reserved' WHERE id = $borrow->book_id
        $book = books_table::find($borrow->book_id);
        $book->status = 'reserved';
        $book->save();

        return redirect()->route('admin.reserved_books')->with('success', 'Return rejected successfully');
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
            ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
            ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
            ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
            ->get();

        return view('admin.reserved_books', ['borrowed_book' => $borrowed_book]);
    }

    function export_data1(){
        $fileName = 'bookwink.sql';
    
        // Construct the `mysqldump` command
        $command = "mysqldump --u=root --p=bookwink > {$fileName}";
    
        // Execute the command
        system($command);

        // Provide the download to the user
        return response()->download($fileName)->deleteFileAfterSend(true);
    }

    public function export_data()
{
    // Export books to CSV
    $books = books_table::all();
    $fileNameBooks = 'books_backup.csv';
    $fileBooks = fopen($fileNameBooks, 'w');
    fputcsv($fileBooks, ['ID', 'Title', 'Author', 'Category', 'Description', 'Status', 'Cover', 'Rating', 'Created At', 'Updated At']);

    foreach ($books as $book) {
        $data = [
            $book->id,
            $book->title,
            $book->author,
            $book->category,
            $book->description,
            $book->status,
            $book->cover,
            $book->rating,
            $book->created_at,
            $book->updated_at
        ];
        
        fputcsv($fileBooks, $data);
    }
    fclose($fileBooks);

    // Export users to CSV
    $users = users_table::all();
    $fileNameUsers = 'users_backup.csv';
    $fileUsers = fopen($fileNameUsers, 'w');
    fputcsv($fileUsers, ['ID', 'Username', 'Email', 'Password', 'Age', 'Birthday', 'Gender', 'Address', 'User Type', 'Phone Number', 'Created At', 'Updated At']);

    foreach ($users as $user) {
        $data = [
            $user->id,
            $user->username,
            $user->email,
            $user->password,
            $user->age,
            $user->birthday,
            $user->gender,
            $user->address,
            $user->user_type,
            $user->phone_number,
            $user->created_at,
            $user->updated_at
        ];

        fputcsv($fileUsers, $data);
    }
    fclose($fileUsers);

    // Export borrows to CSV
    $borrows = borrows_table::all();
    $fileNameBorrows = 'borrows_backup.csv';
    $fileBorrows = fopen($fileNameBorrows, 'w');
    fputcsv($fileBorrows, ['ID', 'User ID', 'Book ID', 'Status', 'Created At', 'Updated At']);

    foreach ($borrows as $borrow) {
        $data = [
            $borrow->id,
            $borrow->user_id,
            $borrow->book_id,
            $borrow->status,
            $borrow->created_at,
            $borrow->updated_at
        ];

        fputcsv($fileBorrows, $data);
    }
    fclose($fileBorrows);

    // Create a ZIP file containing all CSV files
    $zipFileName = 'backup_files.zip';
    $zip = new \ZipArchive();

    if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
        $zip->addFile($fileNameBooks);
        $zip->addFile($fileNameUsers);
        $zip->addFile($fileNameBorrows);
        $zip->close();
    } else {
        return response()->json(['error' => 'Could not create ZIP file.'], 500);
    }

    // Return the ZIP file as a download
    return response()->download($zipFileName)->deleteFileAfterSend(true);
}

    
}
