@extends('layouts.app')

@section('content')

    <div class="jumbotron my-4 py-4 text-center">
        <h2>Welcome To Blog!</h2>

        <div class="row justify-content-center my-4">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                <img src="{{ asset('img/undraw_welcome_cats_thqn.svg') }}" class="img-fuild img-thumbnail" title="welcome"/>
            </div>
        </div>

        <h4 class="px-5">LaraBlog is a blog where you can share your thoughts and experiences with others</h4>
        
        <p class="mb-0">
            {{-- Admin --}}
            @if(Auth::guard('admin')->check())
                <a class="btn btn-primary btn-lg mybtn" href="{{ url('posts') }}" role="button">Blog</a>
                <a class="btn btn-success btn-lg mybtn" href="{{ url('admin/home') }}" role="button">Dashboard</a>
            @else
                {{-- User --}}
                @if(Auth::guard('user')->check())
                    <a class="btn btn-primary btn-lg mybtn" href="{{ url('posts') }}" role="button">Blog</a>
                    <a class="btn btn-success btn-lg mybtn" href="{{ url('home') }}" role="button">Dashboard</a>
                {{-- Guest --}}
                @else
                    <a class="btn btn-primary btn-lg mybtn" href="{{ url('/login') }}" role="button">Login</a>
                    <a class="btn btn-success btn-lg mybtn" href="{{ url('/register') }}" role="button">Register</a>
                @endif
            @endif
    	</p>
    </div>

@endsection
