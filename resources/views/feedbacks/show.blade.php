@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @if(Auth::guard('admin')->check())
            <a href="{{ url('/admin/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
        @else
            <a href="{{ url('/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
        @endif
        
        <div class="post">
            <h2 class="blueColor">{{ $feedback->title }}</h2>
            <div class="postBody">
                {!! $feedback->message !!}
            </div>
            <small class="float-right" >
                Written on {{$feedback->created_at}}
            </small>
        </div>
      </div>
@endsection
