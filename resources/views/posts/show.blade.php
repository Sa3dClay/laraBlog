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
                @if(isset($like))
                    {!! Form::open(['action' => ['PostsController@unlike', $like->id], 'method' => 'POST']) !!}
                        {{ Form::submit('Dislike', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['action' => ['PostsController@like', $post->id], 'method' => 'POST']) !!}   
                        {{ Form::submit('Like', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!}
                @endif

                @if(isset($likes))
                    <small>{{ count($likes) }} like this post</small>
                @endif
            </div>

            <div class="float-right">
                <a href="#" class="btn btn-primary" role="button" id="comm"><i class="fas fa-comment"></i> Comment</a>
            </div>

            <div class="clearfix"></div><hr />
            
            
            @if(auth()->user()->id == $post->user_id)
                <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>

                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                {!! Form::close() !!}
            @endif
        @endif
    </div>

    {{-- <script>
        var token   = '{{ Session::token() }}';
        var likeUrl = '{{ route('like') }}';
        var post_id = '{{ $post->id }}';
        console.log(token + " " + likeUrl + " " + post_id);
    </script> --}}

@endsection
