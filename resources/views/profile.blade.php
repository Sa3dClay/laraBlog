@extends('layouts.app')

@section('content')

    <div class="container my-4">
        <h1 class="text-center blueColor py-4">{{ $user->name }} profile</h1>

        <div class="row justify-content-center">
            <div class="col-12">
                <img src="{{ asset('img/undraw_personal_info_0okl.svg') }}" class="img-fluid" title="avatar" />
            </div>
        </div>
    </div>

@endsection
