@extends('layouts.app')

@section('content')

    <div class="jumbotron my-4 py-4 text-center">
        <h2>Welcome To Blog!</h2>

        <div class="row justify-content-center my-4">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                <img src="{{ asset('img/undraw_welcome_cats_thqn.svg') }}" class="img-fuild img-thumbnail" title="welcome"/>
            </div>
        </div>

        <P>My First App With Laravel From Scratch</p>
        
        <p class="mb-0">
            @if(!isset(auth()->user()->id))
                <a class="btn btn-primary btn-lg mybtn" href="{{ url('/login') }}" role="button">Login</a>
                <a class="btn btn-success btn-lg mybtn" href="{{ url('/register') }}" role="button">Register</a>
            @else
                <a class="btn btn-primary btn-lg mybtn" href="{{ url('/home') }}" role="button">Dashboard</a>
            @endif
    	</p>
    </div>

@endsection
