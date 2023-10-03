{{-- <!doctype html> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="\build\assets\admin.css">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script> --}}


    <!-- bootstrap -->
    {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script> --}}


    <!-- js -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- shortcut icon-->
    <link rel="shortcut icon" href="\images\BPS.png">
    <style>
        li {
            list-style: none;
            margin: 1px 0 1px 0;
        }

        a {
            text-decoration: none;
        }

        .sidebar {
            width: 170px;
            height: 100vh;
            position: fixed;
            margin-left: -300px;
            transition: 0.4s;
            background: linear-gradient(to right, #4c96db, #194d7e);
        }

        .active-main-content {
            margin-left: 250px;
        }

        .active-sidebar {
            margin-left: 0;
        }

        #main-content {
            transition: 0.4s;
        }

        .nav-item .sb {
            margin-bottom: 10px;
        }

        .nav-item .sb {
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border-radius: 5px;
        }

        .nav-item .sb:hover {
            background-color: #007bff;
            color: #fff;
        }

        .nav-item.active .sb {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .nav-item .sb i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="card mt-5">

            <nav class="navbar navbar-expand-md navbar-light shadow-sm fixed-top " style="background-color: #ffffff;">
                <nav class="navbar">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="button-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </nav>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <a class="navbar-brand fw-bold" href="{{ url('visual') }}"
                                style="font-size: 25px; color:#043277;"><img src="\images\BPS.png" alt="Logo"
                                    class="logo" style="max-width: 10%;">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                        </ul>

                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav mx-auto" style="color: #043277">
                                {{-- @if (Auth::check() && Auth::user()->role == 'admin')
                                    <a class="nav-item nav-link active" href="/visual" style="color: #043277">Home</a>
                                    <a class="nav-item nav-link" href="/admin" style="color: #043277">Progress</a>
                                    <a class="nav-item nav-link" href="#" data-bs-toggle="modal"
                                        data-bs-target="#tambahkerja" style="color: #043277">Alokasi Tugas</a>
                                    <a class="nav-item nav-link" href="#" data-bs-toggle="modal"
                                        data-bs-target="#ckpkerja" id="cetak" style="color: #043277">CKP</a>
                                @elseif (Auth::check() && Auth::user()->role == 'user')
                                    <a class="nav-item nav-link active" href="/visual">Home</a>
                                    <a class="nav-item nav-link" href="/user">Progress</a>
                                @elseif (Auth::check() && Auth::user()->role == null)
                                    <div></div>
                                @endif --}}
                            </div>
                        </div>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                {{-- @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif --}}
                            @else
                                <li class="nav-item dropdown haha">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle haha" href="#"
                                        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end haha" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item haha" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                    {{-- </div> --}}
            </nav>
            <div class="sidebar p-3" id="sidebar">
                <ul class="nav flex-column">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('visual') ? 'active' : '' }} sb" href="/visual">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }} sb" href="/admin">
                                <i class="fa fa-tasks"></i> Progress
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user') ? 'active' : '' }} sb" href="/user">
                                <i class="fa fa-user"></i> User
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                    @elseif (Auth::check() && Auth::user()->role == 'user')
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('visual') ? 'active' : '' }} sb" href="/visual">
                                <i class="fa fa-home"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user') ? 'active' : '' }} sb" href="/user">
                                <i class="fa fa-tasks"></i> Progress
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                    @elseif(Auth::check() && Auth::user()->role == 'superadmin')
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('visual') ? 'active' : '' }} sb" href="/visual">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }} sb" href="/admin">
                                <i class="fa fa-tasks"></i> Progress
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('user') ? 'active' : '' }} sb" href="/user">
                                <i class="fa fa-user"></i> User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('superadmin') ? 'active' : '' }} sb"
                                href="/superadmin">
                                <i class="fa fa-user"></i> Super Admin
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                        <hr>
                    @elseif (Auth::check() && Auth::user()->role == null)
                        <!-- Jika role adalah null, maka Anda dapat menambahkan tindakan lain di sini -->
                    @endif
                </ul>
            </div>

            <div class="p-4" id="main-content">

                <div class="card-body">
                    <main class="py-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="\build\assets\admin.js"></script>
    <script>
        // event will be executed when the toggle-button is clicked
        document.getElementById("button-toggle").addEventListener("click", () => {

            // when the button-toggle is clicked, it will add/remove the active-sidebar class
            document.getElementById("sidebar").classList.toggle("active-sidebar");

            // when the button-toggle is clicked, it will add/remove the active-main-content class
            document.getElementById("main-content").classList.toggle("active-main-content");
        });
    </script>



</body>

</html>
