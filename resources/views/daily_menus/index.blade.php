@extends('layouts.master')
@section('main-content')
    <div class="box">
        <div class="box-header">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <h3 class="box-title"><strong>{{ __('Daily Menu List') }}</strong></h3>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{ route('daily-menus.create') }}" class="btn btn-xl btn-primary pull-right">
                            {{ __('Create New Menu') }}
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
                        <div class="form-group">
                            <form method="GET" action="{{ route('daily-menus.index') }}">
                                <label for="dateSearch">{{ __('Choose Date') }}: </label>
                                <input type="text" class="form-control" id = "dateSearch" name="date"
                                value="{{ (!empty($date)) ? $date : '' }}" style="width: 20em">
                                <input type="submit" class="btn-primary btn" value="Search">
                            </form>
                        </div>
                        <table class="table table-bordered table-striped dataTable table-hover text-center" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width: 8em">{{ __('Date') }}</th>
                                    <th style="width: 2em">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dailyMenus as $dailyMenu)
                                <tr>
                                    <td><h4>{{ $dailyMenu->date }}</h4></td>
                                    <td>
                                        <a href="{{ route('daily-menus.show', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-success btn">{{ __('Detail') }}</span>
                                        </a>
                                        <a href="{{ route('daily-menus.edit', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-warning btn">{{ __('Edit') }}</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $dailyMenus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
