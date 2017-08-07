@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Daily Menu For') }}<span class="label label-info" id="$menuDate">{{ $date }}</span></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">{{ __('ID') }}</th>
                                <th style="width: 6em">{{ __('Food Name') }}</th>
                                <th style="width: 6em">{{ __('Category Name') }}</th>
                                <th style="width: 2em">{{ __('Price') }}</th>
                                <th style="width: 4em">{{ __('Created At') }}</th>
                                <th style="width: 4em">{{ __('Updated At') }}</th>
                                <th style="width: 1em">{{ __('Quantity') }}</th>
                                <th style="width: 2em">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTable">
                            @foreach ($menuOnDate as $menuItem)
                                <tr>
                                    <td>{{ $menuItem->id }}</td>
                                    <td>{{ $menuItem->foods->name }}</td>
                                    <td>{{ $menuItem->foods->categories->name }}</td>
                                    <td>{{ $menuItem->foods->price }}</td>
                                    <td>{{ $menuItem->created_at }}</td>
                                    <td>{{ $menuItem->updated_at }}</td>
                                    <td><input type="text" value="{{ $menuItem->quantity }}" id={{ $menuItem->id }} disabled></td>
                                    <td>
                                        <button class="btn-xs btn-warning btn glyphicon glyphicon-edit" name="btnEdit" data-alert=@lang('dailymenu.alert') value={{ $menuItem->id }}>
                                        </button>
                                        <button class="btn-xs btn-danger btn glyphicon glyphicon-remove" name="btnDel" data-confirm="{{ __('Do you sure want to delete this item?') }}" value={{ $menuItem->id }}>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $menuOnDate->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js-script')
<script src="{{ asset("/js/common.js") }}"></script>
@stop
