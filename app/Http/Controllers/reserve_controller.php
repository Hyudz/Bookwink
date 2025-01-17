<?php

namespace App\Http\Controllers;
use App\Models\borrows_table;
use App\Models\books_table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\notifs_table;
use App\Models\users_table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class reserve_controller extends Controller
{
    function request_reserve($id) {

        //ETO YUNG MAG NO NOTIFY KAY ADMIN IF MAY NAG REQUEST NG RESERVATION
        //SQL CODE: INSERT INTO BORROWS_TABLE VALUES ('user_id', 'book_id', 'status', 'borrow_date', 'return_date')
        $borrow = borrows_table::create([
            'user_id' => Auth::user()->id,
            'book_id' => $id,
            'status' => 'pending',
            'borrow_date' => date('Y-m-d'),
            'return_date' => date('Y-m-d', strtotime('+7 days')),
        ]);
        
        $admins = users_table::where('user_type', 'admin')->get();

        foreach ($admins as $admin) {
            notifs_table::create([
                'user_id' => $admin->id, 
                'borrow_id' => $borrow->id, 
                'message' => 'A user has requested a reservation',
                'notification_type' => 'reservation',
                'is_read' => false,
            ]);
        }        

        return redirect()->route('homepage')->with('success', 'Reservation requested successfully');

    }

    function cancel_reservation($id) {  

        //USER CANCELS THE RESERVATION

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'cancelled' WHERE ID = $id

        $borrow_status = borrows_table::findOrFail($id);
        $borrow_status->status = 'cancelled';
        $borrow_status->save();

        //SQL CODE: UPDATE BOOKS_TABLE SET STATUS = 'available' WHERE ID = $borrow_status->book_id

        $book = books_table::find($borrow_status->book_id);
        $book->status = 'available';
        $book->save();

        $admins = users_table::where('user_type', 'admin')->get();

        foreach ($admins as $admin) {
            
            $cancel_notification = notifs_table::where('borrow_id', $borrow_status->id)
            ->where('user_id', $admin->id)
            ->where('notification_type', 'reservation')
            ->first();

            if ($cancel_notification) {
                $cancel_notification->is_read = false; // Reset the read status
                $cancel_notification->message = Auth::user()->username . ' canceled the reservation for the book: ' . $book->title;
                $cancel_notification->notification_type = 'cancellation'; // Update the type if needed
                $cancel_notification->save();
            }
        }

        //$update_notif = notifs_table::where('borrow_id', $id);
    
        return redirect()->route('my_borrows')->with('success', 'Reservation cancelled successfully');

    }

    function pickup($id) {

        //ETO NAMAN PAG NAKUHA NA NI CLIENT YUNG BOOK

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'borrowed' WHERE ID = $id

        $borrow_status = borrows_table::findorFail($id);
        $borrow_status-> status = 'borrowed';
        $borrow_status->save();

        $admins = users_table::where('user_type', 'admin')->get();

        foreach ($admins as $admin) {
            
            $approved_notification = notifs_table::where('borrow_id', $borrow_status->id)
            ->where('user_id', $admin->id)
            ->where('notification_type', 'approved')
            ->first();

            if ($approved_notification) {
                $approved_notification->is_read = false; 
                $approved_notification->message = Auth::user()->username. ' has picked up the book';
                $approved_notification->notification_type = 'picked up';
                $approved_notification->save();
            }
        }
        return redirect()->route('my_borrows')->with('success', 'Book picked up successfully');

    }

    function return_book($id) {

        //ETO YUNG MAG NONOTIFY SI ADMIN IF NIRETURN NA NI CLIENT YUNG BOOK TAS SI ADMIN NA BAHALA MAG APPROVE

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'request return' WHERE ID = $id
        $borrow_status = borrows_table::findorFail($id);
        $borrow_status-> status = 'request return';
        $borrow_status->save();

        $book = books_table::find($borrow_status->book_id);

        $admins = users_table::where('user_type', 'admin')->get();


        foreach ($admins as $admin) {

            $return_notification = notifs_table::where('borrow_id', $borrow_status->id)
            ->where('user_id', $admin->id)
            ->where('notification_type', 'picked up')
            ->first();

            if ($return_notification) {
                $return_notification->is_read = false; // Reset the read status
                $return_notification->message = 'New Return Book Request: ' . Auth::user()->username;
                $return_notification->notification_type = 'return request';
                $return_notification->save();
            }
        }

        return redirect()->route('my_borrows')->with('success', 'Book returned successfully');

    }

    function my_borrows() {

        //SELECTS ALL THE BORROWED BOOKS OF THE USER AND RETURNS IT WITH THE VIEW

        //SQL CODE:
        // SELECT borrows_table.*, books_tables.title, users_tables.username 
        // FROM borrows_table
        // INNER JOIN books_tables ON borrows_table.book_id = books_tables.id
        // INNER JOIN users_tables ON borrows_table.user_id = users_tables.id;

        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'returned')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);

    }

    function approved_books() {

        //SELECTS ALL THE BORROWED BOOKS OF THE USER AND RETURNS IT WITH THE VIEW

        //SQL CODE:
        // SELECT borrows_table.*, books_tables.title, users_tables.username 
        // FROM borrows_table
        // INNER JOIN books_tables ON borrows_table.book_id = books_tables.id
        // INNER JOIN users_tables ON borrows_table.user_id = users_tables.id;
        // ORDER BY borrows_table.created_at DESC

        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'approved')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);

    }

    function pending_books(){
        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'pending')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);
    }

    function cancelled_books(){
        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'cancelled')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);
    }

    function rejected_books(){
        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'rejected')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);

    }

    function returning_books(){
        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'request return')
        ->orWhere('borrows_table.status', 'borrowed')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);

    }

    function extend_book(){
        $borrowedBooks = DB::table('borrows_table')
        ->where('borrows_table.status', 'extend')
        ->orWhere('borrows_table.status', 'borrowed')
        ->join('books_tables', 'borrows_table.book_id', '=', 'books_tables.id')
        ->join('users_tables', 'borrows_table.user_id', '=', 'users_tables.id')
        ->select('borrows_table.*', 'books_tables.title', 'users_tables.username')
        ->where('users_tables.id', Auth::user()->id)
        ->orderBy('borrows_table.created_at', 'DESC')
        ->get();

        $user_details = Auth::user();
        $notifications = DB::table('notifs_tables')->where('user_id', Auth::user()->id)->get();

        return view('my_borrows', ['borrowedBooks' => $borrowedBooks, 'user_details' => $user_details, 'notifications' => $notifications]);
    }

    function request_extend($id) {
         //ETO YUNG MAG NONOTIFY SI ADMIN IF GUSTO MAG EXTEND NI CLIENT SA PAG HIRAM NG BOOK

        //SQL CODE: UPDATE BORROWS_TABLE SET STATUS = 'request return' WHERE ID = $id
        $borrow_status = borrows_table::findorFail($id);
        $borrow_status-> status = 'extend';
        $borrow_status->return_date = Carbon::parse($borrow_status->return_date)->addDays(7);
        $borrow_status->save();

        $book = books_table::find($borrow_status->book_id);

        $admins = users_table::where('user_type', 'admin')->get();


        foreach ($admins as $admin) {

            $return_notification = notifs_table::where('borrow_id', $borrow_status->id)
            ->where('user_id', $admin->id)
            ->where('notification_type', 'picked up')
            ->first();

            if ($return_notification) {
                $return_notification->is_read = false; 
                $return_notification->message = 'New Extend Book Request: ' . Auth::user()->username;
                $return_notification->notification_type = 'extend';
                $return_notification->save();
            }
        }

        return redirect()->route('my_borrows')->with('success', 'Book returned successfully');
    }
}
