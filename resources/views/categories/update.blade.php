@extends('layouts.master')
@section('main-content')
    <div class="row center">
        <!-- left column -->
        <div class="col-md-12">
            <div class="col-md-3">
            </div>emplate
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border text-center">
                        <h3 class="box-title">Update Category</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" action="{{ route('category.update', ['id' => $category->id])}}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" name="categoryName" placeholder=""
                                       value="{{ $category->name }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control"
                                          name="description">{{ $category->description }}</textarea>
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
