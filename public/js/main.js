function callAjaxForCreateMenu($url, $categoryId) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            type: "GET",
            url: $url,
            data: {
                category_id: $categoryId
            },
            success: function(data) {
                data['data'].forEach(function(foodElement) {
                    //create food select
                    let $foodOption = $("<option>", {"text": foodElement['name'], "value": foodElement['id']});
                    $("#foodselect").append($foodOption);
                })
            }
        });
}
$(document).ready(function() {
    //For Create DailyMenu
    //value to get page in selectbox
    var $i = 1;
    $("#foodselect").hide();
    $("#choosefood").click(function() {
        $("#foodselect").toggle();
    })
    $("#foodselect").change(function(e) {
        $("#foodselect").toggle();
        $("#choosefood").html($("#foodselect option:selected").text());
    });
    //add event for scroll in select box
    $("#foodselect").scroll(function (){
        if ($(this)[0].scrollHeight - $(this).scrollTop() <=  $(this).outerHeight()) {
            $i += 1;
            //set url of pagination
            $currentUrl = window.location.href;
            if($currentUrl.indexOf('date')>0) {
                $url = $currentUrl.substr(0, $currentUrl.length - 16);
            } else {
                $url = $currentUrl;
            }
            $url = $url+"?page="+$i;
            $categoryId = $('#categoryselect').find(":selected").val();
            callAjaxForCreateMenu($url, $categoryId);
        }
    });

    /**
     * Get Menu Date and Current Date To Check Add item permission
     */
    var $today = new Date();
    $('#dateChooser').change(function(e) {
        $dateValue = $('#dateChooser').val();
        var year = $dateValue.substring(0, 4);
        var month = $dateValue.substring(5, 7);
        var day = $dateValue.substring(8, 10);
        var $date = new Date(year, month - 1, day);
        if ($date < $today) {
            $('#add_row').prop("disabled", true);
        } else {
            $('#add_row').prop("disabled", false);
        }
    })
    /**
     * Get Category and send ajax request to server
     */
    $selectCate = document.getElementById('categoryselect');
    $('#categoryselect').change(function(e) {
        //set page of paginate = 1
        $i = 1;
        $('#foodselect').empty();
        $('#choosefood').html($('#choosefood').attr('data-text'));
        if (window.location.href.indexOf('create')>0) {
            $url = window.location.href;
        } else {
            $url = window.location.href+"/create";
        }
        $categoryId = e.target.options[e.target.selectedIndex].value;
        callAjaxForCreateMenu($url, $categoryId);
    });
    //End for create dailyMenu
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
