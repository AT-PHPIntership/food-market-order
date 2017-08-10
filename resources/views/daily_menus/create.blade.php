@extends('layouts.master')

@section('main-content')
<div class="box">
        <div class="box-header">
            <h3 class="box-title">
            @if((!empty($date))||(session()->has('date')))
            	{{ _('Add Item For') }} {{ $date }}{!! session('date') !!}
            @else
            	@lang('dailymenu.createTitle')
            @endif
            </h3>
        </div>
    <div class="row clearfix">
    	<div class="col-md-12 table-responsive">
			<table class="table table-bordered table-hover" id="tab_logic">
				<thead>
					<tr >
						<th class="text-center" style="width: 5em">
							{{ _('Category') }}
						</th>
						<th class="text-center" style="width: 5em">
							{{ _('Food') }}
						</th>
    					<th class="text-center" style="width: 5em">
							{{ _('Quantity') }}
						</th>
					</tr>
				</thead>
				<form id="createMenu" method="POST" action="{{ route('daily-menus.store') }}">
				{{ csrf_field() }}
				@if ($errors->any())
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
				@if(session()->has('message.level'))
				    <div class="alert alert-{{ session('message.level') }}"> 
				    {!! session('message.content') !!}
				    </div>
				@endif
				<div class="form-group">
                  <label for="dateChooser">{{ _('Choose Date') }}: </label>
                  @if(!empty($date))
                  	<input type="date" class="form-control" id = "dateChooser" name="date" value="{{ $date }}" style="width: 20em">
                  	<a href="{{ route('daily-menus.show', $date) }}">
                                            <span class="btn-xl btn-primary btn pull-right">{{ _('Show Menu') }}</span>
                    </a>
                  @else
                  	<input type="date" class="form-control" id = "dateChooser" name="date" style="width: 20em">
				  @endif
                </div>
				<tbody id='myBody'>
					<tr>
						<td id="categoryselect" style="width: 5em">
							<select class="form-control" id="cateselect">
								<option value="">Choose Category</option>
								@foreach ($listCategory as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>
						</td>
						<td id="foodsel" style="width: 5em">
							<select class="form-control" id="foodselect" name="food_id" form="createMenu">
							</select>
						</td>
						<td id="quantityselect" style="width: 5em">
							<input type="number" class="form-control" name="quantity"/>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<input type="submit" id="add_row" class="btn btn-primary pull-right" value="Add To Menu">
	</form>
</div>
@endsection
@section('page-js-script')
<script>
window.onload = function() {
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
	        	category: e.target.options[e.target.selectedIndex].value
	        },
	        success: function(data2) {
	            data2.forEach(function(foodElement) {
	            	//create food select
	            	$foodOption = document.createElement('option');
	            	$foodOption.text = foodElement['name'];
					$foodOption.value = foodElement['id'];
					$selectFood.appendChild($foodOption);
					// window.reload();
	            })
	        }
	    });	
	});
}
</script>
@stop

