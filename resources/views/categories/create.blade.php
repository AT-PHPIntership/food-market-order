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
                        <h3 class="box-title">{{__('Create New Category')}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('categories.store')}}" method="post">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">{{__('Name Category')}}</label>
                                <input type="text" class="form-control" name="name" placeholder=""
                                       value="{{ old('name') }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">{{__('Description')}}</label>
                                <textarea class="form-control"
                                          name="description">{{ old('description') }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-primary" value="{{__('Create')}}">
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
