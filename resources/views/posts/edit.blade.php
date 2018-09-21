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
            
            <a class="btn btn-success" data-toggle="collapse" href="#upload" role="button" aria-expanded="false" aria-controls="upload">
                    Upload Image
                </a>
                <a class="btn btn-danger" data-toggle="collapse" href="#select" role="button" aria-expanded="false" aria-controls="select">
                    Select Image
                </a>
    
                <div class="form-group collapse" id="upload">
                    <div class="custom-file ">
                        <p>Upload your image</p>
                        {{ Form::file('image') }}
                        <i class="fas fa-upload fa-2x"></i>
                    </div>
                    <small>Note: If you uploaded an image then selected an image, the selected image will be discarded</small>
                </div>
    
                <?php
                $directory = "uploads/*.*";
                $images = glob($directory);
                ?>
    
                <div class="row justify-content-center imgSelect collapse" id="select">
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
