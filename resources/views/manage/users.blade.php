@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="card my-4">
      <div class="card-header">
        Manage Users
      </div>

      <div class="card-body">

        @if(isset($users) && count($users) > 0)
          <table class="table">
            <thead>
              <th scope="col">#</th>
              <th scope="col">Role</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Block</th>
              <th scope="col">Delete</th>
              <th scope="col">State</th>
            </thead>

            <tbody>

              @foreach($users as $user)
                <tr>
                  <th scope="row">
                    {{ $user->id }}
                  </th>

                  <td>{{ $user->role }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  
                  {{-- block user --}}
                  <td>
                    <button type="submit" class="btn btn-warning btn-sm">
                      <i class="fas fa-ban"></i>
                    </button>
                  </td>
                  
                  {{-- delete user --}}
                  <td>
                    {!! Form::open([
                      'action' => ['AdminController@deleteUser', $user->id],
                      'id' => 'deleteUser'.$user->id,
                      'method' => 'POST'
                    ]) !!}
                      {{ Form::hidden('_method', 'DELETE') }}

                      <button type="button" class="btn btn-danger btn-sm deleteUser" id="{{ $user->id }}">
                        <i class="fas fa-trash"></i>
                      </button>                      
                    {!! Form::close() !!}
                  </td>
                  
                  <td>
                    {{ $user->suspension? 'Blocked' : 'Active' }}
                  </td>
                </tr>
              @endforeach

            </tbody>
          </table>
        @else
          <h2>No Users Founded</h2>
        @endif

      </div>
    </div>
  </div>

  {{-- str js --}}
  <script>
    $(function () {
      $('.deleteUser').on('click', function (e) {
        e.preventDefault()

        var userId = $(this).attr('id')
        console.log(userId)
        
        Swal.fire({
          icon: 'warning',
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete him!'
        }).then((result) => {
          if (result.value) {
            console.log('deleteUser'+userId)
            $('#deleteUser'+userId).submit()
          }
        })

      })
    })
  </script>
  {{-- end js --}}

@endsection
