@extends('layouts.app')

@section('content')
<div class="container mar-top-20 mar-bot-20">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a href="{{ url('/posts/create') }}" class="btn btn-primary mybtn" role="button">Create Post</a>
                    
                    @if(count($posts) > 0)
                        <h3>Your Blog Posts</h3>
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td><p><a href="{{ url('/posts'. '/' .$post->id) }}">{{$post->title}}</a></p></td>
                                    <td><a href="{{ url('/posts'. '/' .$post->id . '/edit') }}" class="btn btn-sm btn-success">Edit</a></td>
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
                        <h3>You have no posts yet</h3>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
