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

                    <a href="{{ url('/feedbacks/create') }}" class="btn btn-primary mybtn" role="button">Send new Feedback</a>

                    @if( isset($feedbacks) && count($feedbacks)>0 )

                        <h3>Your Sent Feedbacks</h3>

                        <table class="table" id="tableposts">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>

                            @foreach ($feedbacks as $feedback)
                                <tr>
                                    <td><p>
                                        <a href="{{ url('/feedbacks/'. $feedback->id  .'/'. auth()->user()->id .'/responses') }}">{{ $feedback->title }}</a>
                                    </p></td>

                                    <td>
                                    </td>

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
                        <h3>You have no feedbacks sent yet.</h3>

                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
