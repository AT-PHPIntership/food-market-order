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
                        <h3 class="box-title">{{trans('editcategory.title_header')}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('categories.update', ['id' => $category->id])}}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('categoryName') ? 'has-error' : '' }}">
                                <label for="categoryName">{{trans('editcategory.cate_name')}}</label>
                                <input type="text" class="form-control" name="name" placeholder=""
                                       value="{{ $category->name }}">
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="description">{{trans('editcategory.cate_description')}}</label>
                                <textarea class="form-control"
                                          name="description">{{ $category->description }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-primary" value="Update">
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
