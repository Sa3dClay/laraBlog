@extends('layouts.app')

@section('content')

  <div>
    <h2>Users</h2>
    
    @if(isset($users) && count($users) > 0)
      @foreach($users as $user)
        <p>{{ $user->name }}</p>
      @endforeach
    @else
      <h2>No Users Founded</h2>
    @endif
  </div>

@endsection
