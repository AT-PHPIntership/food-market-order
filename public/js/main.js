$(document).ready(function() {
    $(".btn-confirm-delete").bind('click',function(){
        var result = confirm($(".btn-confirm-delete").attr("data-confirm"));
        if(result){
            $('form.delete-item').submit();
        }
    });
    $("#date-sort").change(function(){
        window.location = '/'+$("#date-sort").attr("data-table")+'/?date='+$("date-sort").val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$("#text-sort").attr("data-table")+'?key='+$("#text-sort").val();
    });
});
