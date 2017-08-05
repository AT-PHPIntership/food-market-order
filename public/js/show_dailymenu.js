$(document).ready(function() {
    /**
     *
     * Get Menu Date and Current Date To Check Edit/Delete permission
     */
    var $dateValue = document.getElementById('$menuDate').innerHTML;
    var year = $dateValue.substring(0, 4);
    var month = $dateValue.substring(5, 7);
    var day = $dateValue.substring(8, 10);
    var $date = new Date(year, month - 1, day);
    var $today = new Date();
    $today.setHours(0, 0, 0, 0);

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
                if ($newQuantity != '') {
                    $menuItem.push({
                        'menuId': $menuId,
                        'newQuantity': $newQuantity
                    });
                    callAjax($menuItem, event.target, './editMenuItem', 'POST');
                    $quantityElement.disabled = true;
                } else {
                    alert('Please fill in quantity of this food');
                }
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
            if (confirm("Are you sure you want to delete this item?")) {
                callAjax($menuId, event.target, './deleteMenuItem', 'POST');
            }
        });
    }
});
