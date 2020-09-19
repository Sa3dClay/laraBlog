@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <a href="{{ url('/posts') }}" class="btn btn-success mybtn">Go back</a>

        <div class="post">
            <h2 class="blueColor">{{ $post->title }}</h2>
            <div class="postBody">
                {!! $post->body !!}
            </div>

            @if(isset($post->image_name))
                <div class="post-img">
                    <img src="{{ asset('/uploads' . '/' . $post->image_name) }}" class="img-fluid" />
                    <span class="sp1"></span>
                    <span class="sp2"></span>
                    <span class="sp3"></span>
                    <span class="sp4"></span>
                    <i class="fab fa-staylinked fa-2x"></i>
                </div>
            @endif
            <hr>
            <small class="float-right" >
                Written on {{$post->created_at}} by 

                <b>
                    <a href="{{ url('/profile' . '/' . $post->user->id) }}">{{$post->user->name}}</a>
                </b>
            </small>
            <small class="float-left">  Category: <b> {{$post->category}} </b> </small>
        </div>

        {{-- Admin --}}
        @if(Auth::guard('admin')->check())
            <button
                type="button"
                data-toggle="modal"
                data-target="#hideModal"
                class="btn btn-primary btn-sm my-2 px-4"
            >
                Hide This Post
            </button>

            <!-- str hide modal -->
            <div
                id="hideModal"
                class="modal fade"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
                aria-labelledby="hideModalLabel"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="hideModalLabel">Hide Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">

                            {!! Form::open([
                                'action' => 'AdminController@hidePost',
                                'method' => 'Post'
                            ]) !!}

                                <div class="form-group">
                                    <label class="control-label">hide reason</label>
                                    <input
                                        type="text"
                                        name="hide_reason"
                                        class="form-control"
                                        required
                                    >
                                </div>

                                <input type="hidden" name="post_id" value="{{ $post->id }}">

                                <button type="submit" class="btn btn-danger btn-sm px-4">Hide</button>

                            {!! Form::close() !!}

                        </div>

                    </div>
                </div>
            </div>
            <!-- end hide modal -->
        @endif

        {{-- User --}}
        @if(Auth::guard('user')->check())
            <div class="float-left">

                @if(isset($like))
                    {{-- {!! Form::open(['action' => ['PostsController@dislike', $like->id], 'method' => 'POST']) !!}
                        {{ Form::submit('Dislike', ['class' => 'btn btn-danger']) }}
                    {!! Form::close() !!} --}}

                    <button class="btn btn-sm btn-danger" id="dislike_post_ajax">
                        <i class="far fa-thumbs-down"></i><span class="d-none d-md-inline"> Dislike</span>
                    </button>

                    <button class="hidden btn btn-sm btn-primary" id="like_post_ajax">
                        <i class="far fa-thumbs-up"></i><span class="d-none d-md-inline"> Like</span>
                    </button>

                    <span class="hidden" id="like_id">{{ $like->id }}</span>
                @else
                    {{-- {!! Form::open(['action' => ['PostsController@like', $post->id], 'method' => 'POST' ,'id' => 'form']) !!}
                        {{ Form::submit('Like', ['id' => 'submitLike' ,'class' => 'btn btn-primary']) }}
                    {!! Form::close() !!} --}}

                    <button class="btn btn-sm btn-primary" id="like_post_ajax">
                        <i class="far fa-thumbs-up"></i><span class="d-none d-md-inline"> Like</span>
                    </button>

                    <button class="hidden btn btn-sm btn-danger" id="dislike_post_ajax">
                        <i class="far fa-thumbs-down"></i><span class="d-none d-md-inline"> Dislike</span>
                    </button>

                    <span class="hidden" id="like_id"></span>
                @endif

                @if(isset($likes))
                    @if(count($likes) > 0)
                        <small role="button" class="btn btn-sm" id="count_likes" data-toggle="modal" data-target="#likesModal">
                            <span>{{ count($likes) }}</span> likes this post
                        </small>
                    @else
                        <small role="button" class="btn btn-sm" id="count_likes" data-toggle="modal" data-target="#likesModal">
                            {{-- no likes --}}
                        </small>
                    @endif
                @endif
            </div>

            {{-- STR Likes Modal --}}
            <div class="modal fade" id="likesModal">
                <div class="modal-dialog modal-sm modal-dialog-scrollable modal-dialog-centered">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title blueColor">Who likes this post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body px-2 py-2">
                            <ul id="likers_list" class="list-group list-group-flush">
                                {{-- list placed by js --}}
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            {{-- END Likes Modal --}}

            {{-- STR Comments --}}
            <div class="float-right">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#commentsModal">
                    <i class="far fa-comment"></i><span class="d-none d-md-inline"> Comment</span>
                </button>
            </div>

            {{-- Comments Modal --}}

            <div class="modal fade" id="commentsModal">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                    @include('components.comments')
                </div>
            </div>
            {{-- END Comments --}}

            <div class="clearfix"></div><hr />

            <div class="mar-bot-20">
                @if(auth()->user()->id == $post->user_id)
                    <a href="{{ url('/posts'.'/'.$post->id.'/edit') }}" class="btn btn-success">Edit</a>

                    {{-- Delete Post --}}
                    {!! Form::open([
                        'action' => ['PostsController@destroy', $post->id],
                        'class' => 'float-right',
                        'id' => 'deleteForm',
                        'method' => 'POST',
                    ]) !!}

                        {{ Form::hidden('_method', 'DELETE') }}

                        <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                    {!! Form::close() !!}
                @endif
            </div>
        @endif
    </div>

    {{-- JS --}}

    <script>
        $(function () {
            var post_id = {{ $post->id }}

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            // str like request
            $("#like_post_ajax").on('click', function (event) {
                $("#submit").attr("disabled", true);
                event.preventDefault();
                // console.log(post_id)

                $.ajax({
                    url: "{{ url('/post/like') }}",
                    method: 'post',
                    data: {
                        post_id
                    },
                    success: function(response) {
                        // console.log(response)

                        $('#like_post_ajax').hide()
                        $('#dislike_post_ajax').show()

                        $("#like_id").text(response.like.id)

                        var likes = response.likes
                        if(likes.length > 0) {
                            if (likes.length === 1) {
                                $("#count_likes").text('you likes this post')
                            } else {
                                $("#count_likes").text('you and ' + (likes.length-1) + ' likes this post')
                            }
                        } else {
                            $("#count_likes").text('')
                        }
                    }
                })
            })
            // end like request

            // str dislike request
            $("#dislike_post_ajax").on('click', function (event) {
                event.preventDefault();

                var like_id = $('#like_id').text()
                // console.log(like_id)

                $.ajax({
                    url: "{{ url('/post/dislike') }}",
                    method: 'post',
                    data: {
                        like_id,
                        post_id
                    },
                    success: function(response) {
                        // console.log(response)

                        $('#like_post_ajax').show()
                        $('#dislike_post_ajax').hide()

                        var likes = response.likes
                        if(likes.length > 0) {
                            $("#count_likes").text(likes.length + ' likes this post')
                        } else {
                            $("#count_likes").text('')
                        }
                    }
                })
            })
            // end dislike request

            // str getWhoLike request
            $("#count_likes").on('click', function (event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ url('/post/getWhoLike') }}",
                    method: 'get',
                    data: {
                        post_id
                    },
                    success: (response) => {
                        // console.log(response)
                        var likers = response.likers

                        if(likers && likers.length>0) {
                            $('#likers_list').text('')

                            $.each(likers, (i, liker) => {
                                $('#likers_list').append(`
                                    <li class="list-group-item text-center px-1 py-1">` + liker.user_name + `</li>
                                `)
                            })
                        }
                    },
                    error: (error) => {
                        console.log(error)
                    }
                })
            })
            // end getWhoLike request

            // str delete post
            $("#deleteButton").on('click', function(e) {
                e.preventDefault()

                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {

                        $("#deleteForm").submit()

                    }
                })

            })
            // end delete post
        })

        // string directions based on detected language
        $(function() {
            $('.postBody p').each(function(i, pTag) {
                $this = $(this)
                // console.log($this)

                if( $this.text() ) {
                    const x =  new RegExp("[\x00-\x80]+")
                    // console.log($this.text().charAt(0))

                    var isAscii = x.test($this.text().charAt(0))
                    // console.log(isAscii)

                    if(isAscii)
                    {
                        $this.css("direction", "ltr")
                        $this.css("text-align", "left")
                    }
                    else
                    {
                        $this.css("direction", "rtl")
                        $this.css("text-align", "right")
                    }
                }
            });
        });
    </script>

@endsection
