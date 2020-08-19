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
<<<<<<< HEAD
                    <div class="row text-center mb-3">
                        <div class="col-10">
                            {!! Form::open([
                                'action' => 'PostsController@search',
                                'id' => 'searchPost',
                                'method' => 'POST'
                            ]) !!}

                                {{ Form::text('search', null, [
                                    'type' => 'search',
                                    'class' => 'form-control',
                                    'placeholder' => 'search for a post',
                                    'required'
                                ]) }}
=======
                    {!! Form::open([
                        'action' => 'PostsController@search',
                        'method' => 'GET'
                    ]) !!}

                        <div class="row text-center mb-3">
                            <div class="col-10">
                                <input type="text" name="search" class="form-control" required
                                    placeholder="Search for your own posts by title or category">
>>>>>>> 362a73e612f6fd570bb8dd4153cc4edbfd7773a6

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
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}

                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}

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

@endsection
