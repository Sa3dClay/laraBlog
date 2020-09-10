@extends('layouts.app')

@section('content')

    <div class="about-me jumbotron">
        <div class="row justify-content-center">
            <div class="col-md-3 my-img">
                <img src="{{ asset('img/me.jpg') }}" class="img-fluid" title="Abdo Atef" />
            </div>

            <div class="col-md-6 my-info">
                <h2>Abdulrahman Atef</h2>
                <span class="myJob">Web Developer</span>
                <p>I'm a computer science student who loves coding and programming. I'm from Egypt and live in Cairo.</p>
            </div>
        </div>
    </div>

@endsection
