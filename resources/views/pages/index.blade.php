@extends('layouts.app')

@section('content')

    <div class="jumbotron text-center">
        <h1>Welcome To Laravel!</h1>
        <P>My First App With Laravel From Scratch</p>
        <p>
            @if(!isset(auth()->user()->id))
                <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a>
                <a class="btn btn-success btn-lg" href="/register" role="button">Register</a>
            @else
                <a class="btn btn-primary btn-lg" href="/home" role="button">Dashboard</a>
            @endif
    	</p>
    </div>

@endsection