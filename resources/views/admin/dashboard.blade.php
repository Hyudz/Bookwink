@extends('admin.app')

@section('title', 'Dashboard') 
@section('content')
    <h1>Welcome to the Dashboard</h1>

    <div class="d-flex">
        <div class="ms-3 card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Books</h5>
                <!-- <h6 class="card-subtitle mb-2 text-body-secondary"></h6> -->
                <p class="card-text">
                    Total Number of Books: {{ $books }}
                </p>
            </div>
        </div>

        <div class="ms-3 card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Reserved Books</h5>
                <!-- <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6> -->
                <p class="card-text">
                    Total Number of Borrowed Books: {{ $reserved_books }}
                </p>
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
            </div>
        </div>

        <div class="ms-3 card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <!-- <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6> -->
                <p class="card-text">Total number of users: {{$users->count()}}</p>
                <p class="card-text">Total number of male: {{$users->where('gender', 'Male')->count()}}</p>
                <p class="card-text">Total number of female: {{$users->where('gender', 'Female')->count()}}</p>
                <!-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> -->
            </div>
        </div>
    </div>
@endsection
