
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.moment = require('moment');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('doughnut-chart', require('./components/ChartComponent.vue').default);
Vue.component('line-chart', require('./components/MultiChartComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

window.moment = window.moment;

$(function () {
    $.noConflict();
    setTimeout( function () {

        var value_from = $('#datepicker_start').val() ? $('#datepicker_start').val() : moment().format('Y-MM-DD');
        var value_to = $('#datepicker_end').val() ? $('#datepicker_end').val() : moment().format('Y-MM-DD');

        $('#datepicker_start').datepicker({
            format: 'yyyy-mm-dd',
            showOnFocus: true,
            keyboardNavigation: true,
            value: value_from,
            change: function (event) {
                value_to = event.date;
            },
            close: function (event) {
                value_to = event.date;
            }
        });

        $('#datepicker_end').datepicker({
            format: 'yyyy-mm-dd',
            showOnFocus: true,
            keyboardNavigation: true,
            value: value_to,
            change: function (event) {
                value_to = event.date;
            },
            close: function (event) {
                value_to = event.date;
            }
        });

        $('#generateReport').click(function () {
            console.log("generate report");
            window.open('report?store='+ $('#storeSelect').val()+'&from='+ moment(value_from).format('Y-MM-DD')+'&to='+ moment(value_to).format('Y-MM-DD'), '_blank');
        });

        $('#storeSelect').dropdown();

        // Graph buttons

        window.dialog = $("#dialog").dialog({
            resizable: true,
            uiLibrary: 'materialdesign',
            modal: true,
            autoOpen: false
        });

        window.dialog2 = $("#dialog2").dialog({
            resizable: true,
            uiLibrary: 'materialdesign',
            modal: true,
            autoOpen: false
        });

        $('#inter_chart').on('click', function(){
            dialog.open();
        });

        $('#level_chart').on('click', function(){
            dialog2.open();
        });

    }, 1200);

});
