@extends('layouts.master')

@section('main-content')
<div class="row center">
  <div class="col-md-12">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border text-center">
          <h3 class="box-title">{{ trans('foods/create.title') }}</h3>
        </div>
        <form action="{{ route('foods.store')}}" enctype="multipart/form-data" method="POST">
          {{csrf_field()}}
          <div class="box-body">
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label>{{__('Name')}}</label>
              <input type="text" class="form-control" name="name" value="{{ old('name') }}">
              @if($errors->first('name'))
              <span class="help-block">{{$errors->first('name')}}</span>
              @endif
            </div>
            <div class="form-group  {{ $errors->has('category_id') ? ' has-error' : '' }}">
              <label>{{ __('Category') }}</label>
             <select class="form-group" name="category_id">
                <option value="" selected>{{ __('Choose Category') }}</option>
                @foreach($categoryName as $catName)
                <option value="{{$catName->id}}">{{$catName->name}}</option>
                @endforeach
              </select>
              @if($errors->first('category_id'))
              <span class="help-block">{{$errors->first('category_id')}}</span>
              @endif
            </div>
            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
              <label>{{__('Description')}}</label>
              <textarea class="textarea" name="description" rows="5" cols="70" value="{{ old('description') }}">
              </textarea>
            </div>
              @if($errors->first('description'))
              <span class="help-block">{{$errors->first('description')}}</span>
              @endif
            </div>
            <div class="form-group {{ $errors->has('price') ? ' has-error' : '' }}">
              <label>{{__('Price')}}</label>
              <input type="text" class="form-control" name="price" value="{{ old('price') }}">
              @if($errors->first('price'))
              <span class="help-block">{{$errors->first('price')}}</span>
              @endif
            </div>
            <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
              <label>{{ __('Image') }}</label>
              <input type="file" name="image" >
              @if($errors->first('image'))
              <span class="help-block">{{$errors->first('image')}}</span>
              @endif
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">{{__('Create')}}</button>
            <a href="{{route('foods.index')}}">
              <button type="button" class="btn  btn-danger">{{__('Cancel')}}</button>
            </a>
          </div>
        </form>
      </div>
    </div>
    <div class="col-md-3">
    </div>
  </div>
</div>
@endsection
