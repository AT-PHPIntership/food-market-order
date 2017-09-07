@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST DAILY MENUS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    
    @include('flash::message')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">{{ __('Daily Menu List') }}</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-tools">
                        <form action="" class="pull-right">
                            <a class="btn btn-sm btn-primary pull-right" href="{{ route('daily-menus.create') }}">
                                <i class="fa fa-plus-circle"></i>
                                {{ __('Add Menu') }}
                            </a>
                            <div class="input-group input-group-sm search-group">
                                <input class="form-control" type="search" name="search" value="{{ request('search') }}"
                                       placeholder="type here for search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
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
                                        <form role="form" class="delete-item inline" action="{{ route('daily-menus.destroy', $dailyMenu->date)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button class="btn-sm btn-danger btn btn-confirm"
                                                    data-confirm="{{__('Are you want delete it?')}}"
                                                    data-title="{{__('Delete Daily Menu')}}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-tools">
                {{ $dailyMenus->links() }}
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.modal')
