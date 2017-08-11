$(document).ready(function() {
    $(".btn-confirm-delete").bind('click',function(e){
        var result = confirm($(".btn-confirm-delete").attr("data-confirm"));
        if(result){
            $('form.delete-item').submit();
        } else {
            e.preventDefault();
        }
    });
});
$('#flash-overlay-modal').modal();
