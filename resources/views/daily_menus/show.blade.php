@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Daily Menu For') }}<span class="label label-info" id="menuDate"> {{ $date }}</span></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row">
                                <th class="col-xs-1">{{ __('ID') }}</th>
                                <th class="col-xs-3">{{ __('Food Name') }}</th>
                                <th class="col-xs-3">{{ __('Category Name') }}</th>
                                <th class="col-xs-1">{{ __('Price') }}</th>
                                <th class="col-xs-3">{{ __('Created At') }}</th>
                                <th class="col-xs-3">{{ __('Updated At') }}</th>
                                <th class="col-xs-1">{{ __('Quantity') }}</th>
                                <th class="col-xs-3">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody id="bodyTable">
                            @if (empty($menuOnDate))
                                <tr>
                                    <strong>{{ __('Nothing to show') }}</strong>
                                </tr>
                            @else
                                @foreach ($menuOnDate as $menuItem)
                                    <tr>
                                        <td>{{ $menuItem->id }}</td>
                                        <td>{{ $menuItem->food->name }}</td>
                                        <td>{{ $menuItem->food->category->name }}</td>
                                        <td>{{ $menuItem->food->price }}</td>
                                        <td>{{ $menuItem->created_at }}</td>
                                        <td>{{ $menuItem->updated_at }}</td>
                                        <td class="form-group">
                                            <div>
                                                <input type="number" class="form-control" value={{ $menuItem->quantity }} id={{ $menuItem->id }} disabled>
                                                <span type="hidden" class="help-block" id="helpblock"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn-xs btn-primary btn glyphicon glyphicon-edit" name="btnEdit" value={{ $menuItem->id }}>
                                            </button>
                                            <button class="btn-xs btn-danger btn glyphicon glyphicon-remove" data-confirm="{{ __('Are you sure you want to delete this item?') }}" name="btnDel" value={{ $menuItem->id }}>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        {{ $menuOnDate->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
