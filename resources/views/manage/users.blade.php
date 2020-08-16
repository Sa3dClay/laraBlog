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
              <th scope="col">Status</th>
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
                    
                    @if($user->banned_until)
                      {{-- User already blocked, so can revoke --}}
                      {!! Form::open([
                        'action' => ['AdminController@revokeUser', $user->id],
                        'method' => 'POST'
                      ]) !!}
                        <button type="submit" class="btn btn-success btn-sm">
                          <i class="fas fa-user-check"></i>
                        </button>
                      {!! Form::close() !!}

                    @else
                      {{-- User already active, so can block --}}
                      <button
                        type="button"
                        class="btn btn-warning btn-sm"
                        data-toggle="modal"
                        data-target="#blockModal{{ $user->id }}"
                      >
                        <i class="fas fa-user-slash"></i>
                      </button>

                      <!-- str block modal -->
                      <div
                        class="modal fade"
                        id="blockModal{{ $user->id }}"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="blockModalLabel"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">

                            <div class="modal-header">
                              <h5 class="modal-title" id="blockModalLabel">Block User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>

                            <div class="modal-body">

                              {!! Form::open([
                                'action' => 'AdminController@blockUser',
                                'method' => 'post'
                              ]) !!}

                                <div class="form-group">
                                  <label class="control-label">block until</label>
                                  <input
                                    type="date"
                                    name="block_until"
                                    class="form-control"
                                    required
                                  >
                                </div>

                                <div class="form-group">
                                  <label class="control-label">block reason</label>
                                  <input
                                    type="text"
                                    name="block_reason"
                                    class="form-control"
                                    required
                                  >
                                </div>

                                <input type="hidden" name="user_id" value="{{ $user->id }}">

                                <button type="submit" class="btn btn-danger">Block</button>

                              {!! Form::close() !!}

                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- end block modal -->
                    @endif

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
                    {{ $user->banned_until? 'Blocked until '.$user->banned_until : 'Active' }}
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
