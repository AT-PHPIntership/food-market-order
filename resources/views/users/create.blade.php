@extends('layouts.master')
@section('main-content')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Create New User</h3>
                    </div>
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="inputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="inputEmail1"
                                       placeholder="Enter email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="inputPassword">Password</label>
                                <input type="password" name="password" class="form-control" id="inputPassword"
                                       placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                                <label for="fullName">Full Name</label>
                                <input type="text" name="full_name" class="form-control" id="fullName"
                                       placeholder="Enter User's Name">
                                @if ($errors->has('full_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option selected value="1">Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                    <label>Birthday:</label>
                                    <div class="input-group date">
                                        <input name="birthday" type="date" class="form-control pull-right"
                                               id="datepicker">
                                        @if ($errors->has('birthday'))
                                            <span class="help-block">
                                              <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control" id="address"
                                       placeholder="Enter User's Address">
                            </div>
                            <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" name="phone_number" class="form-control" id="phoneNumber"
                                       placeholder="Enter User's Phone Number">
                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="exampleInputFile">Choose Image</label>
                                <input name="image" type="file" id="exampleInputFile">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-primary" value="Create">
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
