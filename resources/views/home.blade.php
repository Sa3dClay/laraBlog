@extends('layouts.app')

@section('content')
<div class="container mar-top-20 mar-bot-20">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/posts/create') }}" class="btn btn-primary mybtn" role="button">Create Post</a>

                    {{-- str search --}}
                    {!! Form::open([
                        'action' => 'PostsController@search',
                        'method' => 'GET'
                    ]) !!}

                        <div class="row text-center mb-3">
                            <div class="col-10">
                                <input type="text" name="search" class="form-control" required
                                    placeholder="Search for your own posts by title or category">

                                {{ Form::hidden('searchField', 'user') }}
                            </div>

                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                    {!! Form::close() !!}
                    {{-- end search --}}

                    @if( isset($posts) && count($posts)>0 )

                        @if(strpos(url()->current(), '/search') !== false)
                            <h3>Search results</h3>
                        @else
                            <h3>Your Blog Posts</h3>
                        @endif

                        <table class="table" id="tableposts">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>

                            @foreach ($posts as $post)
                                <tr>
                                    <td><p>
                                        <a href="{{ url('/posts'. '/' .$post->id) }}">{{ $post->title }}</a>
                                    </p></td>

                                    <td>
                                        <a href="{{ url('/posts'. '/' .$post->id . '/edit') }}"
                                            class="btn btn-sm btn-success">Edit</a>
                                    </td>

                                    <td>
                                        {!! Form::open([
                                            'action' => ['PostsController@destroy', $post->id],
                                            'id' => 'deletePost'.$post->id,
                                            'class' => 'float-right',
                                            'method' => 'POST',
                                        ]) !!}

                                            {{ Form::hidden('_method', 'DELETE') }}

                                            <button type="button" id="{{ $post->id }}"
                                                class="btn btn-sm btn-danger deletePost">Delete</button>

                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                        </table>

                    @else

                        @if( strpos(url()->current(), '/search') )
                            <h3>No search results found</h3>
                        @else
                            <h3>You have no posts yet</h3>
                        @endif

                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

{{-- str js --}}
<script>
    $(function () {
        $('.deletePost').on('click', function(e) {
            e.preventDefault()

            var postId = $(this).attr('id')
            // console.log(postId)

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    // console.log('deletePost'+postId)

                    $('#deletePost'+postId).submit()
                }
            })

        })
    })
</script>
{{-- end js --}}

@endsection
