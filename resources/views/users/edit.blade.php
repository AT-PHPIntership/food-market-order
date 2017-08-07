@extends('layouts.master')
@section('main-content')
    @if(!isset($user))
        <h1>User not found</h1>
    @else
        <div class="row">
            <div class="alert alert-info alert-dismissable">
                <a class="panel-close close" data-dismiss="alert">×</a>
                <i class="fa fa-coffee"></i>
                This is an <strong>.alert</strong>. Use this to show important messages to the user.
            </div>
            <form class="form-horizontal" role="form" action="{{ route('users.update', $user->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value=" {{  csrf_token() }}">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="text-center">
                        @if(!isset($user->image))
                            <img src="https://bootdey.com/img/Content/user-453533-fdadfd.png"
                                 class="avatar img-circle img-thumbnail" alt=" avatar">
                        @else
                            <img src="/images/users/{{ $user->image }}" class="avatar img-circle img-thumbnail"
                                 alt=" avatar">
                        @endif
                        <h6 class="{{ $errors->has('image') ? ' has-error' : '' }}">Upload a different photo...</h6>
                        <input type="file" enctype="multipart/form-data" class="text-center center-block well well-sm">

                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                    <h3>Update User Profile</h3>
                    <div class="form-group {{ $errors->has('full_name') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">Full name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ $user->full_name }}" type="text" name="full_name">

                            @if ($errors->has('full_mane'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('full_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input class="form-control" disabled value="{{ $user->email }}" type="text"
                                   name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Address:</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ $user->address }}" type="text" name="address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Gender:</label>
                        <div class="col-lg-8">
                            <div class="ui-select">
                                <select id="user_time_zone" class="form-control" name="gender">
                                    <option @if($user->gender == 1) selected @endif value="1">Male</option>
                                    <option @if($user->gender == 0) selected @endif value="0">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Birthday:</label>
                        <div class="col-md-8">
                            <div class="input-group date">
                                <input type="date" class="form-control pull-right" id="datepicker"
                                       value="{{ $user->birthday }}" name="birthday">

                                @if ($errors->has('birthday'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Phone Number:</label>
                        <div class="col-md-8">
                            <input class="form-control" value="{{ $user->phone_number }}" type="text"
                                   name="phone_number">

                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">New Password:</label>
                        <div class="col-md-8">
                            <input class="form-control" value="default" type="password" name="password">

                            @if ($errors->has('passsword'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <input class="btn btn-primary" value="Save Changes" type="submit">
                            <span></span>
                            <input class="btn btn-default" value="Cancel" type="reset">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection