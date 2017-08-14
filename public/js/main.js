$(document).ready(function() {
    $(".btn-confirm").bind('click',function(e){
        e.preventDefault();
        var form = $(this.form);
        var title = $(this).attr("data-title");
        var body = '<p>'+$(this).attr("data-confirm")+'</p>'
        $('#modal-confirm-title').html(title);
        $('#modal-confirm-body').html(body);
        $('#modal-confirm').modal('show');
        $("#btn-modal-submit").one("click", function(){
            form.submit();
            $('#modal-confirm').modal('hide');
        })
    });
    $("#date-sort").blur(function(){
        window.location = '/'+$("#date-sort").attr("data-table")+'/?date='+$("#date-sort").val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$("#text-sort").attr("data-table")+'?keyword='+$("#text-sort").val();
    });
});
$('#flash-overlay-modal').modal();
