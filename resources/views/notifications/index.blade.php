@extends('layouts.app')

@section('content')
      <div class="jumbotron my-4 py-4 text-center">
        @if(count($notifications) > 0)
            <table class="table">
          <h2>Notifications</h2>
                @foreach ($notifications as $notification)
                    <tr>
                       <td class="float-left"><li>{{$notification->message}}</li></td>
                        <td class="float-right">{{$notification->created_at}}</td>
                    </tr>
                @endforeach
          @else
              <h3>No actions occurred</h3>
          @endif
      </div>
@endsection
