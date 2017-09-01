@extends('layouts.master')
@section('main-header')
    <h1>{{ __('CREATE SUPPLIER PAGE') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{__('Create New Supplier')}}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('suppliers.store')}}" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="col-md-2"></div>
                    <div class="box-body col-md-8">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                            <div class="col-md-2"><label for="name">{{__('Name')}}</label></div>
                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" placeholder=""
                                       value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('description') ? 'has-error' : '' }}">
                            <div class="col-md-2">
                                <label for="description">{{__('Description')}}</label></div>
                            <div class="col-md-10">
                            <textarea class="form-control"
                                      name="description">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="{{__('Create')}}">
                            <input type="reset" class="btn btn-danger pull-left" value="{{__('Reset')}}">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                    </div>
                    <div class="col-md-2"></div>
                </form>
            </div>
        </div>
        <div class="col-md-3">
        </div>
        <!-- /.box -->
    </div>
    </div>
@endsection
