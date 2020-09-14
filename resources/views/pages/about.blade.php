@extends('layouts.app')

@section('content')

    <div class="about-us jumbotron my-4">
        <div class="row justify-content-around">
            <div class="col-1"></div>
            <div class="col-2 about-img">
                <img src="{{ asset('img/atef.jpg') }}" class="img-fluid" title="Abdo Atef" />
            </div>

            <div class="col-8 about-info">
                <h2 class="name">Abdulrahman Atef</h2>
                <span class="bio">Full-stack Web Developer</span>
                <p>I'm a programmer who loves coding, working in web development and have a few experiences about UI/UX, building web applications with Laravel & Vue.</p>
            </div>
            <div class="col-1"></div>
        </div>

        <hr>

        <div class="row justify-content-around">
            <div class="col-1"></div>
            <div class="col-8 about-info">
                <h2 class="name">Abdulrahman Sobh</h2>
                <span class="bio">Back-end Web Developer</span>
                <p>I'm a programmer who loves coding, working in web development and have a few experiences about UI/UX, building web applications with Laravel & Vue.</p>
            </div>

            <div class="col-2 about-img">
                <img src="{{ asset('img/sobh.jpg') }}" class="img-fluid" title="Abdo Sobh" />
            </div>
            <div class="col-1"></div>
        </div>
    </div>

@endsection
