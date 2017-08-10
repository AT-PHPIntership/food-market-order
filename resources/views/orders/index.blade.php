@extends('layouts.master')

@section('main-content')
    <div class="box" xmlns="">
        <div class="box-header">
            <h3 class="box-title">{{__('List Order')}}</h3>
            <button class="btn btn-warning pull-right">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <input id="text-sort" class="form-control pull-left margin-bottom" type="text"
                               value="{{ app('request')->has('key') ? app('request')->input('key') : '' }}"
                               placeholder="{{__('Key search')}}"
                               data-table="{{__('orders')}}">
                        <input id="date-sort" class="form-control pull-right margin-bottom" type="date"
                               value="{{ app('request')->has('date') ? app('request')->input('date') : date('Y-m-d') }}"
                               data-table="{{__('orders')}}">
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row" class="row">
                                <th class="col-md-1">{{__('ID')}}</th>
                                <th class="col-md-2">{{__('User Name')}}</th>
                                <th class="col-md-1">{{__('Create Date')}}</th>
                                <th class="col-md-1">{{__('Update Date')}}</th>
                                <th class="col-md-1">{{__('Transfer Date')}}</th>
                                <th class="col-md-2">{{__('Address')}}</th>
                                <th class="col-md-1">{{__('Payment')}}</th>
                                <th class="col-md-1">{{__('Status')}}</th>
                                <th class="col-md-2">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td></td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->full_name }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td>{{ $order->trans_at }}</td>
                                    <td>{{ $order->custom_address }}</td>
                                    <td>{{ $order->payment }}</td>
                                    <td>
                                        @if ($order->status == 0)
                                            {{__('Cancel')}}
                                        @endif
                                        @if ($order->status == 1)
                                            {{__('Pending')}}
                                        @endif
                                        @if ($order->status == 2)
                                            {{__('Sending')}}
                                        @endif
                                        @if ($order->status == 3)
                                            {{__('Finish')}}
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-info"
                                           href="{{ route('orders.show',$order->id) }}"
                                           title="{{__('Detail')}}">
                                            <span class="glyphicon glyphicon-zoom-in">
                                            </span>
                                        </a>
                                        @if ($order->status != 2)
                                            <button class="btn-success btn" title="{{__('Confirm')}}">
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </button>
                                        @endif
                                        @if ($order->status == 2)
                                            <button class="btn-success btn" title="{{__('Confirm')}}" disabled>
                                                <span class="glyphicon glyphicon-ok"></span>
                                            </button>
                                        @endif
                                        @if ($order->status == 2)
                                            <button class="btn-danger btn" title="{{__('Cancel')}}" disabled>
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        @endif
                                        @if ($order->status != 2)
                                            <button class="btn-danger btn" title="{{__('Cancel')}}">
                                                <span class="glyphicon glyphicon-remove"></span>
                                            </button>
                                        @endif
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
@endsection
