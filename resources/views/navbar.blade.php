<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="{{asset('img/logogo.png')}}" rel="icon" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            li::marker {
            content: none;
            }

        </style>
        <script src="https://kit.fontawesome.com/de52212229.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{route('homepage')}}">
                <img src="{{asset('img/logogo.png')}}" alt="logo" height="40" class="d-inline-block align-text-top">
            </a>    

            <div class="d-flex ms-3">
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-users rounded-circle" height="22"> </i>
                    </a>    
                    <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">My Profile</a></li>
                        <li><a class="dropdown-item" href="#">Bookmarks</a></li>
                        <li><a class="dropdown-item" href="#">Archive</a></li>
                        <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
                    </ul>
                </li>
            </div>
        </div>
    </nav>
    </body>
</html>