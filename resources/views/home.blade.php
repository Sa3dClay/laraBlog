@extends('layouts.app')

@section('content')
<div class="container mar-top-20 mar-bot-20">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/posts/create') }}" class="btn btn-primary mybtn" role="button">Create Post</a>

                    <a href="" class="btn btn-primary mybtn" style="float:right;display:block" role="button" onclick="event.preventDefault();submitSearch();">Search Post
                      <span class="searchbox-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    </a>

                    {!! Form::open(['action' => ['PostsController@search'], 'method' => 'POST' ,'id' => 'searchPost']) !!}
                      {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search for a post.....', 'type' => 'search']) }}
                        {{ Form::hidden('searchField','user') }}
                        {{ Form::submit('submit', ['style' => 'display:none','id' => 'formSearch']) }}
                    {!! Form::close() !!}

                    @if(count($posts) > 0)
                        @if(strpos(url()->current() , '/search') !== false)
                            <h3>Search results</h3>
                        @else
                            <h3>Your Blog Posts</h3>
                        @endif
                        <table class="table" id = "tableposts">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td><p><a href="{{ url('/posts'. '/' .$post->id) }}">{{$post->title}}</a></p></td>
                                    <td><a href="{{ url('/posts'. '/' .$post->id . '/edit') }}" class="btn btn-sm btn-success">Edit</a></td>
                                    <td>
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @elseif(strpos(url()->current() , '/search') !== false)
                        <h3>No search results found</h3>
                    @else
                        <h3>You have no posts yet</h3>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- STR JS --}}
<script>
  function submitSearch(){
    document.getElementById('searchPost').submit();
  }
</script>

{{--COMMENT
<script>
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $(document).ready(
          $.ajax({
              url: "{{ url('post/search') }}",
              method: 'post',
              success: (response) => {
                  console.log(response);
                  var new_content = "<tr>
                                        <th>Title</th>
                                        <th></th>
                                        <th></th>
                                     </tr>";
                  response.posts.forEach(reload);
                  function reload(post){
                    var href1 = "{{ url('/posts/." + post['id'] + ".)}}" ;
                    var href2 = "{{ url('/posts/." + post['id'] + './edit)}}';
                    new_content +=
                    "<tr>
                        <td><p><a href=" + href1 + ">" + post['title'] + "</a></p></td>
                        <td><a href=" + href2 + ' class="btn btn-sm btn-success">Edit</a></td>
                        <td>'+
                            "{!! Form::open(['action' => ['PostsController@destroy',"+ post['id'] + "], 'method' => 'POST', 'class' => 'float-right']) !!}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-sm btn-danger']) }}
                            {!! Form::close() !!}
                        </td>
                    </tr>";
                  }
                  $('#tableposts').html(new_content);
              },
              error: (error)=>{
                  console.log(error);
              }
          });
      );
  });
</script>
--}}
{{-- END JS --}}
