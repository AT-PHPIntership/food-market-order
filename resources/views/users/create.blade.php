@extends('layouts.master')
@section('main-content')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">

            @include('flash::message')

            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">{{ __('Create New User') }}</h3>
                    </div>
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inputEmail1">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" id="inputEmail1"
                                       placeholder="Enter email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="inputPassword">{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control" id="inputPassword"
                                       placeholder="Password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                <label for="fullName">{{ __('Full name') }}</label>
                                <input type="text" name="full_name" class="form-control" id="fullName"
                                       placeholder="Enter Full Name" value="{{ old('full_name') }}">
                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ __('Gender') }}</label>
                                    <select name="gender" class="form-control">
                                        <option selected value="1">{{ __('Male') }}</option>
                                        <option value="0">{{ __('Female') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                    <label>{{ __('Birthday') }}</label>
                                    <div class="input-group date">
                                        <input name="birthday" type="date" class="form-control pull-right"
                                               id="datepicker" value="{{ old('birthday') }}">
                                        @if ($errors->has('birthday'))
                                            <span class="help-block">
                                              <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ __('Address') }}</label>
                                <input type="text" name="address" class="form-control" id="address"
                                       placeholder="Enter User's Address" value="{{ old('address') }}">
                            </div>
                            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                <label for="phoneNumber">{{ __('Phone Number') }}</label>
                                <input type="text" name="phone_number" class="form-control" id="phoneNumber"umber
                                       placeholder="Enter User's Phone Number" value="{{ old('phone_number') }}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="exampleInputFile">{{ __('Choose Image') }}</label>
                                <input name="image" type="file" id="exampleInputFile">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-primary" value="{{ __('Create') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
