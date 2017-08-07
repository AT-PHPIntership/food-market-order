$(document).ready(function() {
    $(".btn-delete-item").bind('click',function(){
        var result = confirm("Are you sure you want to delete?");
        if(result){
            $('form.delete-item').submit();
        }
    });
});
