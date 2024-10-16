<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\books_table;
use App\Models\borrows_table;
use App\Models\users_table;
use Illuminate\Http\Request;
use App\Models\notifs_table;
use App\Models\rrs_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class admin_controller extends Controller
{
    //THIS CONTROLLER IS FOR THE ADMIN SIDE OF THE APPLICATION
    function dashboard() {

        $books = DB::table('books_tables')->get()->count();
        $reserved_books = DB::table('borrows_table')->where('status', '!=', 'returned')->get()->count();
        $users = DB::table('users_tables')->get();

        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();
        return view('admin.dashboard', ['books' => $books, 'reserved_books' => $reserved_books, 'users' => $users, 'notifications' => $notifications]);
    }

    function read_notification($id)
    {
        // Step 1: Mark the notification as read
        $notification = notifs_table::find($id);
        $notification->is_read = true;
        $notification->save();

        // Step 2: Join tables to fetch detailed notification information
        $notifications = DB::table('notifs_tables')
            ->join('borrows_table', 'notifs_tables.borrow_id', '=', 'borrows_table.id')
            ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
            ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
            ->select(
                'notifs_tables.id as id',
                'notifs_tables.is_read',
                'notifs_tables.message',
                'notifs_tables.notification_type',
                'borrows_table.id as borrow_id',
                'borrows_table.borrow_date',
                'borrows_table.return_date',
                'users_tables.username as borrower_name',
                'users_tables.email as borrower_email',
                'books_tables.title as book_title',
                'books_tables.id as book_id',
                'books_tables.cover as book_cover'
            )
            ->where('notifs_tables.user_id', Auth::user()->id)
            ->where('notifs_tables.id', $id)
            ->get();

            //dd($notifications);

        // Step 3: Pass the data to the view
        return view('admin.notifs_content', ['notifications' => $notifications]);
    }


    // function export_data1(){
    //     $fileName = 'bookwink.sql';
    
    //     // Construct the `mysqldump` command
    //     $command = "mysqldump --u=root --p=bookwink > {$fileName}";
    
    //     // Execute the command
    //     system($command);

    //     // Provide the download to the user
    //     return response()->download($fileName)->deleteFileAfterSend(true);
    // }

    function export_data() {
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
        fputcsv($fileBorrows, ['ID', 'User ID', 'Book ID', 'Status', 'Created At', 'Updated At', 'Favorite Color']);

        foreach ($borrows as $borrow) {
            $data = [
                $borrow->id,
                $borrow->user_id,
                $borrow->book_id,
                $borrow->status,
                $borrow->created_at,
                $borrow->updated_at,
                $borrow->favorite_color
            ];

            fputcsv($fileBorrows, $data);
        }
        fclose($fileBorrows);

        // EXPORT THE RRS (RATINGS AND REVIEWS) TABLE TO CSV

        $rrs = rrs_table::all();
        $fileNameRrs = 'rrs_backup.csv';
        $fileRrs = fopen($fileNameRrs, 'w');
        fputcsv($fileRrs, ['ID', 'User ID', 'Book ID', 'Rating', 'Review', 'Created At', 'Updated At', 'Review Copy']);

        foreach ($rrs as $rr) {
            $data = [
                $rr->id,
                $rr->user_id,
                $rr->book_id,
                $rr->rating,
                $rr->review,
                $rr->created_at,
                $rr->updated_at,
                $rr->review_copy
            ];

            fputcsv($fileRrs, $data);
        }
        fclose($fileRrs);

        // Create a ZIP file containing all CSV files
        $zipFileName = 'backup_files.zip';
        $zip = new \ZipArchive();

        if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $zip->addFile($fileNameBooks);
            // $zip->addFile($fileNameUsers);
            $zip->addFile($fileNameBorrows);
            // $zip->addFile($fileNameRrs);
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create ZIP file.'], 500);
        }

        // Return the ZIP file as a download
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
