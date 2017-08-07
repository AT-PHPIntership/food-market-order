@extends('layouts.master')
@section('main-content')
    <div class="box">
        <div class="box-header">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <h3 class="box-title"><strong>@lang('dailymenu.listTitle')</strong></h3>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{ route('daily-menus.create') }}" class="btn btn-xl btn-primary pull-right">
                            @lang('dailymenu.create')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover text-center" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width: 8em">Date</th>
                                    <th style="width: 2em">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($listDailyMenu as $dailyMenu)
                                <tr>
                                    <td><h4>{{ $dailyMenu->date }}</h4></td>
                                    <td>
                                        <a href="{{ route('daily-menus.show', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-success btn">@lang('dailymenu.detailBtn')</span>
                                        </a>
                                        <a href="{{ route('daily-menus.edit', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-warning btn">@lang('dailymenu.editBtn')</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $listDailyMenu->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
