@extends('admin.app')
@section('title', 'Notification Details')
@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Notification Details</h4>

                    @foreach($notifications as $notification)
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <p><strong>Book Title:</strong> {{ $notification->book_title }}</p>
                            @if($notification->notification_type == 'reservation')
                            <p><strong>Message:</strong> {{ $notification->message }}</p>
                            @elseif($notification->notification_type == 'approved')
                            <p><strong>Message:</strong> You approved a request.</p>
                            @elseif($notification->notification_type == 'rejected')
                            <p><strong>Message:</strong> You rejected a request.</p>
                            @elseif($notification->notification_type == 'return request')
                            <p><strong>Message:</strong> The user returned the book. Check if the book is returned.</p>
                            @elseif($notification->notification_type == 'returned')
                            <p><strong>Message:</strong> Book returned.</p>
                            @elseif($notification->notification_type == 'return rejected')
                            <p><strong>Message:</strong> Return request rejected.</p>
                            @elseif($notification->notification_type == 'picked up')
                            <p><strong>Message:</strong> Book has been picked up by the user.</p>
                            @elseif($notification->notification_type == 'extend')
                            <p><strong>Message:</strong> The user requested to extend the borrow date.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <h5>Borrower Details:</h5>
                        <p><strong>Borrower Name:</strong> {{ $notification->borrower_name }}</p>
                        <p><strong>Borrower Email:</strong> {{ $notification->borrower_email }}</p>
                        <p><strong>Borrow Date:</strong> {{ $notification->borrow_date }}</p>
                        <p><strong>Return Date:</strong> {{ $notification->return_date }}</p>
                    </div>

                    @if($notification->notification_type == 'reservation')
                    <div class="d-flex justify-content-end mt-3">
                        <form action="{{ route('admin.reject_reservation', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger me-2">Disapprove</button>
                        </form>
                        <form action="{{ route('admin.approve_reservation', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $notification->borrow_id }}">
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </div>
                    
                    @elseif($notification->notification_type == 'return request')
                    <div class="d-flex justify-content-end mt-3">
                        <form action="{{ route('admin.approve_return', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $notification->borrow_id }}">
                            <button type="submit" class="btn btn-success me-2">Approve Return</button>
                        </form>
                        <form action="{{ route('admin.reject_return', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $notification->borrow_id }}">
                            <button type="submit" class="btn btn-danger">Disapprove Return</button>
                        </form>
                    </div>
                    @elseif($notification->notification_type == 'extend')
                    <div class="d-flex justify-content-end mt-3">
                        <form action="{{ route('admin.approve_extend', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $notification->borrow_id }}">
                            <button type="submit" class="btn btn-success me-2">Approve Extension</button>
                        </form>
                        <form action="{{ route('admin.reject_extend', $notification->borrow_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $notification->borrow_id }}">
                            <button type="submit" class="btn btn-danger">Reject Extension</button>
                        </form>
                    </div>

                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
