$(document).ready(function() {
    /**
     *
     * For Delete daily Menu
     */
    if (document.getElementById('$btnDelete')) {
        $btnDelete = document.getElementById('$btnDelete');
        $btnDelete.addEventListener('click', function(e) {
            let result = confirm(e.target.getAttribute('data-confirm'));
            if (result) {
                $('#deleteMenu').submit();
            } else {
                e.preventDefault();
            };
        });
    }
    
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
    $(".btn-confirm-delete").bind('click',function(e){
        var result = confirm($(".btn-confirm-delete").attr("data-confirm"));
        if (result) {
            $('form.delete-item').submit();
        } else {
            e.preventDefault();
        }
    });
    $("#date-sort").blur(function(){
        window.location = '/'+$(this).attr("data-table")+'/?date='+$(this).val();
    });
    $("#text-sort").change(function(){
        window.location = '/'+$(this).attr("data-table")+'?keyword='+$(this).val();
    });
});
$('#flash-overlay-modal').modal();
