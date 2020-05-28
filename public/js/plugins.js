$(function () {
    $("body").niceScroll({
        cursorcolor     : "#3498db",
        cursorwidth     : "8px",
        cursoropacitymin: 0.4,
        cursoropacitymax: 0.8
    })
    $("body").mouseover(function () {
        $("body").getNiceScroll().resize();
    });
});
