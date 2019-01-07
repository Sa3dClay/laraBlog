/*jslint browser: true*/
/*global $, jQuery, alert*/

$(function () {
    
    "use strict";
    
    $("body").niceScroll({
        cursorcolor     : "#3498db",
        cursorwidth     : "8px",
        cursoropacitymin: 0.4,
        cursoropacitymax: 0.8
    })
    $("body").mouseover(function () {
        $("body").getNiceScroll().resize();
    });

    $("#like").on('click', function (event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: likeUrl,
            data: {post_id: post_id, _token: token}
        })
            .done(function () {
                
            });
    });
    
});
