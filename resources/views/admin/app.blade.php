<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Dashboard')</title>
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
        <script src="https://kit.fontawesome.com/de52212229.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
    .modal {
        z-index: 1060;
    }

    .modal-backdrop {
        display: none;
        z-index: 100;
    }

    .notifications-dropdown {
        width: 300px;
        height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .dropdown-item {
        word-wrap: break-word;
        white-space: normal; 
    }
</style>

    </head>
    <body>
        <!--Main Navigation-->
        <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="{{route('admin.dashboard')}}" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                        <i class="fa-solid fa-house me-3"></i><span>Dashboard</span>
                    </a>
                    <a href="{{route('admin.manage_books')}}" class="list-group-item list-group-item-action py-2 ripple">
                        <i class='fas fa-book-open me-3'></i><span>Manage Books</span>
                    </a>
                    <!-- Button trigger modal -->
                    <a href="{{route('admin.export_data')}}" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fa-solid fa-file-export me-3"></i><span>Export Data</span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="{{asset('img/logogo.png')}}" alt="logo" height="40" class="d-inline-block align-text-top">
                </a>

                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <!-- Notification dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge rounded-pill badge-notification bg-danger">
                                {{$notifications->where('is_read', false)->count()}}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                @foreach($notifications as $notification)
                                    @if(!$notification->is_read)
                                        <a class="dropdown-item" href="{{route('admin.read_notification', $notification->id)}}">{{$notification->message}}</a>
                                    @endif
                                @endforeach
                            <li>
                        </ul>
                    </li>

                    <!-- Avatar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users rounded-circle" height="22"> </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <!-- <li><a class="dropdown-item" href="#">My profile</a></li> -->
                            <li><a class="dropdown-item" href="#">Change Password</a></li>
                            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Navbar -->
        </header>
        <!--Main Navigation-->

        <!--Main layout-->
        <main style="margin-top: 58px;">
            <div class="container pt-4">
                @yield('content')
            </div>
        </main>
        <!--Main layout-->
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
