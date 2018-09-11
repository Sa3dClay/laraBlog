@extends('layouts.app')

@section('content')

    @if(count($posts) > 0)
        <div class="container">
            @foreach($posts as $post)
                <div class="post">
                    <h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                </div>
            @endforeach
            {{$posts->links()}}
        </div>
    @else
        <p class="blank">No Posts Found</p>
    @endif

@endsection
