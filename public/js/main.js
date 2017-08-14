$(document).ready(function() {
    $(".btn-confirm").bind('click',function(e){
        e.preventDefault();
        var form = $(this.form);
        var title = $(".btn-confirm").attr("data-title");
        var content = '<p>'+$(".btn-confirm").attr("data-confirm")+'</p>'
        $('#myModalTitle').html(title);
        $('#myModalBody').html(content);
        $('#myModal').modal('show');
        $("#btnSend").one("click", function(){
            form.submit();
            $('#myModal').modal('hide');
        })
    });
    $("#date-sort").change(function(){
        window.location = '/'+$("#date-sort").attr("data-table")+'/?date='+$("#date-sort").val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$("#text-sort").attr("data-table")+'?keyword='+$("#text-sort").val();
    });
});
$('#flash-overlay-modal').modal();
