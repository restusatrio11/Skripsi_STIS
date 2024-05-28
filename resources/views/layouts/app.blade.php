{{-- <!doctype html> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('simanjaAPP.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="\build\assets\admin.css">
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    {{-- <!-- bootstrap -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> --}}
    <!-- js -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

    <!-- shortcut icon-->
    <link rel="shortcut icon" href="\images\simanja.png">
    <style>
        .bg-iconbox {
            background: white;
            color: #0D99FF;
        }

        .btn-custom {
            background: #0D99FF1A;
            /* Warna biru tua */
            color: #0D99FF;
            /* Warna teks putih */
        }

        .btn-custom:hover {
            background-color: #4c96db;
            color: #fff;
            /* Warna biru tua yang berbeda saat dihover */
        }

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
            overflow-y: auto;
            /* Tambahkan properti overflow-y */
            max-height: 1000vh;
            /* Tambahkan properti max-height */
        }

        .active-main-content {
            margin-left: 170px;
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
            background-color: #4c96db;
            color: #fff;
        }

        .nav-item.active .sb {
            background-color: #4c96db;
            /* Warna biru tua */
            color: #fff;
            font-weight: bold;
        }

        .nav-item .sb i {
            margin-right: 10px;
        }

        .nav-link.active {
            background-color: #4c96db;
            /* Warna biru tua */
            color: #fff;
            /* Warna teks ketika elemen aktif */
            font-weight: bold;
            /* Atur ketebalan teks ketika elemen aktif */
        }

        .notification-icon {
            position: relative;
            margin-left: 10px;
            /* Sesuaikan jarak dari nama pengguna */
        }

        #notification-bell {
            font-size: 20px;
        }

        #notification-badge {
            position: absolute;
            top: -5px;
            /* Sesuaikan posisi vertikal sesuai kebutuhan */
            right: -10px;
            /* Sesuaikan posisi horizontal sesuai kebutuhan */
            background-color: red;
            color: white;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: none;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 10px;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: red;
            color: white;
        }

        .tandaisemua:hover {
            background-color: #007bff;
            color: #fff;
        }

        @media (max-width: 768px) {
            .navbar-brand .logo {
                max-width: 10%;
                /* Ubah ukuran maksimum logo */
            }

            .navbar-brand {
                font-size: 20px;
                /* Ubah ukuran font */
            }
        }

        /* CSS untuk mode responsif */
        @media (max-width: 768px) {

            /* Atur lebar dropdown menjadi lebih kecil */
            .dropdown-menu {
                min-width: auto;
                /* Sesuaikan dengan kebutuhan Anda */
                max-width: 200px;
                /* Sesuaikan dengan kebutuhan Anda */
            }

            /* Atur padding dan margin item dropdown */
            .dropdown-item {
                padding: 0.5rem 1rem;
                /* Sesuaikan dengan kebutuhan Anda */
                margin: 0.2rem 0;
                /* Sesuaikan dengan kebutuhan Anda */
            }
        }

        .samping {
            padding-top: 30px;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="card mt-5">

            <nav class="navbar navbar-expand navbar-light shadow-sm fixed-top " style="background-color: #ffffff;">
                <nav class="navbar">
                    <div class="container-fluid">
                        <button class="btn btn-custom" id="button-toggle" aria-label="burgerbutton">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <a class="navbar-brand fw-bold d-flex align-items-center"
                                href="{{ url('/simanja/dashboard') }}" style="font-size: 25px; color:#043277;">
                                <img src="\images\simanja.png" alt="Logo" class="logo" style="max-width: 15%;">
                                <span class="ms-3 d-flex align-items-center">{{ config('app.name', 'Laravel') }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="collapse navbar-collapse">
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Notification Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="notificationDropdown" class="nav-link" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-bell"></i>
                                    @if (auth()->user()->unreadNotifications->count() > 0)
                                        <span
                                            class="badge bg-danger notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown"
                                    style="max-height: 300px; overflow-y: auto;">
                                    <div class="dropdown-header">Notifikasi</div>
                                    <hr>
                                    @if (auth()->user()->unreadNotifications->isEmpty())
                                        <a href="#" class="dropdown-item">Tidak ada notifikasi</a>
                                    @else
                                        <!-- List of notifications -->
                                        @foreach (auth()->user()->unreadNotifications as $notification)
                                            @php
                                                $date = new DateTime($notification->data['waktu_dibuat']);
                                                $bulan = [
                                                    'Januari',
                                                    'Februari',
                                                    'Maret',
                                                    'April',
                                                    'Mei',
                                                    'Juni',
                                                    'Juli',
                                                    'Agustus',
                                                    'September',
                                                    'Oktober',
                                                    'November',
                                                    'Desember',
                                                ];
                                                $formattedDate =
                                                    $date->format('d') .
                                                    ' ' .
                                                    $bulan[intval($date->format('m')) - 1] .
                                                    ' ' .
                                                    $date->format('Y');
                                            @endphp
                                            @if ($notification->data['title'] == 'Pekerjaan Telah Dikerjakan')
                                                <a href="/simanja/progress" class="dropdown-item">
                                                    <small class="text-muted">{{ $formattedDate }}</small><br>
                                                    <strong>{{ $notification->data['title'] }}</strong><br>
                                                    <div class="overflow-hidden" style="width: 100%;">
                                                        <p class="mb-0 text-wrap">
                                                            {{ $notification->data['description'] }}</p>
                                                    </div>
                                                </a>
                                            @elseif($notification->data['title'] == 'Pekerjaan Baru Diberikan')
                                                <a href="/simanja/pekerjaan" class="dropdown-item">
                                                    <small class="text-muted">{{ $formattedDate }}</small><br>
                                                    <strong>{{ $notification->data['title'] }}</strong><br>
                                                    <div class="overflow-hidden" style="width: 100%;">
                                                        <p class="mb-0 text-wrap">
                                                            {{ $notification->data['description'] }}</p>
                                                    </div>
                                                </a>
                                            @elseif($notification->data['title'] == 'Pekerjaan Dikembalikan')
                                                <a href="/simanja/pekerjaan" class="dropdown-item">
                                                    <small class="text-muted">{{ $formattedDate }}</small><br>
                                                    <strong>{{ $notification->data['title'] }}</strong><br>
                                                    <div class="overflow-hidden" style="width: 100%;">
                                                        <p class="mb-0 text-wrap">
                                                            {{ $notification->data['description'] }}</p>
                                                    </div>
                                                </a>
                                            @endif
                                            <hr>
                                        @endforeach
                                        <!-- Mark as Read Link -->
                                        <a href="{{ route('notif.list') }}" class="dropdown-item tandaisemua">Tandai
                                            Semua
                                            Terbaca</a>
                                    @endif
                                </div>
                            </li>

                            <!-- Logout Dropdown -->
                            <li class="nav-item dropdown">
                                {{-- @php
                                    $userName = Auth::user()->name; // Mendapatkan nama lengkap pengguna dari Auth
                                    $nameParts = explode(' ', $userName); // Memecah nama lengkap menjadi array berdasarkan spasi
                                    $firstName = $nameParts[0]; // Mengambil kata pertama dari nama pengguna
                                @endphp --}}
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Logout Form -->
                                    <a class="dropdown-item" aria-label="profil"
                                        href="{{ route('profil', ['pegawai_id' => Auth::user()->id]) }}">
                                        Profil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" aria-label="logout"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>


                    {{-- </div> --}}
            </nav>
            <div class="sidebar p-3 active-sidebar" id="sidebar">
                <ul class="nav flex-column samping">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/dashboard">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="progressLink">
                                <span>Progress</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuProgress" style="display: none;">
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/Tim_Klaten">
                                        <i class="bi bi-list"></i> Progress Tim Klaten</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/progress">
                                        <i class="bi bi-journals"></i></i>Progress
                                        {{ Auth::check() && Auth::user()->JenisJabatan && Auth::user()->JenisJabatan->NamaTim ? Auth::user()->JenisJabatan->NamaTim->tim : '' }}</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/pekerjaan">
                                <i class="bi bi-person-workspace"></i> Pekerjaan
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="masterLink">
                                <span>Master</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuMaster" style="display: none;">
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/user"><i class="bi bi-person"></i>User</a>
                                </li>
                                <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenispekerjaan"><i
                                            class="bi bi-journal"></i>Jenis Pekerjaan</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/master/pegawai"><i
                                            class="bi bi-person-square"></i>Pegawai</a>
                                </li>
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenistim"><i
                                            class="bi bi-people-fill"></i>Jenis Tim</a>
                                </li> --}}
                            </ul>
                        </li>

                        {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                            <a class="nav-link sb" href="/simanja/kepala_BPS">
                                <i class="fa fa-user"></i> Kepala BPS
                            </a>
                        </li>
                         --}}
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/support">
                                <i class="bi bi-info-square"></i> Support
                            </a>
                        </li>
                    @elseif (Auth::check() && Auth::user()->role == 'user')
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="progressLink">
                                <span>Progress</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuProgress" style="display: none;">
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/Tim_Klaten">
                                        <i class="bi bi-list"></i> Progress Tim Klaten</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/progress">
                                        <i class="bi bi-journals"></i></i>Progress {{ Auth::user()->tim }}</a>
                                </li> --}}
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/pekerjaan">
                                <i class="bi bi-person-workspace"></i> Pekerjaan
                            </a>
                        </li>

                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="masterLink">
                                <span>Master</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuMaster" style="display: none;">
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/user"><i class="bi bi-person"></i>User</a>
                                </li>
                                <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenispekerjaan"><i
                                            class="bi bi-journal"></i>Jenis Pekerjaan</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/master/pegawai"><i
                                            class="bi bi-person-square"></i>Pegawai</a>
                                </li>
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenistim"><i
                                            class="bi bi-people-fill"></i>Jenis Tim</a>
                                </li> --}}
                            </ul>
                        </li>

                        {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                            <a class="nav-link sb" href="/simanja/kepala_BPS">
                                <i class="fa fa-user"></i> Kepala BPS
                            </a>
                        </li>
                         --}}
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/support">
                                <i class="bi bi-info-square"></i> Support
                            </a>
                        </li>
                    @elseif(Auth::check() && Auth::user()->role == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="progressLink">
                                <span>Progress</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuProgress" style="display: none;">
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/Tim_Klaten">
                                        <i class="bi bi-list"></i> Progress Tim Klaten</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/progress">
                                        <i class="bi bi-journals"></i></i>Progress {{ Auth::user()->tim }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/pekerjaan">
                                <i class="bi bi-person-workspace"></i> Pekerjaan
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ Request::is('superadmin') ? 'active' : '' }} sb"
                                href="/simanja/superadmin">
                                <i class="fa fa-user"></i> Master
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="masterLink">
                                <span>Master</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuMaster" style="display: none;">
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/user"><i class="bi bi-person"></i>User</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/jenispekerjaan"><i
                                            class="bi bi-journal"></i>Jenis Pekerjaan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/master/pegawai"><i
                                            class="bi bi-person-square"></i>Pegawai</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/jenistim"><i
                                            class="bi bi-people-fill"></i>Jenis Tim</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/support">
                                <i class="bi bi-info-square"></i> Support
                            </a>
                        </li>
                    @elseif (Auth::check() && Auth::user()->role == 'kepala_bps')
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="progressLink">
                                <span>Progress</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuProgress" style="display: none;">
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/Tim_Klaten">
                                        <i class="bi bi-list"></i> Progress Tim Klaten</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/progress">
                                        <i class="bi bi-journals"></i></i>Progress {{ Auth::user()->tim }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/pekerjaan">
                                <i class="bi bi-person-workspace"></i> Pekerjaan
                            </a>
                        </li>

                        <!-- Garis pemisah antara Dashboard dan Progress -->

                        <li class="nav-item">
                            <a class="nav-link d-flex justify-content-between sb" href="#" id="masterLink">
                                <span>Master</span><i class="bi bi-caret-down"></i>
                            </a>
                            <ul class="nav flex-column ml-3" id="submenuMaster" style="display: none;">
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/user"><i class="bi bi-person"></i>User</a>
                                </li>
                                <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenispekerjaan"><i
                                            class="bi bi-journal"></i>Jenis Pekerjaan</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="nav-link sb" href="/simanja/master/pegawai"><i
                                            class="bi bi-person-square"></i>Pegawai</a>
                                </li>
                                {{-- <li class="nav-item" style="pointer-events: none; background:black; opacity:15%;">
                                    <a class="nav-link sb" href="/simanja/jenistim"><i
                                            class="bi bi-people-fill"></i>Jenis Tim</a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/kepala_BPS">
                                <i class="fa fa-user"></i> Kepala BPS
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link sb" href="/simanja/support">
                                <i class="bi bi-info-square"></i> Support
                            </a>
                        </li>
                        <!-- Garis pemisah antara Dashboard dan Progress -->
                    @elseif (Auth::check() && Auth::user()->role == null)
                        <!-- Jika role adalah null, maka Anda dapat menambahkan tindakan lain di sini -->
                    @endif
                </ul>
            </div>

            <div class="active-main-content" id="main-content">

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var submenuProgress = document.getElementById("submenuProgress");
            var progressLink = document.getElementById("progressLink");

            progressLink.addEventListener("click", function(e) {
                e.preventDefault();
                submenuProgress.style.display = (submenuProgress.style.display === "block") ? "none" :
                    "block";
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var submenuMaster = document.getElementById("submenuMaster");
            var masterLink = document.getElementById("masterLink");

            masterLink.addEventListener("click", function(e) {
                e.preventDefault();
                submenuMaster.style.display = (submenuMaster.style.display === "block") ? "none" : "block";
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentPath = window.location.pathname;

            // Loop melalui setiap elemen navigasi
            document.querySelectorAll('.nav-link').forEach(function(element) {
                var linkPath = element.getAttribute('href');

                // Bandingkan path halaman saat ini dengan path elemen navigasi
                if (currentPath === linkPath) {
                    // Tambahkan kelas 'active' jika sesuai
                    element.classList.add('active');
                }
            });

            // Tambahan untuk menangani dropdown 'Progress'
            var submenuProgress = document.getElementById('submenuProgress');

            if (submenuProgress) {
                // Loop melalui setiap elemen di dalam dropdown 'Progress'
                submenuProgress.querySelectorAll('.nav-link').forEach(function(subElement) {
                    var subLinkPath = subElement.getAttribute('href');

                    // Bandingkan path halaman saat ini dengan path elemen dropdown 'Progress'
                    if (currentPath === subLinkPath) {
                        // Tambahkan kelas 'active' pada elemen dropdown dan elemen induk
                        subElement.classList.add('active');
                        document.getElementById('progressLink').classList.add('active');
                        submenuProgress.style.display = 'block'; // Tampilkan dropdown jika sesuai
                    }
                });
            }

            // Tambahan untuk menangani dropdown 'Master'
            var masterLink = document.getElementById('masterLink');
            var submenuMaster = document.getElementById('submenuMaster');

            if (submenuMaster) {
                // Loop melalui setiap elemen di dalam dropdown 'Master'
                submenuMaster.querySelectorAll('.nav-link').forEach(function(subElement) {
                    var subLinkPath = subElement.getAttribute('href');

                    // Bandingkan path halaman saat ini dengan path elemen dropdown 'Master'
                    if (currentPath === subLinkPath) {
                        // Tambahkan kelas 'active' pada elemen dropdown dan elemen induk
                        subElement.classList.add('active');
                        masterLink.classList.add('active');
                        submenuMaster.style.display = 'block'; // Tampilkan dropdown jika sesuai
                    }
                });

                // Jika ada elemen yang memerlukan pointer-events: none, berikan penanganan khusus
                submenuMaster.querySelectorAll('.nav-item[style*="pointer-events: none;"]').forEach(function(
                    disabledElement) {
                    // Hilangkan kelas 'active' jika ada
                    disabledElement.querySelector('.nav-link').classList.remove('active');
                });
            }
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simulasi jumlah notifikasi yang belum dibaca
            let unreadNotifications = 3;

            // Selector untuk elemen lonceng notifikasi
            const notificationBadge = document.getElementById('notification-badge');

            // Fungsi untuk menampilkan jumlah notifikasi yang belum dibaca
            function updateNotificationBadge(count) {
                if (count > 0) {
                    notificationBadge.style.display = 'inline';
                    notificationBadge.textContent = count;
                } else {
                    notificationBadge.style.display = 'none';
                }
            }

            // Memperbarui jumlah notifikasi yang belum dibaca saat halaman dimuat
            updateNotificationBadge(unreadNotifications);
        });
    </script> --}}

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if ("serviceWorker" in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register("/sw.js").then(
                (registration) => {
                    console.log("Service worker registration succeeded:", registration);
                },
                (error) => {
                    console.error(`Service worker registration failed: ${error}`);
                },
            );
        } else {
            console.error("Service workers are not supported.");
        }
    </script>

</body>

</html>
