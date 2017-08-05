@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Daily Menu For<span class="label label-info" id="$menuDate">{{ $date }}</span></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">Menu ID</th>
                                <th style="width: 6em">Food Name</th>
                                <th style="width: 6em">Category Name</th>
                                <th style="width: 2em">Price</th>
                                <th style="width: 4em">Created At</th>
                                <th style="width: 4em">Updated At</th>
                                <th style="width: 1em">Quantity</th>
                                <th style="width: 2em">Edit</th>
                                <th style="width: 1em">Delele</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTable">
                            @foreach ($menuOnDate as $menuItem)
                                <tr>
                                    <td>{{ $menuItem->id }}</td>
                                    <td>{{ $menuItem->food_name }}</td>
                                    <td>{{ $menuItem->category_name }}</td>
                                    <td>{{ $menuItem->food_price }}</td>
                                    <td>{{ $menuItem->created_at }}</td>
                                    <td>{{ $menuItem->updated_at }}</td>
                                    <td><input type="text" value="{{ $menuItem->quantity }}" id={{ $menuItem->id }} disabled></td>
                                    <td>
                                        <button class="btn-xs btn-warning btn glyphicon glyphicon-edit" name="btnEdit" value={{ $menuItem->id }}>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn-xs btn-danger btn glyphicon glyphicon-remove" name="btnDel" value={{ $menuItem->id }}>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ajax-js-script')
<script src="{{ asset("/js/ajax_dailymenu.js") }}"></script>
@stop

@section('page-js-script')
<script src="{{ asset("/js/show_dailymenu.js") }}"></script>
@stop
