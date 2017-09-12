@extends('layouts.master')
@section('main-content')

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $statistics->totalRegister }}</h3>

                    <p>{{ __('User Registrations') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('users.index') }}" class="small-box-footer">{{ __('More info') }}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $statistics->totalOrder }}</h3>

                    <p>{{ _('New Orders') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('orders.index') }}" class="small-box-footer">{{ __('More info') }}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $statistics->totalMaterial }}</h3>

                    <p>{{ __('Materials') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-rose"></i>
                </div>
                <a href="{{ route('materials.index') }}" class="small-box-footer">{{ __('More info') }}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $statistics->totalFood }}</h3>

                    <p>{{ __('Daily Menu') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-ios-list"></i>
                </div>
                <a href="{{ route('daily-menus.show', $statistics->date) }}" class="small-box-footer">{{ __('More info') }}<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

@endsection
