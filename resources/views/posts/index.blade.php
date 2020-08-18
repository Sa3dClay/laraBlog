@extends('layouts.app')

@section('content')

<a href="" id ="searchButton" class="btn btn-primary mybtn" style="float:right;display:block" role="button" onclick="event.preventDefault();submitSearch();">Search Post
  <span class="searchbox-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
</a>

{!! Form::open(['action' => ['PostsController@search'], 'method' => 'POST' ,'class' => 'searchPost','id' => 'searchPost2']) !!}
  {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Search for a post.....', 'type' => 'search' ]) }}
    {{ Form::hidden('searchField','all') }}
    {{ Form::submit('submit', ['style' => 'display:none','id' => 'formSearch']) }}
{!! Form::close() !!}

    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="row post justify-content-md-center">
                <div class="col-md-6">
                    <h2><a href="{{ url('/posts' . '/' . $post->id) }}">{{$post->title}}</a></h2>
                    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
                </div>

                <div class="col-md-4">
                    @if(isset($post->image_name))
                        <div class="post-img blog-img">
                            <img src="{{ asset('/uploads' . '/' . $post->image_name) }}" class="img-fluid" />
                            <span class="sp1"></span>
                            <span class="sp2"></span>
                            <span class="sp3"></span>
                            <span class="sp4"></span>
                            <i class="fab fa-staylinked fa-2x"></i>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p class="blank">No Posts Found</p>
    @endif

@endsection

{{-- STR JS --}}
<script>
  function submitSearch(){
    document.getElementById('searchPost2').submit();
  }
</script>
{{-- END JS --}}
