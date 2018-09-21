$(function(){

    $("body").niceScroll({
        cursorcolor     : "#3498db",
        cursorwidth     : "8px",
        cursoropacitymin: 0.4,
        cursoropacitymax: 0.8
    });

    $("#like").on('click', function(event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: likeUrl,
            data: {postId: postId, _token: token}
        })
            .done(function() {
                console.log('done');
            });        
    });
    
});
