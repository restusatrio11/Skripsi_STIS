{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
<!DOCTYPE html>
<html lang="en">

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
    <link rel="shortcut icon" href="\images\simanja.png">
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
            overflow-y: auto;
            /* Tambahkan properti overflow-y */
            max-height: 100vh;
            /* Tambahkan properti max-height */
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

        .nav-link.active {
            background-color: #007bff;
            /* Warna latar belakang ketika elemen aktif */
            color: #fff;
            /* Warna teks ketika elemen aktif */
            font-weight: bold;
            /* Atur ketebalan teks ketika elemen aktif */
        }

        .custom-link {
            color: inherit;
            text-decoration: none;
        }

        .custom-link:hover {
            color: blue;
        }
    </style>
</head>

<body style="background:#007bff;">
    <div class="container">
        <div class="card card1 mx-auto" style="max-width: 600px; background:white; ">
            <div class="row justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="row justify-content-center">
                        <img id="logo" src="\images\simanja.png" class="img-fluid"
                            style="max-width: 100px; max-height: 200px; padding-top:50px;">
                    </div>
                    <h3 class="text-center heading">SIMANJA</h3>
                    <h3 class="mb-3 text-center heading" style="font-weight:bold;">Reset Your Password</h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-2 form-group">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-2 form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-5 form-group">
                            <label for="email">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>


                        <div class="mb-5 row justify-content-center my-3 px-3">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                        <div class="row justify-content-start px-3" style="position: absolute; top: 10px; left: 10px;">
                            <a href="/simanja" class="custom-link">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
