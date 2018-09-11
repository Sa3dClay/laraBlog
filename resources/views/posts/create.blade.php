@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="text-center hpc">Create Post</h1>
        {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'files' => true]) !!}
            {{ csrf_field() }}
            <div class="form-group">
                {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('body', 'Body', ['class' => 'control-label']) }}
                {{ Form::textarea('body', null, ['class' => 'form-control pta', 'placeholder' => 'Body', 'required']) }}
            </div>
            <div class="form-group">
                {{ Form::label('image', 'Image', ['class' => 'control-label']) }}
                {{ Form::file('image') }}
            </div>
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    </div>

@endsection
