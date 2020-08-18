<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'LaraBlog') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
<<<<<<< HEAD

=======
    
    <!-- My Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
>>>>>>> ba347bb9903d56748a212ed164596b2751a0bc12
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- FontAwesome -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link href="{{ asset('img/logo.png') }}" rel="icon" />

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</head>

<body>
    <div id="app">
        @include('components.navbar')

        <div class="container">
            @include('components.messages')

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
