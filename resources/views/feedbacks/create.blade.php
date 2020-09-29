@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <a href="{{ url('/home') }}" class="btn btn-success mybtn">Go back</a>

        <h1 class="text-center hpc">Create Post</h1>
        {!! Form::open(['action' => 'FeedbacksController@store', 'method' => 'POST']) !!}
            {{ csrf_field() }}

            <div class="form-group">
                {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required']) }}
            </div>

            <div class="form-group">
                {{ Form::label('message', 'Message', ['class' => 'control-label']) }}
                {{ Form::textarea('message', null, ['class' => 'form-control', 'id'=>'CKEditor', 'rows'=>'4', 'placeholder' => 'message', 'required']) }}
            </div>

            {{ Form::submit('Submit', ['id' => 'submit', 'class' => 'btn btn-sm btn-primary']) }}
        {!! Form::close() !!}
    </div>


<script>
// prevent redundant requests
$(function(){
     $("#submit").click(function (e) {
         $("#submit").attr("disabled", true)
     });
});
</script>

@endsection
