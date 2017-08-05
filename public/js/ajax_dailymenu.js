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
        data: {
            data: $data
        },
        success: function(data) {
            handleAjaxResponse(data, $eventTarget);
        }
    });
}

// Handle Ajax response with @param:
// data: response message from server
// $eventTarget: get target button was clicked to handle
// @Return: setting something to display
function handleAjaxResponse(data, $eventTarget) {
    if ($eventTarget.name == "btnConfirm") {
        if (data['status'] == 1) {
            alert('Update Menu Item Success');
            $eventTarget.innerHTML = "";
            $eventTarget.name = "btnEdit";
            $eventTarget.parentNode.previousSibling.
                                    previousSibling.
                                    previousSibling.
                                    previousSibling.
                                    innerHTML = data['updated_at']['date'].toString().substring(0, 19);
        } else {
            alert(data);
        }
    } else if ($eventTarget.name == "btnDel") {
        if (data == 1) {
            //delete record in table
            $eventTarget.parentNode.parentNode.remove();
            $bodyTable = document.getElementById('bodyTable');
            $rowsElement = $bodyTable.getElementsByTagName('tr');
            //check if it has not any record
            if ($rowsElement.length == 0) {
                window.location.replace('../daily-menus');
            }
            alert('Delete Menu Item Success');
        } else {
            alert(data);
        }
    }
}
