@extends('layouts.app')

@section('content')

    @if(Auth::guard('admin')->check())
        <a href="{{ url('/admin/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
    @else
        <a href="{{ url('/feedbacks') }}" class="btn btn-success mybtn">Go back</a>
    @endif
    <div class="col-md-12">
        <div class="container-fluid">
            <div class="post">
              <button type="button" class="btn btn-primary btn-lg btn-block" disabled>
                {{ $data['feedback']['title'] }}</button>
              <div class="row">
                  <div class="col-md-6">
                      <div class="container py-1">
                          <div class="post">
                              <div class="col-md-3">
                                  {!! $data['feedback']['message'] !!}
                              </div>
                              <small class="float-right">
                                  Written on {{$data['feedback']['created_at']}}
                              </small>
                          </div>
                      </div>
                   </div>
                   <div class="col-md-6"></div>
              </div>
                @foreach($data['responses'] as $response)
                  <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6 float-right">
                          <div class="container py-1">
                              <div class="post">
                                  <div class="col-md-3">
                                      {!! $response->response !!}
                                  </div>
                                  <small class="float-right">
                                      Written on {{$response->created_at}}
                                  </small>
                               </div>
                           </div>
                      </div>
                  </div>
                 @endforeach
                 @if(Auth::guard('admin')->check())
                     {!! Form::open(['action' => 'ResponseController@store', 'method' => 'POST', 'files' => true , 'id' => 'form']) !!}
                         {{ csrf_field() }}
                         <div class="form-group">
                             {{ Form::textarea('response', null, ['class' => 'form-control', 'id'=>'CKEditor', 'rows'=>'4', 'placeholder' => 'Message', 'required']) }}
                             {{ Form::hidden('admin_id', Auth::guard('admin')->user()->id) }}
                             {{ Form::hidden('user_id', $data['feedback']['user_id']) }}
                             {{ Form::hidden('feedback_id', $data['feedback']['id']) }}
                             {{ Form::submit('Send', ['id' => 'submit', 'class' => 'btn btn-sm btn-primary float-right'])}}
                         </div>
                     {!! Form::close() !!}
                 @endif
                 </div>
           </div>
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
