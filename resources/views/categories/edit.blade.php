@extends('layouts.master')
@section('main-header')
    <h1>{{ __('UPDATE CATEGORY PAGE') }}
        <small></small>
        <a href="{{ route('categories.index') }}" class="pull-right"><span
                    class="fa fa-arrow-left btn btn-primary"></span></a>
    </h1>
@endsection
@section('main-content')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                @include('flash::message')
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">{{__('Edit Category')}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('categories.update', ['id' => $category->id])}}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name">{{__('Category Name')}}</label>
                                <input type="text" class="form-control" name="name" placeholder=""
                                       value="{{ $category->name }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">{{__('Description')}}</label>
                                <textarea class="form-control"
                                          name="description">{{ $category->description }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-primary" value="{{__('Update')}}">
                            <input type="reset" class="btn btn-danger" value="{{__('Cancel')}}">
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
