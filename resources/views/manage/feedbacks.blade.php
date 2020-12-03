@extends('layouts.app')

@section('content')
<div class="container mar-top-20 mar-bot-20">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">Feedbacks</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if( isset($feedbacks) && count($feedbacks)>0 )

                        <h3>All received Feedbacks</h3>

                        <table class="table" id="tableposts">
                            <tr>
                                <th>Title</th>
                                <th>Response</th>
                                <th>Closure</th>
                                <th>Elimination</th>
                            </tr>

                            @foreach ($feedbacks as $feedback)
                                <tr>
                                    <td><p>
                                        <a href="{{ url('/feedbacks'. '/' .$feedback->id) }}">{{ $feedback->title }} </a>
                                        <b>Received from:

                                            <small>
                                                <a href="{{ url('/profile' . '/' . $feedback->user->id) }}">
                                                    {{$feedback->user->name}}
                                                </a>
                                            </small>

                                            @if(\App\Http\Controllers\FeedbacksController::mark_feedback($feedback->id))
                                                <i class="fa fa-check" style="color:green" aria-hidden="true"></i>
                                            @endif
                                    </p></td>

                                    @if($feedback->closed == 0)
                                        <td>
                                            <a href="{{ url('/feedbacks' .'/'. $feedback->id .'/'. $feedback->user_id .'/responses') }}" class="btn btn-sm btn-success">
                                                Respond
                                                <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            can't respond <i class="fa fa-window-close" aria-hidden="true"></i>
                                        </td>
                                    @endif

                                    @if($feedback->closed == 0)
                                        <td>
                                            <a href="{{ url('admin/feedbacks'. '/' .$feedback->id . '/close') }}"
                                                class="btn btn-sm btn-dark">
                                                close
                                                <i class="fas fa-folder"></i>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            closed <i class="fa fa-lock" aria-hidden="true"></i>
                                        </td>
                                    @endif

                                    <td>
                                      {!! Form::open([
                                          'action' => ['FeedbacksController@destroy', $feedback->id],
                                          'class' => 'float-right',
                                          'method' => 'POST',
                                      ]) !!}

                                          {{ csrf_field() }}
                                          {{ Form::hidden('_method', 'DELETE') }}
                                          {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}

                                      {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                        </table>

                    @else
                        <h3>No feedbacks found!.</h3>

                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
