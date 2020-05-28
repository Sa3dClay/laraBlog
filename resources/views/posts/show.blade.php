@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="{{ url('/posts') }}" class="btn btn-success mybtn">Go back</a>
        
        <div class="post">
            <h2>{{$post->title}}</h2>
            <p>{!!$post->body!!}</p>
            @if(isset($post->image_name))
                <div class="post-img">
                    <img src="{{ asset('/uploads/' . $post->image_name) }}" class="img-fluid" />
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
                    {{-- {!! Form::open(['action' => ['PostsController@unlike', $like->id], 'method' => 'POST']) !!}
                        {{ Form::submit('Dislike', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!} --}}

                    <button class="btn btn-danger" id="unlike_post_ajax">Unlike</button>
                    <button class="hidden btn btn-primary" id="like_post_ajax">Like</button>
                    <span class="hidden" id="like_id">{{ $like->id }}</span>
                @else
                    {{-- {!! Form::open(['action' => ['PostsController@like', $post->id], 'method' => 'POST']) !!}   
                        {{ Form::submit('Like', ['class' => 'btn btn-primary']) }}
                    {!! Form::close() !!} --}}

                    <button class="btn btn-primary" id="like_post_ajax">Like</button>
                    <button class="hidden btn btn-danger" id="unlike_post_ajax">Unlike</button>
                    <span class="hidden" id="like_id"></span>
                @endif

                @if(isset($likes))
                    @if(count($likes) > 0)
                        <small id="count_likes"><span>{{ count($likes) }}</span> like this post</small>
                    @else
                        <small id="count_likes"></small>
                    @endif
                @endif
            </div>

            <div class="float-right">
                <a href="#" class="btn btn-primary" role="button" id="comm"><i class="fas fa-comment"></i> Comment</a>
            </div>

            <div class="clearfix"></div><hr />
            
            <div class="mar-bot-20">
                @if(auth()->user()->id == $post->user_id)
                    <a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a>

                    {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!}
                @endif
            </div>
        @endif
    </div>

    {{-- JS --}}

    <script src="http://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=">
    </script>

    <script>
        $(function () {
            var post_id = {{ $post->id }}

            $("#like_post_ajax").on('click', function (event) {
                event.preventDefault();
                console.log(post_id)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })

                $.ajax({
                    url: "{{ url('/like') }}",
                    method: 'post',
                    data: {
                        post_id
                    },
                    success: function(response) {
                        console.log(response)
                        $('#like_post_ajax').hide()
                        $('#unlike_post_ajax').show()

                        $("#like_id").text(response.like.id)
                        
                        var likes = response.likes
                        if(likes.length > 0) {
                            $("#count_likes").text(likes.length + ' like this post')
                        } else {
                            $("#count_likes").text('')
                        }
                    }
                })
            })

            $("#unlike_post_ajax").on('click', function (event) {
                event.preventDefault();
                
                var like_id = $('#like_id').text()
                console.log(like_id)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })

                $.ajax({
                    url: "{{ url('/unlike') }}",
                    method: 'post',
                    data: {
                        like_id,
                        post_id
                    },
                    success: function(response) {
                        console.log(response)
                        $('#like_post_ajax').show()
                        $('#unlike_post_ajax').hide()

                        var likes = response.likes
                        if(likes.length > 0) {
                            $("#count_likes").text(likes.length + ' like this post')
                        } else {
                            $("#count_likes").text('')
                        }
                    }
                })
            })
        })
    </script>

@endsection
