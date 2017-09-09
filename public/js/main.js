/**
 * Get Category and send ajax request to server
 */
function bindEventToSelect() {
    $('.select-category').change(function (e) {
        e.stopPropagation();
        $selectFoodChild = $(e.target).parent().next().children('.select-food');
        $selectFoodChild.empty();
        $url = foodURLs.list_food_by_category;
        $categoryId = e.target.options[e.target.selectedIndex].value;
        $selectFoodChild.select2({
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
}

(function($) {
    $.fn.replaceClass = function (oldClass, newClass) {
        return this.removeClass(oldClass).addClass(newClass);
    };
}(jQuery));

function showModal(title, body) {
    $('#modal-confirm-title').html(title);
    $('#modal-confirm-body').html(body);
    $('#modal-confirm').modal("show");
}

function ajaxRequest(functionHandle, method, urlRequest, dataRequest, $target = null) {
    $.ajax({
       type: method,
       url: urlRequest,
       data: dataRequest,
       success: function(data, status)
       {
            functionHandle($target, data, status);
       },
       error: function(data, status){
            functionHandle($target, data, status);
      }
    });
}

function handleCreateResponse($target, data = null, status = null) {
    if (status === 'success') {
        alertMessage($target, data['message']);
        $("#btn-modal-submit").next().hide();
        $newUrl = dailyMenuURLs.menu_detail_by_date.replace('date', data['date']);
        window.setTimeout(function() {
            window.location = $newUrl;
        }, 1000);
    } else {
        alertMessage($target, $target.attr('data-error'));
        $("#btn-modal-submit").next().hide();
    }
}

function alertMessage($eventTarget, message) {
    var title = $eventTarget.attr('data-title');
    var body = '<p>'+message+'</p>'
    $('#modal-confirm-title').html(title);
    $('#modal-confirm-body').html(body);
    $('#modal-confirm').modal("show");
    $("#btn-modal-submit").hide();
    $("#btn-modal-submit").next().hide();
}

// Handle Ajax response with @param:
// data: response message from server
// status: response status from server
// $eventTarget: get target button was clicked to handle
// @Return: setting something to display
function handleUpdateDelete($eventTarget, data, status) {
    if ($eventTarget.attr('name') == 'btn-edit') {
        $tdHasError = $eventTarget.parents().eq(2);
        $helpElement = $tdHasError.find('span');
        if (status == "success") {
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
            $eventTarget.closest('tr').remove();
            alertMessage($eventTarget, data.message);
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //get standard element to append new row for create daily menu
    $stdRowCreateMenu = $('tbody tr:nth-child(1)').html();
    $('#create-menu-table tr:nth-child(1)').find('.btn-success').hide();
    //Apply select2 for all selects tag
    $('select').select2({theme: "bootstrap"});

    $('.select2').removeAttr('style');
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
                ajaxRequest(handleUpdateDelete, 'PUT', './daily-menus', menuItem[0], $(edit.target));
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
            showModal(title, body);
            $('#btn-modal-submit').show();
            $("#btn-modal-submit").next().show();
            $('#btn-modal-submit').click(function(e){
                let menuId = $(event.target).val();
                let menu = [];
                menu.push({'menuId': menuId});
                ajaxRequest(handleUpdateDelete, 'DELETE', './daily-menus', menu[0], $(event.target));
            })
            $("#modal-confirm").on("hide.bs.modal", function () {
                $('#btn-modal-submit').off('click');
            });
        });
    }
    //For Create DailyMenu
    $('#select-food').empty()
                    .append('<option selected="selected" value="null">'
                        + $('#select-food').attr('placeholder')
                        +'</option>'
                    );
    /**
     * Get Menu Date and Current Date To Check Add item permission
     */
    var $today = new Date();
    $today.setHours(0, 0, 0, 0);
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
    bindEventToSelect();
    /**
     * Btn Cancel clear data input
     */
     $('#clear-input').click(function (e) {
        $('.select-food').empty();
        $('#create-menu')[0].reset();
        $arrTR = $('tbody tr');
        for (var i = 0; i < $arrTR.length - 1; i++) {
            $arrTR[i].remove();
        }
     })

    //btn add new row
    $('#add-row').click(function() {
        if( $('#disable-row').css('display') == 'none' ){
            $curTR = $(this).closest('tr');
            $('tbody').prepend('<tr></tr>');
            $firstElement = $('tbody tr:nth-child(1');
            $firstElement.append($stdRowCreateMenu);
            $firstElement.find('i').replaceClass('glyphicon-plus', 'glyphicon-minus');
            $firstElement.find('#add-row')
                        .replaceClass('btn-primary', 'btn-warning')
                        .click(function() {
                            $(this).closest('tr').remove();
                        });
            $firstElement.find('#disable-row').click(function() {
                $parent = $(this).closest('tr');
                if ($parent.find('.select-food').val() && $parent.find('input').val()) {
                    $parent.find('.select-category, .select-food, input').prop('disabled', true);
                    $(this).hide();
                } else {
                    alertMessage($(this), $(this).attr('data-message'));
                    $("#btn-modal-submit").next().hide();
                }
            })
            bindEventToSelect();   
        } else {
            alertMessage($(this), $(this).attr('data-message'));
            $("#btn-modal-submit").next().hide();
        }
    })
    $('#create-menu').submit(function(e) {
        e.preventDefault();
        $('.select-food, input').prop("disabled", false);
        $url = $(this).attr('action');
        ajaxRequest(handleCreateResponse, "POST", $url, $('#create-menu').serializeArray(), $(e.target));
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
        showModal(title, body);
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

    // Change quantity order
    $('.quantity-order-item').change(function () {

        var price = $(this).parent().parent().find('.priceItem').html();
        var payment = 0;
        var total = $(this).parent().parent().find('.totalItem');
        total.html(Number(this.value * price).toLocaleString('vi'));
        $('tbody tr .totalItem').each(function() {
            payment += Number($(this).html());
        });
        $('#payment-order').html(payment);
    });
    $('#alert-detail-order').hide();
    $('.close').click(function() {
        $('.alert').hide();
    })
    function showArlert(message, status) {
        if (status == "success"){
            $('.alert').replaceClass('alert-danger', 'alert-success');
        } else {
            $('.alert').replaceClass('alert-success', 'alert-danger');
        }
        $('.alert .content-alert').html(message);
        $('.alert').show();
    }

    $('.quantity-order-item').blur(function (e) {
        e.preventDefault();
        var quantityBackUp = $(this).parent().parent().find('.quantity-back-up');
        var quantity = this;
        var title = $(this).attr("data-title");
        var body = '<p>' + $(this).attr("data-confirm") + '</p>';
        var id = $(this).attr("data-id");
        showModal(title, body);
        $('#btn-modal-submit').one("click", function () {
            var data = {"quantity":quantity.value};
            $.ajax({
                type: "PUT",
                url: "/orderitems/"+id,
                data: data,
                success: function(data, status) {
                    if (status == "success") {
                        $(quantityBackUp).val($(quantity).val());
                        showArlert(data["message"],status)
                        $('#modal-confirm').modal("hide");
                    } else {
                        showArlert(data["message"],status)
                        $('#modal-confirm').modal("hide");
                    }
                },
                error: function(data, status) {
                    showArlert(data.responseJSON["message"],status)
                    $('#modal-confirm').modal("hide");
                }
            });

        });
        $('#modal-confirm').on("hidden.bs.modal", function () {
            $('#btn-modal-submit').off("click");
            $(quantity).val($(quantityBackUp).val());
            $(quantity).change();
        });
    });

    // Delete Order Item
    $('.delete-order-item').click(function () {
        var parent = $(this).parent().parent();
        var title = $(this).attr("data-title");
        var body = '<p>' + $(this).attr("data-confirm") + '</p>';
        var id = $(this).attr("data-id");
        showModal(title, body);
        $('#btn-modal-submit').one("click", function () {
            $.ajax({
                type: "DELETE",
                url: "/orderitems/"+id,
                success: function(data, status) {
                    if (status == "success") {
                        parent.remove();
                        $('.quantity-order-item').change();
                        showArlert(data["message"],status);
                        $('#modal-confirm').modal("hide");
                    } else {
                        showArlert(data["message"],status);
                        $('#modal-confirm').modal("hide");
                    }
                },
                error: function(data, status) {
                    showArlert(data.responseJSON["message"],status)
                    $('#modal-confirm').modal("hide");
                }
            });

        });
        $('#modal-confirm').on("hidden.bs.modal", function () {
            $('#btn-modal-submit').off("click");
            $(quantity).val($(quantityBackUp).val());
            $(quantity).change();
        });
    })
});
$('#flash-overlay-modal').modal();