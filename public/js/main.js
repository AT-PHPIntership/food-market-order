$(document).ready(function() {
    /**
     *
     * For Delete daily Menu
     */
    if (document.getElementById('$btnDelete')) {
        $btnDelete = document.getElementById('$btnDelete');
        $btnDelete.addEventListener('click', function(e) {
            if (!confirm(e.target.getAttribute('data-confirm'))) {
                e.preventDefault();
            };
        });
    }
    
    $(".btn-confirm-delete").bind('click',function(e){
        var result = confirm($(".btn-confirm-delete").attr("data-confirm"));
        if (result) {
            $('form.delete-item').submit();
        } else {
            e.preventDefault();
        }
    });
    $("#date-sort").change(function(){
        window.location = '/'+$("#date-sort").attr("data-table")+'/?date='+$("#date-sort").val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$("#text-sort").attr("data-table")+'?keyword='+$("#text-sort").val();
    });
    $(".btn-change-status").bind('click',function(e){
        var result = confirm($(".btn-change-status").attr("data-confirm"));
        if(result){
            $('form.confirm-data').submit();
        } else {
            e.preventDefault();
        }
    });
});
$('#flash-overlay-modal').modal();
