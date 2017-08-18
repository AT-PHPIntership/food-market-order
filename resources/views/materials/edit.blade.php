@extends('layouts.master')
@section('main-header')
    <h1>{{ __('UPDATE MATERIAL') }}
        <small></small>
        <a href="{{ route('materials.index') }}" class="pull-right"><span class="fa fa-arrow-left btn btn-primary"></span></a>
    </h1>
@endsection
@section('main-content')
    @if(!isset($material))
        <h1>{{ __('Nothing to show!') }}</h1>
    @else
        <div class="row">
            @include('flash::message')
            <form autocomplete="off" class="form-horizontal" enctype="multipart/form-data"
                  action="{{ route('materials.update', $material->id) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="text-center">
                        <img src="{{ $material->image }}" class="avatar img-circle img-thumbnail" alt=" avatar">`
                        <h6 class="{{ $errors->has('image') ? ' has-error' : '' }}">{{ __('Upload Image') }}</h6>
                        <input type="file" name="image" class="text-center center-block well well-sm">
                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12 personal-info">
                    <h2 class="text-center">{{ __('Material Information') }}</h2>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Name') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('name', $material->name) }}" type="text" name="name">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Category') }}</label>
                        <div class="col-lg-8">
                          <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                            <option
                                {{ old('category_id', $material->category_id) == $category->id ?
                                'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}
                            </option>
                            @endforeach
                          </select>
                          @if($errors->first('category_id'))
                          <span class="help-block">{{ $errors->first('category_id') }}</span>
                          @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Supplier') }}</label>
                        <div class="col-lg-8">
                          <select class="form-control" name="supplier_id">
                            @foreach($suppliers as $supplier)
                            <option
                                {{ old('supplier_id', $material->supplier_id) == $supplier->id ?
                                'selected' : '' }}
                                value="{{ $supplier->id }}">{{ $supplier->name }}
                            </option>
                            @endforeach
                          </select>
                          @if($errors->first('supplier_id'))
                          <span class="help-block">{{ $errors->first('supplier_id') }}</span>
                          @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Price') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('price', $material->price) }}" type="text" name="price">
                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">{{ __('Status') }}</label>
                        <div class="col-lg-8">
                            <div class="ui-select">
                                <select class="form-control" name="status">
                                    <option @if(old('status', $material->status) == 1) selected
                                            @endif value="1">{{ __('Stocking') }}</option>
                                    <option @if(old('status', $material->status) == 0) selected
                                            @endif value="0">{{ __('Out of stock') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Description') }}</label>
                        <div class="col-lg-8">
                            <textarea name="description" rows="4" cols="72">{{ old('description', $material->description) }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <input type="reset" class="btn btn-danger" value="{{ __('Reset') }}">
                            <input class="btn btn-primary" value="{{ __('Save Changes') }}" type="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
