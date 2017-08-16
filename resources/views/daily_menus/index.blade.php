@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST DAILY MENUS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{ __('Daily Menu List') }}</h3>
            <a class="btn btn-xl btn-primary pull-right" href="{{ route('daily-menus.create') }}">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <form method="GET" action="{{ route('daily-menus.index') }}">
                                <label for="dateSearch">{{ __('Date') }}: </label>
                                <input type="text" class="form-control" id="dateSearch" name="date"
                                       value="{{ (!empty($date)) ? $date : '' }}">
                                <input type="submit" class="btn-default btn" value="Search">
                            </form>
                        </div>
                        <table class="table table-bordered dataTable table-hover text-center" role="grid">
                            <thead>
                            <tr role="row">
                                <th class="col-md-8">{{ __('Date') }}</th>
                                <th class="col-md-4">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($dailyMenus as $dailyMenu)
                                <tr>
                                    <td><h4>{{ $dailyMenu->date }}</h4></td>
                                    <td>
                                        <a class=" btn-sm btn btn-info"
                                           href="{{ route('daily-menus.show', $dailyMenu->date) }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                        <a class=" btn-sm btn-success btn"
                                           href="{{ route('daily-menus.edit', $dailyMenu->date) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            {{ $dailyMenus->links() }}
        </div>
    </div>
@endsection
