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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>


    <!-- bootstrap -->
    {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
     --}}

    <!-- js -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!-- shortcut icon-->
    <link rel="shortcut icon" href="\images\BPS.png">

</head>

<body style="background: #DDE9F5">

    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm " style="background-color: #ffffff;">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <a class="navbar-brand fw-bold" href="{{ url('home') }}"
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
                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <a class="nav-item nav-link active" href="/visual" style="color: #043277">Home</a>
                                <a class="nav-item nav-link" href="/admin" style="color: #043277">Progress</a>
                                <a class="nav-item nav-link" href="#" data-bs-toggle="modal"
                                    data-bs-target="#tambahkerja" style="color: #043277">Tugaskan</a>
                                <a class="nav-item nav-link" href="#" data-bs-toggle="modal"
                                    data-bs-target="#ckpkerja" id="cetak" style="color: #043277">CKP</a>
                            @elseif (Auth::check() && Auth::user()->role == 'user')
                                <a class="nav-item nav-link active" href="/visual">Home</a>
                                <a class="nav-item nav-link" href="/user">Progress</a>
                            @elseif (Auth::check() && Auth::user()->role == null)
                                <div></div>
                            @endif
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>

        <script type="text/javascript" src="\build\assets\admin.js"></script>

    </div>
</body>

</html>
