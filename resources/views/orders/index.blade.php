@extends('layouts.master')

@section('main-content')
    <div class="box" xmlns="">
        <div class="box-header">
            <h3 class="box-title">{{ __('List Order') }}</h3>
            <button class="btn btn-primary pull-right">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        @include('flash::message')
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <input id="text-sort" class="form-control pull-left margin-bottom" type="text"
                               value="{{ app('request')->has('keyword') ? app('request')->input('keyword') : '' }}"
                               placeholder="{{ __('Key search') }}"
                               data-table="{{ __('orders') }}">
                        <input id="date-sort" class="form-control pull-right margin-bottom" type="date"
                               value="{{ app('request')->has('date') ? app('request')->input('date') : date('Y-m-d') }}"
                               data-table="{{ __('orders') }}">
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row" class="row">
                                <th class="col-md-1">{{ __('ID') }}</th>
                                <th class="col-md-2">{{ __('User Name') }}</th>
                                <th class="col-md-1">{{ __('Create Date') }}</th>
                                <th class="col-md-1">{{ __('Update Date') }}</th>
                                <th class="col-md-1">{{ __('Transfer Date') }}</th>
                                <th class="col-md-2">{{ __('Address') }}</th>
                                <th class="col-md-1">{{ __('Payment') }}</th>
                                <th class="col-md-1">{{ __('Status') }}</th>
                                <th class="col-md-2">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <form role="form" class="confirm-data pull-left"
                                          action="{{ route('orders.update', $order->id) }}"
                                          method="post">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        <td></td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->full_name }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->updated_at }}</td>
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
                                            <a class="btn btn-info btn-sm pull-left"
                                               href="{{ route('orders.show',$order->id)  }}"
                                               title="{{ __('Detail') }}">
                                                <span class="glyphicon glyphicon-zoom-in">
                                                </span>
                                            </a>
                                            <button class="btn-confirm btn-success btn btn-sm pull-left"
                                                    title="{{ __('Confirm') }}"
                                                    data-title="{{ __('Change status') }}"
                                                    data-confirm="{{ __('Are you sure change status this?') }}">
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                            </button>
                                    </form>
                                    <form role="form" class="delete-item pull-left"
                                          action="{{ route('orders.destroy', $order->id) }}"
                                          method="post">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button class="btn-danger btn btn-sm btn-confirm"
                                                data-title="{{ __('Delete Order') }}"
                                                data-confirm="{{ __('Are you want delete it?') }}"
                                                title="{{ __('Delete Order') }}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
