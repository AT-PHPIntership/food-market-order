function alertMessage($eventTarget, message) {
    var title = $eventTarget.attr('data-title');
    var body = '<p>'+message+'</p>'
    $('#modal-confirm-title').html(title);
    $('#modal-confirm-body').html(body);
    $('#modal-confirm').modal("show");
    $("#btn-modal-submit").hide();
}

// Call Ajax request with @param:
// $data: data which being send to server
// $eventTarget: get target button was clicked to handle after request
// $url: route
// $method: method request
// @Return: Call handleAjaxResponse if request successes
function callAjax($data, $eventTarget, $url, $method) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: $method,
        url: $url,
        data: $data,
        success: function(data, status) {
            handleAjaxResponse(data, status, $eventTarget);
        },
        error: function(data, status) {
            //display error
            handleAjaxResponse(data, status, $eventTarget);
        }
    });
}
// Handle Ajax response with @param:
// data: response message from server
// status: response status from server
// $eventTarget: get target button was clicked to handle
// @Return: setting something to display
function handleAjaxResponse(data, status, $eventTarget) {
    if ($eventTarget.attr('name') == 'btn-edit') {
        $tdHasError = $eventTarget.parents().eq(2);
        $helpElement = $tdHasError.find('span');
        if (status === "success") {
            alertMessage($eventTarget, data['message']);
            $tdHasError.removeClass('has-error');
            $helpElement.html('');
            //set date for updated_at
            $eventTarget.closest('tr td').prev().html(data[0]['date'].toString().substring(0, 19));
            $('[name=btn-cancel]').hide();
            $('[name=btn-edit]').hide();
        } else if (status === "error") {
            $helpElement.html(JSON.parse(data.responseText).quantity[0]);
            $tdHasError.addClass(' has-error');
        }
    } else if ($eventTarget.attr('name') == 'btn-del') {
        if (status == "success") {
            //delete record in table
            $eventTarget.parents().eq(1).remove();
            alertMessage($eventTarget, data['message']);
            if ($('#daily-menu-table tr').length == 1) {
                window.location.replace('../daily-menus');
            }
        } else {
            alertMessage($eventTarget, data['error']);
        }
    }
}

//for select2
function formatSelectList (option) {
    if (option.loading) return option.text;

    var markup = '<div class="clearfix">' +
    '<div class="col-sm-10">' + option.name + '</div>';

    markup += '</div>';

    return markup;
}

function formatSelection (option) {
    return option.name || option.text;
}
$(document).ready(function() {
    //For dailyMenu
    /**
     *
     * Get Menu Date and Current Date To Check Edit/Delete permission
     */
    if ($('#menu-date').length > 0) {
        var $dateValue = $('#menu-date').html();
        var year = $dateValue.substring(1, 5);
        var month = $dateValue.substring(6, 8);
        var day = $dateValue.substring(9, 11);
        var $date = new Date(year, month - 1, day);
        var $today = new Date();
        $today.setHours(0, 0, 0, 0);
    }
    //get and set event for input quantity and edit - cancel button
    $('[name=btn-cancel]').hide();
    $('[name=btn-edit]').hide();
    var listOldQuantity = []; //save old value
    $quantityElements = $('input[type=number]');
    if ($date < $today) {
        $quantityElements.attr("disabled", true);
    } else {
        $quantityElements.focus(function(ev) {
        listOldQuantity[$(ev.target).prop('id')] = $(ev.target).val();
        }).change(function(e) {
            $btnCancel = $(e.target).parents().eq(1).find('[name=btn-cancel]');
            $btnEdit = $(e.target).parents().eq(1).find('[name=btn-edit]');
            $btnCancel.show();
            $btnEdit.show();
            oldQuantity = listOldQuantity[$(e.target).attr('id')];
            $btnEdit.click(function(edit) {
                let menuItem = [];
                menuId = $(e.target).attr('id');
                newQuantity = $(e.target).val();
                menuItem.push({
                        'menuId': menuId,
                        'quantity': newQuantity
                });
                callAjax(menuItem[0], $(edit.target), './daily-menus', 'PUT');
            })
            $btnCancel.click(function(cancel) {
                $btnEdit.hide();
                $(this).hide();
                $quantityElement = $(this).parents().eq(1).find('input[type=number]');
                $quantityElement.val(oldQuantity);
                $tdHasError = $(event.target).parents().eq(2);
                $tdHasError.removeClass('has-error');
                $tdHasError.find('span').html('');
            })
        });
    }
    /** 
     *
     * Get and set event for Delete button
     */
    var $arrBtnDel = $('[name = btn-del]');
    if ($date < $today) {
        $arrBtnDel.attr('disabled', true); //Disable Delete button if menu date > currentDate
    } else {
        $arrBtnDel.click(function(event) {
            var title = $(this).attr('data-title');
            var body = '<p>'+$(this).attr('data-confirm')+'</p>'
            $('#modal-confirm-title').html(title);
            $('#modal-confirm-body').html(body);
            $('#btn-modal-submit').show();
            $('#modal-confirm').modal("show");
            $('#btn-modal-submit').click(function(e){
                let menuId = $(event.target).val();
                let menu = [];
                menu.push({'menuId': menuId});
                callAjax(menu[0], $(event.target), './daily-menus', 'DELETE');
                $('#modal-confirm').modal('hide');
            })
            $("#modal-confirm").on("hide.bs.modal", function () {
                $('#btn-modal-submit').off('click');
            });
        });
    }
    //For Create DailyMenu
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
    $('#select-category').change(function (e) {
        $('#select-food').empty();
        $url = foodURLs.list_food_by_category;
        $categoryId = e.target.options[e.target.selectedIndex].value;
        $("#select-food").select2({
          placeholder: 'Choose Food',
          theme: "bootstrap",
          ajax: {
            url: $url,
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                name: params.term, // search term
                page: params.page,
                category_id: $categoryId
              };
            },
            processResults: function (data) {
              return {
                results: data.data,
                pagination: {
                  more: (data.current_page<data.last_page)?(true):(false)
                }
              };
            },
            cache: true
          },
          escapeMarkup: function (markup) { return markup; },
          templateResult: formatSelectList,
          templateSelection: formatSelection
        });
    });
    /**
     * Btn Cancel clear data input
     */
     $('#clear-input').click(function (e) {
        $('#select-food').empty();
        $('#create-menu')[0].reset();
     })
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
        $('#modal-confirm').modal("show");
        $('#btn-modal-submit').one("click", function () {
            form.submit();
            $('#modal-confirm').modal("hide");
        });
        $('#modal-confirm').on("hidden.bs.modal", function () {
            form.get(0).reset();
        });
    };
    $('.btn-confirm').bind("click", confirm);
    $('.status-order').change(confirm);
});
$('#flash-overlay-modal').modal();
    