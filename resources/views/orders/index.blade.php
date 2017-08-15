@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST ORDERS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{ __('List Order') }}</h3>
            <a class="btn btn-primary pull-right" href="{{ route('orders.create')}}">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <input id="text-sort" class="form-control pull-left margin-bottom" type="text"
                               value="{{ app('request')->has('keyword') ? app('request')->input('keyword') : '' }}"
                               placeholder="{{ __('Key search') }}"
                               data-table="{{ __('orders') }}">
                        <input id="date-sort" class="form-control pull-right margin-bottom" type="date"
                               value="{{ app('request')->has('date') ? app('request')->input('date') : date('Y-m-d') }}"
                               data-table="{{ __('orders') }}">
                        <table class="table table-bordered table-hover" role="grid">
                            <thead>
                            <tr role="row">
                                <th class="col-md-1">{{ __('ID') }}</th>
                                <th class="col-md-2">{{ __('User Name') }}</th>
                                <th class="col-md-2">{{ __('Transfer Date') }}</th>
                                <th class="col-md-3">{{ __('Address') }}</th>
                                <th class="col-md-1">{{ __('Payment') }}</th>
                                <th class="col-md-1">{{ __('Status') }}</th>
                                <th class="col-md-2">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <form role="form" class="confirm-data pull-left"
                                      action="{{ route('orders.update', $order->id) }}"
                                      method="post">
                                    {{ method_field('PUT') }}
                                    {{ csrf_field() }}
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->full_name }}</td>
                                        <td>{{ $order->trans_at }}</td>
                                        <td>{{ $order->custom_address }}</td>
                                        <td>{{ $order->payment }}</td>
                                        <td>
                                            <select class="form-control" name="status">
                                                <option {{ $order->status == 0 ? 'selected' : '' }}
                                                        value="0">{{ __('Cancel') }}</option>
                                                <option {{ $order->status == 1 ? 'selected' : '' }}
                                                        value="1">{{ __('Pending') }}</option>
                                                <option {{ $order->status == 2 ? 'selected' : '' }}
                                                        value="2">{{ __('Sending') }}</option>
                                                <option {{ $order->status == 3 ? 'selected' : '' }}
                                                        value="3">{{ __('Finish') }}</option>
                                            </select>


                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm" href="{{ route('orders.show',$order->id)  }}"
                                               title="{{ __('Detail') }}">
                                                <i class="fa fa-search-plus">
                                                </i>
                                            </a>
                                            <button class="btn-change-status btn-success btn btn-sm"
                                                    data-title="{{ __('Confirm') }}"
                                                    data-confirm="{{ __('Are you sure change status this?') }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                </form>
                                <form role="form" class="delete-item inline"
                                      action="{{ route('orders.destroy', $order->id) }}"
                                      method="post">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn-danger btn btn-sm btn-confirm"
                                            data-confirm="{{ __('Are you want delete it?') }}"
                                            data-title="{{ __('Delete Order') }}"
                                            title="{{ __('Delete Order') }}">
                                        <i class="fa fa-trash "></i>
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
        </div>
        <div class="box-footer">
            {{ $orders->links() }}
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
