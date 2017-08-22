<script type="text/javascript">
	//url for ajax request
    foodURLs = {
            base: "{{ url('/') }}",
            list_food_by_category: "{{ route('foods.index') }}"
    }
</script>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="{{ asset("/bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<script src="{{ asset("/bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("/bower_components/AdminLTE/dist/js/app.min.js") }}"></script>
<script src="{{ asset("/js/main.js") }}"></script>
<script src="{{ asset("/bower_components/AdminLTE/plugins/select2/select2.min.js") }}"></script>
