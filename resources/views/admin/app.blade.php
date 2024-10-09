<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Dashboard')</title>
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
                    <a  class="list-group-item list-group-item-action py-2 ripple" data-bs-toggle="modal" data-bs-target="#add_book">
                        <i class="fa-solid fa-plus me-3"></i><span>Add Book</span>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="add_book" tabindex="-1" aria-labelledby="add_book_label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="add_book_label">Add Book</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{route('admin.add_books_post')}}" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <div class="row">
                                            <!-- Book Cover -->
                                            <div class="col-md-4 text-center">
                                                <div class="bg-secondary text-white p-3">
                                                    <h5>Book Cover</h5>
                                                    <input type="file" required class="form-control" name="book_cover" id="floatingCover">
                                                </div>
                                            </div>

                                            <!-- Book Details -->
                                            <div class="col-md-8">
                                                <div class="row">
                                                    <!-- Book Title -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-3">
                                                            <input required type="text" class="form-control" name="book_name" id="floatingTitle">
                                                            <label for="floatingTitle">Book Title:</label>
                                                        </div>
                                                    </div>

                                                    <!-- Book Category -->
                                                    <div class="col-md-6">
                                                        <div class="form-floating mb-3">
                                                            <select class="form-select" name="book_category" id="floatingCategory">
                                                                <option selected>Category:</option>
                                                                <option value="Fiction">Fiction</option>
                                                                <option value="Sci-Fi">Science-Fiction</option>
                                                                <option value="Science">Science</option>
                                                                <option value="Romance">Romance</option>
                                                                <option value="Mystery">Mystery</option>
                                                            </select>
                                                            <label for="floatingCategory">Category:</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Author -->
                                                <div class="form-floating mb-3">
                                                    <input type="text" required name="book_author" class="form-control" id="floatingAuthor">
                                                    <label for="floatingAuthor">Author:</label>
                                                </div>

                                                <!-- Description -->
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" required name="book_description" id="floatingDescription" style="height: 100px;"></textarea>
                                                    <label for="floatingDescription">Description:</label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Add Book</button>
                                        
                                    </form>
                                </div>

                                <div class="modal-footer">
                                            
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{route('admin.reserved_books')}}" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-line fa-fw me-3"></i><span>Reserved Books Approval</span>
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
                    <p> LOGO </p>
                </a>

                <!-- Search form -->
                <form class="d-none d-md-flex input-group w-auto my-auto">
                    <input autocomplete="off" type="search" class="form-control rounded" placeholder='Search (ctrl + "/" to focus)' style="min-width: 225px;" />
                    <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
                </form>

                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <!-- Notification dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Notif 1</a></li>
                            <li><a class="dropdown-item" href="#">Notif 2</a></li>
                            <li><a class="dropdown-item" href="#">Notif 3</a></li>
                        </ul>
                    </li>

                    <!-- Avatar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users rounded-circle" height="22"> </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
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
