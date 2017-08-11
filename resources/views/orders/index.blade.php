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
                                <form role="form" class="confirm-data pull-left"
                                      action="{{ route('orders.update', $order->id)}}"
                                      method="post">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                                                <select class="form-control" name="status">
                                                    <option {{ $order->status == 0 ? 'selected' : ''}}
                                                            value="{{0}}">{{__('Cancel')}}</option>
                                                    <option {{ $order->status == 1 ? 'selected' : ''}}
                                                            value="{{1}}">{{__('Pending')}}</option>
                                                    <option {{ $order->status == 2 ? 'selected' : ''}}
                                                            value="{{2}}">{{__('Sending')}}</option>
                                                    <option {{ $order->status == 3 ? 'selected' : ''}}
                                                            value="{{3}}">{{__('Finish')}}</option>
                                                </select>


                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                               href="{{ route('orders.show',$order->id) }}"
                                               title="{{__('Detail')}}">
                                                <span class="glyphicon glyphicon-zoom-in">
                                                </span>
                                            </a>
                                            <button class="btn-change-status btn-success btn btn-sm"
                                                    type="submit"
                                                    title="{{__('Confirm')}}"
                                                    data-confirm = "{{__('Are you sure change status this?')}}"
                                                    >
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                            </button>
                                            <form role="form" class="delete-item pull-left"
                                                  action="{{ route('orders.destroy', $order->id)}}"
                                                  method="post">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <button class="btn-danger btn btn-sm btn-confirm-delete"
                                                        data-confirm="{{__('Are you want delete it?')}}"
                                                        title="{{__('Delete Order')}}"
                                                        type="submit">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </form>
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
