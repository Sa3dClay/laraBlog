@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="/posts" class="btn btn-success">Go back</a>
        
        <div class="post">
            <h2>{{$post->title}}</h2>
            <p>{!!$post->body!!}</p>
            @if(isset($post->image_name))
                <div class="post-img">
                    <img src="/uploads/{{$post->image_name}}" class="img-fluid" />
                    <span class="sp1"></span>
                    <span class="sp2"></span>
                    <span class="sp3"></span>
                    <span class="sp4"></span>
                    <i class="fab fa-staylinked fa-2x"></i>
                </div>
            @endif
            <hr>
            <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
        </div>
        
        @if(isset(auth()->user()->id))
            @if(auth()->user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>

                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
        @endif
    </div>

@endsection
