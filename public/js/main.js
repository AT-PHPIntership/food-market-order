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
        success: function (data) {
            data['data'].forEach(function (foodElement) {
                //create food select
                let $foodOption = $("<option>", {"text": foodElement['name'], "value": foodElement['id']});
                $("#select-food").append($foodOption);
            })
        }
    });
}

$(document).ready(function () {
    //For Create DailyMenu
    //value to get page in selectbox
    var $i = 1;
    $("#select-food").hide();
    $("#choose-food").click(function () {
        $("#select-food").toggle();
    })
    $("#select-food").change(function (e) {
        $("#select-food").toggle();
        $("#choose-food").html($("#select-food option:selected").text());
    });
    //add event for scroll in select box
    $("#select-food").scroll(function () {
        if ($(this)[0].scrollHeight - $(this).scrollTop() <= $(this).outerHeight()) {
            $i += 1;
            //set url of pagination
            $currentUrl = window.location.href;
            if ($currentUrl.indexOf('date') > 0) {
                $url = $currentUrl.substr(0, $currentUrl.length - 16);
            } else {
                $url = $currentUrl;
            }
            $url = $url + "?page=" + $i;
            $categoryId = $('#select-category').find(":selected").val();
            callAjaxForCreateMenu($url, $categoryId);
        }
    });

    /**
     * Get Menu Date and Current Date To Check Add item permission
     */
    var $today = new Date();
    $('#chooser-date').change(function (e) {
        $dateValue = $('#chooser-date').val();
        var year = $dateValue.substring(0, 4);
        var month = $dateValue.substring(5, 7);
        var day = $dateValue.substring(8, 10);
        var $date = new Date(year, month - 1, day);
        if ($date < $today) {
            $('#add-row').prop("disabled", true);
        } else {
            $('#add-row').prop("disabled", false);
        }
    })
    /**
     * Get Category and send ajax request to server
     */
    $selectCate = document.getElementById('select-category');
    $('#select-category').change(function (e) {
        //set page of paginate = 1
        $i = 1;
        $('#select-food').empty();
        $('#choose-food').html($('#choose-food').attr('data-text'));
        if (window.location.href.indexOf('create') > 0) {
            $url = window.location.href;
        } else {
            $url = window.location.href + "/create";
        }
        $categoryId = e.target.options[e.target.selectedIndex].value;
        callAjaxForCreateMenu($url, $categoryId);
    });
    //End for create dailyMenu

    /**
     * Confirm modal general use
     */
    var confirm = function (e) {
        e.preventDefault();
        var form = $(this.form);
        var title = $(this).attr("data-title");
        var body = '<p>' + $(this).attr("data-confirm") + '</p>'
        $('#modal-confirm-title').html(title);
        $('#modal-confirm-body').html(body);
        $('#modal-confirm').modal('show');
        $("#btn-modal-submit").one("click", function () {
            form.submit();
            $('#modal-confirm').modal('hide');
        });
        $('#modal-confirm').on('hidden.bs.modal', function () {
            form.get(0).reset();
        });
    };
    $(".btn-confirm").bind('click', confirm);
    $("#date-sort").blur(function () {
        window.location = '/' + $(this).attr("data-table") + '/?date=' + $(this).val();
    });
    $("#text-sort").change(function () {
        window.location = '/' + $(this).attr("data-table") + '?keyword=' + $(this).val();
    });
    $('.status-order').change(confirm);
});
$('#flash-overlay-modal').modal();
