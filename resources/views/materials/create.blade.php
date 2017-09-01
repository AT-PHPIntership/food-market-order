@extends('layouts.master')
@section('main-header')
    <h1>{{ __('CREATE MATERIAL PAGE') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="row center">
        @include('flash::message')
        <div class="col-md-12">
        <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ __('Create Material') }}</h3>
                </div>
                <form action="{{ route('materials.store') }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-2"></div>
                    <div class="box-body col-md-8">
                        <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Name') }}</label></div>
                            <div class="col-md-10"><input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if($errors->first('name'))
                                    <span class="help-block">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Category') }}</label></div>
                            <div class="col-md-10"><select class="form-control" name="category_id">
                                    <option value="">{{ __('Choose Category') }}</option>
                                    @foreach($categories as $category)
                                        <option {{ (old('category_id') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->first('category_id'))
                                    <span class="help-block">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Supplier') }}</label></div>
                            <div class="col-md-10"><select class="form-control" name="supplier_id">
                                    <option value="">{{ __('Choose Supplier') }}</option>
                                    @foreach($suppliers as $supplier)
                                        <option {{ (old('supplier_id') == $supplier->id) ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->first('supplier_id'))
                                    <span class="help-block">{{ $errors->first('supplier_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('description') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Description') }}</label></div>
                            <div class="col-md-10"><textarea class="col-md-10 form-control" name="description"> {{ old('description', "") }}
                            </textarea>
                                @if($errors->first('description'))
                                    <span class="help-block">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('price') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Price') }}</label></div>
                            <div class="col-md-10"><input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                @if($errors->first('price'))
                                    <span class="help-block">{{ $errors->first('price') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('status') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Status') }}</label></div>
                            <div class="col-md-10"><select class="form-control" name="status">
                                    <option selected value="1">{{ __('Stocking') }}</option>
                                    <option value="0">{{ __('Out of stock') }}</option>
                                </select>
                                @if($errors->first('status'))
                                    <span class="help-block">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12 {{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-md-2"><label>{{ __('Image') }}</label></div>
                            <div class="col-md-10"><input type="file" name="image">
                                @if($errors->first('image'))
                                    <span class="help-block">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right"
                                   value="{{ __('Create') }}">
                            <input type="reset" class="btn btn-danger pull-left"
                                   value="{{ __('Reset') }}">
                        </div>
                    </div>
                    <div class="box-footer text-center"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
