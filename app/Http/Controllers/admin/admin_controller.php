<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\books_table;
use App\Models\borrows_table;
use App\Models\users_table;
use Illuminate\Http\Request;
use App\Models\notifs_table;
use App\Models\rrs_table;
use Illuminate\Support\Facades\Hash;
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

    function read_notification($id) {

        $notification = notifs_table::find($id);
        $notification->is_read = true;
        $notification->save();

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

        

        return view('admin.notifs_content', ['notifications' => $notifications]);
    }


    function export_data() {
        // Export books to CSV
        $books = books_table::all();
        $fileNameBooks = 'books_backup.csv';
        $fileBooks = fopen($fileNameBooks, 'w');
        fputcsv($fileBooks, ['ID', 'Title', 'Title Copy', 'Author', 'Category', 'Description', 'Favorite Color' ,'Status', 'Cover', 'Rating', 'Created At', 'Updated At']);

        foreach ($books as $book) {
            $data = [
                $book->id,
                $book->title,
                $book->tittle_copy,
                $book->author,
                $book->category,
                $book->description,
                $book->favorite_color,
                $book->status,
                $book->cover,
                $book->rating,
                $book->created_at,
                $book->updated_at
            ];
            
            fputcsv($fileBooks, $data);
        }
        fclose($fileBooks);

        return response()->download($fileNameBooks)->deleteFileAfterSend(true);
    }

    function change_password_post(Request $request) {
        
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
    
        $user = users_table::find(Auth::user()->id);
        
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
    
            return back()->with('success', 'Password changed successfully.');
        }
    
        return back()->withErrors(['user_not_found' => 'User not found.']);
    }
}
