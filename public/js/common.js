$(document).ready(function() {
    $(".btn-delete-item").bind('click',function(){
        var result = confirm($(".btn-delete-item").attr("data-content"));
        if(result){
            $('form.delete-item').submit();
        }
    });
});
