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
            @if (session('message')||(session('error')))
            <div class="alert {{ (session('message')) ? 'alert-success' : 'alert-danger' }}">
                {{ session('message') }} {{ session('error') }}
            </div>
            @endif
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <form method="GET" action="{{ route('daily-menus.index') }}">
                                <label for="dateSearch">{{ __('Date') }}: </label>
                                <input type="text" class="form-control" id = "dateSearch" name="date"
                                value="{{ (!empty($date)) ? $date : '' }}" style="width: 20em">
                                <input type="submit" class="btn-default btn" value="Search">
                            </form>
                        </div>
                        <table class="table table-bordered table-striped dataTable table-hover text-center" role="grid">
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
                                    <form method="POST" action="{{ route('daily-menus.destroy', $dailyMenu->date) }}" id="deleteMenu">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="date" type="hidden" value="{{ $dailyMenu->date }}">
                                            {{ csrf_field() }}
                                    <td>
                                        <a href="{{ route('daily-menus.show', $dailyMenu->date) }}"
                                           class="btn-xl btn-info btn ">
                                            <span class="glyphicon glyphicon-zoom-in"></span>
                                        </a>
                                        <button type="submit" class="btn-xl btn-danger btn btn-confirm" data-confirm="{{ __('Are you sure you want to delete this item?') }}" data-title="{{ __('Delete Meu') }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                    </form>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $dailyMenus->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.modal')
