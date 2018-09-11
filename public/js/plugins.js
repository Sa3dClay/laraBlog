$(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#like").on('click', function(event) {
        event.preventDefault();

        $.ajax({
            method: 'POST',
            url: likeUrl,
            data: {like: true, postId: postId, '_token': token}
        })
            .done(function() {
                //
            });

    });
 
});
