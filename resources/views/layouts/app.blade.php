<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Lara Blog') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <!-- FontAwesome -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link href="{{ asset('img/logo.png') }}" rel="icon" />

    {{-- jQuery --}}
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

    <style>
        #app {
            background-image: url("{{ asset('img/Pattern-Randomized.svg') }}");
            background-color: #ffffff;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
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
    <script src="{{ asset('js/plugins.js') }}"></script>
</body>
</html>
