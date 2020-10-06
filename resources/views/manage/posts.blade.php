@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card my-4">
            <div class="card-header">
                Manage Posts
            </div>

            <div class="card-body">
                @if(isset($posts) && count($posts) > 0)

                    @foreach($posts as $post)
                        <div class="row post justify-content-md-center">
                            <div class="col-md-6">
                                <h2>{{$post->title}}</h2>
                                <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                            </div>
                            
                            <div class="col-md-4">
                                @if(isset($post->image_name))
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

                            <div class="col-md-12">
                                {!! Form::open([
                                    'action' => ['AdminController@showPost', $post->id],
                                    'method' => 'POST'
                                ]) !!}

                                    <button type="submit" class="btn btn-success btn-sm mt-3 px-4">Show This Post</button>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach

                @else
                    <h2>No Hidden Posts Founded</h2>
                @endif
            </div>
        </div>
    </div>

@endsection
