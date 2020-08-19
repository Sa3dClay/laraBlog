@extends('layouts.app')

@section('content')

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12">

                {{-- str search --}}
<<<<<<< HEAD
                <div class="row text-center">
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

                    <div class="row text-center">
                        <div class="col-10">
                            <input type="text" name="search" class="form-control" required
                                placeholder="Search for a post by title, category or author-name">
>>>>>>> 362a73e612f6fd570bb8dd4153cc4edbfd7773a6

                            {{ Form::hidden('searchField', 'all') }}
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

                    @foreach($posts as $post)
                        <div class="row post justify-content-md-center">
                            <div class="col-md-6">
                                <h2><a href="{{ url('/posts' . '/' . $post->id) }}">{{ $post->title }}</a></h2>
                                <small>Written on {{ $post->created_at }} by {{ $post->user->name }}</small>
                            </div>

                            <div class="col-md-4">

                                @if( isset($post->image_name) )
                                    <div class="post-img blog-img">
                                        <img src="{{ asset('/uploads' . '/' . $post->image_name) }}" class="img-fluid" />
                                        <span class="sp1"></span>
                                        <span class="sp2"></span>
                                        <span class="sp3"></span>
                                        <span class="sp4"></span>
                                        <i class="fab fa-staylinked fa-2x"></i>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endforeach

                    {{ $posts->links() }}

                @else
                    <p class="blank">No Posts Found</p>
                @endif

            </div>
        </div>
    </div>

@endsection
