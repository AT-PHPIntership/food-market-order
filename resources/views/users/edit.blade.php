@extends('layouts.master')
@section('main-header')
    <h1>
        {{ __('UPDATE USER PAGE') }}
        <small></small>
        <a href="{{ route('users.index') }}" class="pull-right">
            <span class="fa fa-arrow-left btn btn-primary"></span>
        </a>
    </h1>
@endsection
@section('main-content')
    @if(!isset($user))
        <h1>{{ __('Nothing to show!') }}</h1>
    @else
        <div class="row">

            @include('flash::message')

            <form autocomplete="off" class="form-horizontal" enctype="multipart/form-data"
                  action="{{ route('users.update', $user->id) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="text-center">
                        @if(!isset($user->image))
                            <img src="https://bootdey.com/img/Content/user-453533-fdadfd.png"
                                 class="avatar img-circle img-thumbnail" alt=" avatar">
                        @else
                            <img src="/images/users/{{ $user->image }}" class="avatar img-circle img-thumbnail"
                                 alt=" avatar">
                        @endif
                        <h6 class="{{ $errors->has('image') ? ' has-error' : '' }}">{{ __('Upload Image') }}</h6>
                        <input type="file" name="image" class="text-center center-block well well-sm">

                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">{{ __('Password') }}</label>
                        <div class="col-md-8">
                            <input class="form-control" autocomplete="off" type="password"
                                   name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 personal-info">
                    <h3>{{ __('User Information') }}</h3>
                    <div class="form-group {{ $errors->has('full_name') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Full Name') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('full_name', $user->full_name) }}" type="text"
                                   name="full_name">

                            @if ($errors->has('full_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ __('Email') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" disabled value="{{ $user->email }}" type="text"
                                   name="email">
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Address') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('address', $user->address) }}" type="text"
                                   name="address">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ __('Gender') }}</label>
                        <div class="col-lg-8">
                            <div class="ui-select">
                                <select id="user_time_zone" class="form-control" name="gender">
                                    <option @if(old('gender', $user->gender) == 1) selected
                                            @endif value="1">{{ __('Male') }}</option>
                                    <option @if(old('gender', $user->gender) == 0) selected
                                            @endif value="0">{{ __('Female') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">{{ __('Birthday') }}</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input type="date" class="form-control pull-right" id="date-picker"
                                       value="{{ old('birthday', $user->birthday) }}" name="birthday">

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">{{ __('Phone Number') }}</label>
                        <div class="col-md-8">
                            <input class="form-control" autocomplete="off"
                                   value="{{ old('phone_number', $user->phone_number) }}" type="text"
                                   name="phone_number">

                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <button class="btn btn-danger" type="reset">{{ __('Reset') }}</button>
                            <button class="btn btn-primary" type="submit">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection