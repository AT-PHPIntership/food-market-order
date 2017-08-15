$(document).ready(function() {
    var confirm = function (e) {
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
        });
        $('#modal-confirm').on('hidden.bs.modal', function () {
            form.get(0).reset();
        });
    };
    $(".btn-confirm").bind('click',confirm);
    $("#date-sort").blur(function(){
        window.location = '/'+$(this).attr("data-table")+'/?date='+$(this).val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$(this).attr("data-table")+'?keyword='+$(this).val();
    });
    $('.status-order').change(confirm);
});
$('#flash-overlay-modal').modal();
