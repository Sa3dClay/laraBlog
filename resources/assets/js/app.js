document.getElementById("app").style.minHeight =
  window.outerHeight - 116 + "px";
// setup ajax
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});
