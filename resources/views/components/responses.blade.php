@extends('layouts.app')

@section('content')

    @if(Auth::guard('admin')->check())
        <a href="{{ url('/admin/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
    @else
        <a href="{{ url('/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
    @endif

    <button type="button" class="btn btn-primary btn-lg btn-block" disabled style="margin-left:5px">
      {{ $data['feedback']['title'] }}</button>
    <div class="col-md-6">
        <div class="container py-1">
            <div class="post">
                <div class="postBody" >
                    {!! $data['feedback']['message'] !!}
                </div>
                <small class="float-right">
                    Written on {{$data['feedback']['created_at']}}
                </small>
             </div>
         </div>
    </div>
    @foreach($data['responses'] as $response)
        <div class="col-md-6">
            <div class="container py-1">
                <div class="post">
                    <div class="postBody" >
                        {!! $response->message !!}
                    </div>
                    <small class="float-right">
                        Written on {{$response->created_at}} By By <small>$response->admin</small>
                    </small>
                 </div>
             </div>
        </div>
    @endforeach
    @if(Auth::guard('admin')->check())
        {!! Form::open(['action' => 'ResponseController@store', 'method' => 'POST', 'files' => true , 'id' => 'form']) !!}
            {{ csrf_field() }}
            {{print_r($data['responses'])}}
            <div class="form-group">
                {{ Form::label('message', 'Send new response', ['class' => 'control-label']) }}
                {{ Form::textarea('response', null, ['class' => 'form-control', 'id'=>'CKEditor', 'rows'=>'4', 'placeholder' => 'Message', 'required']) }}
                {{ Form::hidden('admin_id', Auth::guard('admin')->user()->id) }}
                {{ Form::hidden('user_id', $data['feedback']['user_id']) }}
                {{ Form::hidden('feedback_id', $data['feedback']['id']) }}
            </div>

            {{ Form::submit('Send', ['id' => 'submit', 'class' => 'btn btn-sm btn-primary']) }}
        {!! Form::close() !!}
    @endif

@endsection

<script>
  // prevent redundant requests
  $(function(){
       $("#submit").click(function (e) {
           $("#submit").attr("disabled", true)
       });
  });
</script>
