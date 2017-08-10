window.onload = function() {
    /**
     * Get Menu Date and Current Date To Check Add item permission
     */
    $selectDate = document.getElementById('dateChooser');
    var $today = new Date();
    $selectDate.addEventListener('change', function(e) {
        $dateValue = $selectDate.value;
        var year = $dateValue.substring(0, 4);
        var month = $dateValue.substring(5, 7);
        var day = $dateValue.substring(8, 10);
        var $date = new Date(year, month - 1, day);
        if ($date < $today) {
            document.getElementById('add_row').disabled = true;
        } else {
            document.getElementById('add_row').disabled = false;
        }
    });
    /**
     * Get Category and send ajax request to server
     */
    $selectCate = document.getElementById('categoryselect');
    $selectCate.addEventListener('change', function(e) {
        $selectFood = document.getElementById('foodselect');
        while ($selectFood.firstChild) {
            $selectFood.removeChild($selectFood.firstChild);
        }
        if (window.location.href.indexOf('create')>0) {
            $url = window.location.href;
        } else {
            $url = window.location.href+"/create";
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        $.ajax({
            type: "GET",
            url: $url,
            data: {
                category_id: e.target.options[e.target.selectedIndex].value
            },
            success: function(data) {
                data.forEach(function(foodElement) {
                    //create food select
                    $foodOption = document.createElement('option');
                    $foodOption.text = foodElement['name'];
                    $foodOption.value = foodElement['id'];
                    $selectFood.appendChild($foodOption);
                })
            }
        }); 
    });
}
