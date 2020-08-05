// NiceScroll
$(function () {
    $("body").niceScroll({
        cursorcolor: "#3498db",
        cursorwidth: "8px",
        cursoropacitymin: 0.4,
        cursoropacitymax: 0.8
    })
    $("body").mouseover(function () {
        $("body").getNiceScroll().resize();
    });
});

// import Vue from 'vue'

// import VueRouter from 'vue-router'
// Vue.use(VueRouter)

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });
