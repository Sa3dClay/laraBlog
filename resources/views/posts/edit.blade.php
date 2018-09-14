@extends('layouts.app')

@section('content')

    <div class="container">
        <a href="/posts/{{$post->id}}" class="btn btn-success mybtn">Go back</a>

        <h1 class="text-center hpc">Edit Post</h1>
        {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'files' => true]) !!}
            {{ csrf_field() }}

            <div class="form-group">
                {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                {{ Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
            </div>

            <div class="form-group">
                {{ Form::label('body', 'Body', ['class' => 'control-label']) }}
                {{ Form::textarea('body', $post->body, ['class' => 'form-control pta', 'placeholder' => 'Body', 'required']) }}
            </div>
            
            <!--
            <div class="form-group">
                {{ Form::label('image', 'Update Image', ['class' => 'control-label']) }}
                {{ Form::file('image') }}
            </div>
            -->

            <?php
            $directory = "uploads/*.*";
            $images = glob($directory);
            ?>

            {{ Form::label('image_select', 'Select Image', ['class' => 'control-label']) }}
            <div class="row justify-content-center imgSelect">
                @foreach($images as $image)
                <?php
                $splName = explode('/', $image);
                $imgName = $splName[1];
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label>
                        {{ Form::radio('image_select', $imgName) }}
                        <img src="/{{ $image }}" class="img-fluid img-thumbnail" />
                    </label>
                </div>
                @endforeach
            </div>

            {{ Form::hidden('_method', 'PUT') }}
            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
        {!! Form::close() !!}
    </div>

@endsection
