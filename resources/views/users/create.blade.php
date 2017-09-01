@extends('layouts.master')
@section('main-header')
    <h1>{{ __('CREATE USER PAGE') }}
        <small>create new user active by admin</small>
    </h1>
@endsection
@section('main-content')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">

        @include('flash::message')
        <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header text-center">
                    <h3 class="box-title">{{ __('Create New User') }}</h3>
                </div>
                <!-- form start -->
                <form role="form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="is_active" value="1">
                    <div class="col-md-2"></div>
                    <div class="box-body col-md-8">
                        <div class="form-group col-md-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label for="inputEmail1" x>{{ __('Email') }}</label></div>
                            <div class="col-md-10"><input type="email" name="email" class="form-control"
                                                          id="inputEmail1"
                                                          placeholder="Enter email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label for="inputPassword">{{ __('Password') }}</label></div>
                            <div class="col-md-10"><input type="password" name="password" class="form-control"
                                                          id="inputPassword"
                                                          placeholder="Password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label for="fullName">{{ __('Full name') }}</label></div>
                            <div class="col-md-10"><input type="text" name="full_name" class="form-control"
                                                          id="fullName"
                                                          placeholder="Enter Full Name" value="{{ old('full_name') }}">
                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-4"><label>{{ __('Gender') }}</label></div>
                            <div class="col-md-8">
                                <select name="gender" class="form-control">
                                    <option selected value="1">{{ __('Male') }}</option>
                                    <option value="0">{{ __('Female') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                            <div class="col-md-3"><label>{{ __('Birthday') }}</label></div>
                            <div class="date col-md-9">
                                <input name="birthday" type="date" class="form-control"
                                       id="date-picker" value="{{ old('birthday') }}">
                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                              <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('address') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label for="address">{{ __('Address') }}</label></div>
                            <div class="col-md-10"><input type="text" name="address" class="form-control" id="address"
                                                          placeholder="Enter User's Address"
                                                          value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                              <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label for="phoneNumber">{{ __('Phone') }}</label></div>
                            <div class="col-md-10"><input type="text" name="phone_number" class="form-control"
                                                          id="phoneNumber"
                                                          placeholder="Enter User's Phone Number"
                                                          value="{{ old('phone_number') }}">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <div class="col-md-4"><label>{{ __('Role') }}</label></div>
                            <div class="col-md-8">
                                <select name="is_admin" class="form-control">
                                    <option selected value="0">{{ __('User') }}</option>
                                    <option value="1">{{ __('Admin') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 {{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-md-3"><label for="exampleInputFile">{{ __('Image') }}</label></div>
                            <div class="col-md-9"><input name="image" class="form-control" type="file" id="exampleInputFile">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-primary pull-left">{{ __('Create') }}</button>
                            <button type="reset" class="btn btn-danger pull-right">{{ __('Reset') }}</button>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                    <div class="col-md-2"></div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
        </div>
        <!-- /.box -->
    </div>
@endsection
