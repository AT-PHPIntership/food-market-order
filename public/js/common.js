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
        } else if (status == "error") {
            $helpElement.childNodes[3].innerHTML = JSON.parse(data.responseText).quantity[0];
            $tdHasError.className += " has-error"
        }
    } else if ($eventTarget.name == "btnDel") {
        if (status == "success") {
            //delete record in table
            $eventTarget.parentNode.parentNode.remove();
            $bodyTable = document.getElementById('bodyTable');
            $rowsElement = $bodyTable.getElementsByTagName('tr');
            //check if it has not any record
            if ($rowsElement.length == 0) {
                window.location.replace('../daily-menus');
            }
            alert(data['message']);
        } else {
            alert(data['error']);
        }
    }
}

window.onload = function() {
    /**
     *
     * Get Menu Date and Current Date To Check Edit/Delete permission
     */
    if (document.getElementById('$menuDate')) {
        var $dateValue = document.getElementById('$menuDate').innerHTML;
        var year = $dateValue.substring(0, 4);
        var month = $dateValue.substring(5, 7);
        var day = $dateValue.substring(8, 10);
        var $date = new Date(year, month - 1, day);
        var $today = new Date();
        $today.setHours(0, 0, 0, 0);
    }
    
    /**
     *
     * Get and set event for Edit button
     */
    var $arrBtnEdit = document.getElementsByName('btnEdit');
    for (i = 0; i < $arrBtnEdit.length; i++) {
        if ($date < $today) {
            $arrBtnEdit[i].disabled = true; //Disable edit button if menu date > currentDate
            continue;
        }
        //Set event for Edit button
        $arrBtnEdit[i].addEventListener("click", function(event) {
            event.preventDefault();
            let $menuItem = [];
            let $menuId = event.target.value;
            let $newQuantity;
            let $quantityElement = document.getElementById($menuId);
            /**
             * Check state and trans state Edit - Confirm
             */
            if (event.target.name == "btnEdit") {
                $quantityElement.disabled = false;
                $quantityElement.focus();
                event.target.innerHTML = "Confirm";
                event.target.name = "btnConfirm";
            } else if (event.target.name == "btnConfirm") {
                $newQuantity = $quantityElement.value;
                $menuItem.push({
                        'menuId': $menuId,
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
    var $arrBtnDel = document.getElementsByName('btnDel');
    for (i = 0; i < $arrBtnDel.length; i++) {
        if ($date < $today) {
            $arrBtnDel[i].disabled = true; //Disable Delete button if menu date > currentDate
            continue;
        }
        $arrBtnDel[i].addEventListener('click', function(event) {
            event.preventDefault();
            let $menuId = event.target.value;
            let $menu = [];
            $menu.push({'menuId': $menuId});
            if (confirm(event.target.getAttribute('data-confirm'))) {
                callAjax($menu[0], event.target, './daily-menus', 'DELETE');
            }
        });
    }
}
