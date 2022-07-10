@extends('layouts.app')

@section('content')

<div class="container my-4">
    <p class="text-center">
        @auth
            @if(auth()->user()->id != $user->id)
                @if(auth()->user()->isFollowing($user))
                    <button id="follow-user" class="btn btn-sm btn-danger mb-2" onclick="followUser()">Unfollow</button>
                @else
                    <button id="follow-user" class="btn btn-sm btn-success mb-2" onclick="followUser()">Follow</button>
                @endif
            @endif
        @endauth

        <span class="blueColor h2 px-2">{{ $user->name }}</span>
    </p>

    <div class="row justify-content-center">
        <div class="col-12">
            <img src="{{ asset('img/undraw_personal_info_0okl.svg') }}" class="img-fluid" title="avatar" />
        </div>
    </div>
</div>

{{-- str js --}}
<script>
    const followUser = () => {
        event.preventDefault;
        console.log("click follow");

        var user_id = "{{ $user->id }}";
        console.log("user_id:", user_id);

        $.ajax({
            type: 'POST',
            url: '/follow',
            data: {
                user_id: user_id
            },
            success: function(data) {
                console.log(data);

                if(data.isFollowing) {
                    $('#follow-user').text('Unfollow');
                    $('#follow-user').attr('class', 'btn btn-sm btn-danger mb-2');
                } else {
                    $('#follow-user').text('Follow');
                    $('#follow-user').attr('class', 'btn btn-sm btn-success mb-2');
                }
            }
        });
    }
</script>
{{-- end js --}}

@endsection