@extends('layouts.master')
@section('main-header')
    <h1>{{ __('DETAIL FOOD PAGE') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="container bootstrap snippet">
        <div class="panel-body inf-content">
            <div class="row">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ __('Food Information') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-4">
                            <img class="img-circle img-thumbnail" src="{{ $food->image }}"
                                 data-original-title="Usuario">
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-condensed table-responsive table-user-information">
                                    <colgroup>
                                        <col class="col-md-2">
                                        <col class="col-md-6">
                                    </colgroup>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                {{ __('Identificacion') }}
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{ $food->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-cutlery  text-primary"></span>
                                                {{ __('Name') }}
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{ $food->name }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                                {{ __('Category') }}
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{ $food->category->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-usd text-primary"></span>
                                                {{ __('Price') }}
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{ $food->price }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="glyphicon glyphicon-tasks text-primary"></span>
                                                {{ __('Description') }}
                                            </strong>
                                        </td>
                                        <td class="text-primary">
                                            {{ $food->description }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>
                                                <span class="text-primary"></span>
                                                {{ __('Action') }}
                                            </strong>
                                        </td>
                                        <td>
                                            <a href="{{ route('foods.edit', $food->id) }}"><span
                                                        class="btn btn-primary">{{ __('Edit') }}</span></a>
                                            <a href="{{ route('foods.index') }}"><span
                                                        class="btn btn-danger">{{ __('Go to List') }}</span></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
