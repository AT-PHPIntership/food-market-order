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
                        <h3 class="box-title">{{ trans('foods/create.title') }}</h3>
                    </div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                                {{$err}} <br>
                            @endforeach
                        </div>
                    @endif
                    <form role="form" action="{{ route('foods.store')}}" method="POST" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="foodName">{{ trans('foods/create.name') }}</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="categoryName">{{ trans('foods/create.category') }}</label>
                                <select class="form-group" name="category_id" >
                                    <option value="" selected>{{ trans('foods/create.select_category') }}</option>
                                    @foreach($categoryName as $catName)
                                    <option value="{{$catName->id}}">{{$catName->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans('foods/create.description') }}</label>
                                <input type="text" class="form-control" name="description" placeholder="Description" value="{{ old('description') }}">
                            </div>
                            <div class="form-group">
                                <label for="price">{{ trans('foods/create.price') }}</label>
                                <input type="text" class="form-control" name="price"
                                       placeholder="Price" value="{{ old('price') }}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">{{ trans('foods/create.image') }}</label>
                                <input type="file" name="image" value="{{ old('image') }}">
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <input type="submit" class="btn btn-success" value="{{ trans('foods/create.create') }}">
                            <input type="reset" class="btn btn-primary" name="{{ trans('foods/create.reset') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
@endsection
