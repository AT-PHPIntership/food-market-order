@extends('layouts.master')
@section('main-content')
    <div class="box">
        <div class="box-header">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <h3 class="box-title"><strong>{{ _('Daily Menu List') }}</strong></h3>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{ route('daily-menus.create') }}" class="btn btn-xl btn-primary pull-right">
                            {{ _('Create New Menu') }}
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
                      <label for="dateSearch">{{ _('Choose Date') }}: </label>
                      @if(!empty($date))
                        <input type="date" class="form-control" id = "dateSearch" name="date" value="{{ $date }}" style="width: 20em">
                        <input type="submit" class="btn-primary btn" value="Search">
                      @else
                        <input type="date" class="form-control" id = "dateSearch" name="date" style="width: 20em">
                        <input type="submit" class="btn-primary btn" value="Search">
                      @endif
                    </div>
                    </form>
                        <table class="table table-bordered table-striped dataTable table-hover text-center" role="grid">
                            <thead>
                                <tr role="row">
                                    <th style="width: 8em">{{ _('Date') }}</th>
                                    <th style="width: 2em">{{ _('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($listDailyMenu as $dailyMenu)
                                <tr>
                                    <td><h4>{{ $dailyMenu->date }}</h4></td>
                                    <td>
                                        <a href="{{ route('daily-menus.show', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-success btn">{{ _('Detail') }}</span>
                                        </a>
                                        <a href="{{ route('daily-menus.edit', $dailyMenu->date) }}">
                                            <span class="btn-xl btn-warning btn">{{ _('Edit') }}</span>
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
