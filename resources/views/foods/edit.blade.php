@extends('layouts.master')
@section('main-header')
    <h1>{{ __('UPDATE FOOD') }}
        <small></small>
        <a href="{{ route('foods.index') }}" class="pull-right"><span class="fa fa-arrow-left btn btn-primary"></span></a>
    </h1>
@endsection
@section('main-content')
    @if(!isset($food))
        <h1>{{ __('Nothing to show!') }}</h1>
    @else
        <div class="row">
            @include('flash::message')
            <form autocomplete="off" class="form-horizontal" enctype="multipart/form-data"
                  action="{{ route('foods.update', $food->id) }}" method="POST">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="text-center">
                        <img src="{{ $food->image }}" class="avatar img-circle img-thumbnail" alt=" avatar">`
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
                    <h2 class="text-center">{{ __('Food Information') }}</h2>
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Name') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('name', $food->name) }}" type="text" name="name">
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
                            {{ old('category_id', $food->category_id) == $category->id ?
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
                    <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Price') }}</label>
                        <div class="col-lg-8">
                            <input class="form-control" value="{{ old('price', $food->price) }}" type="text" name="price">
                            @if ($errors->has('price'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('price') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        <label class="col-lg-3 control-label">{{ __('Description') }}</label>
                        <div class="col-lg-8">
                            <textarea name="description" rows="4" cols="72">{{ old('description', $food->description) }}</textarea>
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
                            <input class="btn btn-primary" value="{{ __('Save Changes') }}" type="submit">
                            <a href="{{ route('foods.index') }}">
                                <button type="button" class="btn btn-danger">{{ __('Cancel') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
