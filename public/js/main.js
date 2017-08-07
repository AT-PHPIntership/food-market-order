$(function () {
    $("#dataTable").DataTable();
});
$(document).ready(function () {
    var $controlBar = document.getElementById('example1_paginate');
    //style for button trans page again
    var els = document.querySelectorAll('.paginate_button');
    for (el of els) {
        el.className += " btn btn-default";
    }
    $controlBar.addEventListener('click', function () {
        //style for button trans page again
        var els = document.querySelectorAll('.paginate_button');
        for (el of els) {
            el.className += " btn btn-default";
        }
    });
});