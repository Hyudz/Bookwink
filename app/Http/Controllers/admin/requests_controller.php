<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\books_table;
use App\Models\borrows_table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\notifs_table;
use App\Models\users_table;

class requests_controller extends Controller
{
    
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

            notifs_table::create([
            'user_id' => $borrow->user_id,
            'borrow_id' => $borrow->id,
            'is_read' => false,
            'notification_type' => 'approval',
            'message' => 'Your request to borrow the book ' . $book->title . ' has been approved'
        ]);

        DB::table('notifs_tables')->where('borrow_id', $borrow->id)->where('notification_type', 'reservation')->update(['notification_type' => 'approved']);

        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return redirect()->route('admin.reserved_books', [
            'borrowed_book' => $borrowed_book,
            'notifications' => $notifications
        ])->with('success', 'Request approved successfully');

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

        notifs_table::create([
            'user_id' => $borrow->user_id,
            'borrow_id' => $borrow->id,
            'is_read' => false,
            'notification_type' => 'approval',
            'message' => 'Your request to borrow the book ' . $book->title . ' has been rejected.'
        ]);

        DB::table('notifs_tables')->where('borrow_id', $borrow->id)->where('notification_type', 'reservation')->update(['notification_type' => 'rejected']);
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();
        return redirect()->route('admin.reserved_books', ['borrowed_book' => $borrowed_book, 'notifications' => $notifications])->with('success', 'Request rejected successfully');
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

        $notify_user = notifs_table::where('borrow_id', $borrow->id)
        ->where('user_id', $borrow->user_id)
        ->where('notification_type', 'approval')
        ->first();

        if ($notify_user) {
            $notify_user->is_read = false; // Reset the read status
            $notify_user->message = 'Return request for the book ' . $book->title . ' has been approved';
            $notify_user->notification_type = 'returned';
            $notify_user->save();
        }

        //update din yung notification sa admin side

        $admins = users_table::where('id', Auth::user()->id)->first();
        $update_admin = notifs_table::where('borrow_id', $borrow->id)
        ->where('user_id', $admins->id)
        ->where('notification_type', 'return request')
        ->first();

        if ($update_admin) {
            $update_admin->is_read = false; // Reset the read status
            $update_admin->message = 'Return request for the book ' . $book->title . ' has been approved';
            $update_admin->notification_type = 'returned';
            $update_admin->save();
        }

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

        $notify_user = notifs_table::where('borrow_id', $borrow->id)
        ->where('user_id', $borrow->user_id)
        ->where('notification_type', 'approval')
        ->first();

        if ($notify_user) {
            $notify_user->is_read = false; // Reset the read status
            $notify_user->message = 'Return request for the book ' . $book->title . ' has been rejected';
            $notify_user->notification_type = 'return request';
            $notify_user->save();
        }

        //update din yung notification sa admin side

        $admins = users_table::where('id', Auth::user()->id)->first();
        $update_admin = notifs_table::where('borrow_id', $borrow->id)
        ->where('user_id', $admins->id)
        ->where('notification_type', 'return request')
        ->first();

        if ($update_admin) {
            $update_admin->is_read = false; // Reset the read status
            $update_admin->message = 'Return request for the book ' . $book->title . ' has been rejected';
            $update_admin->notification_type = 'approval';
            $update_admin->save();
        }

        return redirect()->route('admin.reserved_books')->with('success', 'Return rejected successfully');
    }
}
