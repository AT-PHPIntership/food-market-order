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

    <h2 class="page-header">{{ __('Top User Orders') }}</h2>

      <div class="row">
        @foreach ($statistics->users as $user)
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-gray">
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ $user->image }}" alt="User Avatar">
                </div>
              <!-- /.widget-user-image -->
                <h3 class="widget-user-username">
                    <a href="{{ route('users.show', $user->id) }}">
                        {{ $user->full_name }}
                    </a>
                </h3>
                <h5 class="widget-user-desc">{{ $user->email }}</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="{{ route('users.show', $user->id) }}">{{ __('Total Ordered') }} <span class="pull-right badge bg-blue">{{ $user->orders_count }}</span></a></li>
                <li><a href="#">{{ __('Canceled') }} <span class="pull-right badge bg-red">{{ $user->canceled_orders_count }}</span></a></li>
                <li><a href="#">{{ __('Pending') }} <span class="pull-right badge bg-aqua">{{ $user->pending_orders_count }}</span></a></li>
                <li><a href="#">{{ __('Approved') }} <span class="pull-right badge bg-yellow">{{ $user->approved_orders_count }}</span></a></li>
                <li><a href="#">{{ __('Finished') }} <span class="pull-right badge bg-green">{{ $user->finished_orders_count }}</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
        @endforeach
      </div>
      <!-- /.row -->
@endsection
