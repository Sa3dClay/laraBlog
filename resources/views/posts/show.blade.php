@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="/posts" class="btn btn-success mybtn">Go back</a>
        
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
            <div class="float-left">
                <a href="#" class="btn btn-primary" id="like"><i class="fas fa-thumbs-up"></i> Like</a>
                
                <a href="#" class="btn btn-primary" id="dislike"><i class="fas fa-thumbs-down"></i> Dislike</a>
                <small>Number of likes</small>
            </div>
            <div class="float-right">
                <a href="#" class="btn btn-primary" role="button" id="comm"><i class="fas fa-comment"></i> Comment</a>
            </div>
            <div class="clearfix"></div>
            <hr />
            @if(auth()->user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>

                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
        @endif
    </div>

    <script>
        var token   = '{{ Session::token() }}';
        var likeUrl = '{{ route('like') }}';
        var postId  = '{{ $post->id }}';
    </script>

@endsection
