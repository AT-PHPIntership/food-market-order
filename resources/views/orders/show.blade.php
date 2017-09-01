@extends('layouts.master')
@section('main-header')
    <h1>{{ __('DETAIL ORDERS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="box box-primary">
        <div class="box-header">
            <h1 class="box-title">{{ __('Order') }} {{ $order->id }} - {{ __('Date') }} : {{ $order->created_at }}</h1>
            <small></small>
        </div>
        <div class="alert alert-dismissable" id="alert-detail-order">
            <a href="#" class="close" aria-label="close">×</a>
            <span class="content-alert"><strong>Success!</strong> This alert box could indicate a successful or positive action.</span>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table">
                            <tr>
                                <th class="col-md-2">{{ __('User') }}:</th>
                                <td><a href="{{ route('users.show', $order->user->id) }}">
                                        {{ $order->user->full_name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="col-md-2">{{ __('Email') }}:</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">{{ __('Address ') }}:</th>
                                <td>{{ $order->custom_address }}</td>
                            </tr>
                            <tr>
                                <th class="col-md-2">{{ __('Date transport') }}:</th>
                                <td>{{ $order->trans_at }}</td>
                            </tr>
                        </table>
                        <h4>{{ __('List Item') }}</h4>
                        <table class="table table-bordered table-striped dataTable table-hover" role="grid">
                            <thead>
                            <tr role="row">
                                <th>{{ __('ID') }}</th>
                                <th class="col-md-2">{{ __('Name Item') }}</th>
                                <th class="col-md-2">{{ __('Image') }}</th>
                                <th class="col-md-1">{{ __('Type') }}</th>
                                <th class="col-md-1">{{ __('Price') }}</th>
                                <th class="col-md-1">{{ __('Quantity') }}</th>
                                <th class="col-md-2">{{ __('Total') }}</th>
                                <th class="col-md-1">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->itemtable->name }}</td>
                                    <td>
                                        <img src="{{ $item->itemtable->image }}" height="30px" width="30px"/>
                                    </td>
                                    <td>{{ substr($item->itemtable_type,4) }}</td>
                                    <td><span class="priceItem">{{ number_format($item->itemtable->price,0,",",".") }}</span> {{ __('VND') }}</td>
                                    <td><input type="number"
                                               name="quantity"
                                               min="0"
                                               data-id="{{ $item->id }}"
                                               data-confirm="{{ __('Are you sure update it?') }}"
                                               data-title="{{ __('Update Item') }}"
                                               class="quantity-order-item"
                                               value="{{ $item->quantity }}">
                                        <input type="hidden" class="quantity-back-up" value="{{ $item->quantity }}"/>
                                    </td>
                                    <td><span class="totalItem">{{ number_format($item->itemtable->price * $item->quantity,0,",",".") }}</span> {{ __('VND') }}
                                    </td>
                                    <td>
                                        <button class="btn-danger btn delete-order-item btn-sm"
                                                data-id="{{ $item->id }}"
                                                data-confirm="{{ __('Are you want delete it?') }}"
                                                data-title="{{ __('Delete Item Order') }}"
                                                title="{{ __('Cancel') }}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr role="row">
                                <th colspan="5"></th>
                                <th>Total</th>
                                <th><span id="payment-order" class="pull-left">{{ number_format($order->total_price,0,",",".") }}</span> {{ __('VND') }}</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                        <div class="pull-right">
                            <a class="btn-success btn btn-sm"
                                    href="{{ route('orders.index') }}"
                                    title="{{ __('Go to list') }}">
                                <span>{{ __('Go To List') }}</span>
                            </a>
                            <form class="inline" role="form" action="{{ route('orders.destroy', $order->id) }}" method="post">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="btn-danger btn btn-confirm btn-sm"
                                        data-confirm="{{ __('Are you want delete this order?') }}"
                                        data-title="{{ __('Delete Order') }}"
                                        title="{{ __('Cancel') }}">
                                    <span>{{ __('Cancel Order') }}</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
