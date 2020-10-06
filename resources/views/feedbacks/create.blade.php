@extends('layouts.app')

@section('content')

    <div class="container py-4">
        <a href="{{ url('/home') }}" class="btn btn-success mybtn">Go back</a>

        <h1 class="text-center hpc">Create Post</h1>
        
        {!! Form::open(['action' => 'FeedbacksController@store', 'method' => 'POST', 'id' => 'createForm']) !!}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="feedTitle" class="control-label">Title</label>
                <input type="text" name="title" id="feedTitle" class="form-control"
                    placeholder="Title of Feedback" maxlength="20" required>
            </div>

            <div class="form-group">
                <label for="feedMessage" class="control-label">Message</label>
                <textarea name="message" id="feedMessage" rows="4" class="form-control"
                    placeholder="Feedback Message" required></textarea>
            </div>

            <button type="button" id="submitCreate" class="btn btn-sm btn-primary">Create</button>
        {!! Form::close() !!}
    </div>

    {{-- STR JS --}}
    <script>
        // prevent redundant requests
        $(function() {
            $("#submitCreate").click(function (e) {
                e.preventDefault()

                let title = $("#feedTitle").val(),
                    message = $("#feedMessage").val()                
                // console.log(title, message)

                if(!title || !message) {
                    Swal.fire('Please fill all fields!')
                } else {
                    $("#submitCreate").attr("disabled", true)
                    $("#createForm").submit()
                }
            });
        });
    </script>
    {{-- END JS --}}

@endsection
