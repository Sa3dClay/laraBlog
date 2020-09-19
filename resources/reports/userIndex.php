@extends('layouts.app')

@section('content')
<div class="container mar-top-20 mar-bot-20">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/report/create') }}" class="btn btn-primary mybtn" role="button">Send Report/FeedBack</a>

                    @if( isset($reports) && count($reports)>0 )

                      
                    @else
                      <h3>No previous reports found</h3>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
