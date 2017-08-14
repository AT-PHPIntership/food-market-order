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
    if ($eventTarget.name == "btnConfirm") {
        $tdHasError = $eventTarget.parentNode.previousSibling.previousSibling;
        $helpElement = $tdHasError.childNodes[1];
        if (status == "success") {
            alert(data['message']);
            //remove helpblock if exists
            $tdHasError.className -= " has-error";
            $helpElement.childNodes[1].disabled = true;
            $helpElement.childNodes[3].innerHTML = '';
            $eventTarget.innerHTML = "";
            $eventTarget.name = "btnEdit";
            //set date for updated_at
            $eventTarget.parentNode.previousSibling.
                                    previousSibling.
                                    previousSibling.
                                    previousSibling.
                                    innerHTML = data[0]['date'].toString().substring(0, 19);
            $("[name=btnCancel]").remove();
        } else if (status == "error") {
            $helpElement.childNodes[3].innerHTML = JSON.parse(data.responseText).quantity[0];
            $tdHasError.className += " has-error"
        }
        $eventTarget.nextSibling.nextSibling.style.display = 'inline';
    } else if ($eventTarget.name == "btnDel") {
        if (status == "success") {
            //delete record in table
            $eventTarget.parentNode.parentNode.remove();
            if ($('#bodyTable tr').length == 0) {
                window.location.replace('../daily-menus');
            }
            alert(data['message']);
        } else {
            alert(data['error']);
        }
    }
}

$(document).ready(function() {
    //For dailyMenu
    /**
     *
     * Get Menu Date and Current Date To Check Edit/Delete permission
     */
    if ($('#menuDate')) {
        var $dateValue = $('#menuDate').html();
        var year = $dateValue.substring(1, 5);
        var month = $dateValue.substring(6, 8);
        var day = $dateValue.substring(9, 11);
        var $date = new Date(year, month - 1, day);
        var $today = new Date();
        $today.setHours(0, 0, 0, 0);
    }
    
    /**
     *
     * Get and set event for Edit button
     */
    $arrBtnEdit = $("[name = btnEdit]");
    if ($date < $today) {
        $arrBtnEdit.attr("disabled", true) //Disable edit button if menu date > currentDate
    } else {
        $arrBtnEdit.click(function(event) {
            event.preventDefault();
            let $menuItem = [];
            let menuId = event.target.value;
            let $newQuantity;
            let $quantityElement = $('#'+menuId);
            /**
             * Check state and trans state Edit - Confirm
             */
            if (event.target.name == "btnEdit") {
                oldQuantity = $quantityElement.val();
                $quantityElement.attr('disabled', false);
                $quantityElement.focus();
                event.target.innerHTML = "Confirm";
                event.target.name = "btnConfirm";
                event.target.nextSibling.nextSibling.style.display = 'none';
                //add button Cancel
                $('<button name="btnCancel" class="btn-xs btn-warning btn glyphicon glyphicon-edit">Cancel</button>')
                    .appendTo(event.target.parentNode);
                $("[name=btnCancel]").click(function(e) {
                    event.target.name = "btnEdit";
                    event.target.innerHTML = "";
                    e.target.remove();
                    $quantityElement.attr('disabled', true);
                    event.target.nextSibling.nextSibling.style.display = 'inline';
                    $quantityElement.val(oldQuantity);
                    $tdHasError = event.target.parentNode.previousSibling.previousSibling;
                    $helpElement = $tdHasError.childNodes[1];
                    $helpElement.childNodes[3].innerHTML = '';
                    $tdHasError.className -= "has-error";
                })
            } else if (event.target.name == "btnConfirm") {
                $newQuantity = $quantityElement.val();
                $menuItem.push({
                        'menuId': menuId,
                        'quantity': $newQuantity
                    });
                callAjax($menuItem[0], event.target, './daily-menus', 'PUT');
            }
        });
    }
    /** 
     *
     * Get and set event for Delete button
     */
    var $arrBtnDel = $("[name = btnDel]");
    if ($date < $today) {
        $arrBtnDel.attr('disabled', true); //Disable Delete button if menu date > currentDate
    } else {
        $arrBtnDel.click(function(event) {
            event.preventDefault();
            let $menuId = event.target.value;
            let $menu = [];
            $menu.push({'menuId': $menuId});
            if (confirm(event.target.getAttribute('data-confirm'))) {
                callAjax($menu[0], event.target, './daily-menus', 'DELETE');
            }
        });
    }
    //End for dailyMenu
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
