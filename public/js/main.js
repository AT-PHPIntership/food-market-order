$(document).ready(function() {
    $(".btn-confirm-delete").bind('click',function(){
        var result = confirm($(".btn-confirm-delete").attr("data-confirm"));
        if(result){
            $('form.delete-item').submit();
        }
    });
});
$('#flash-overlay-modal').modal();