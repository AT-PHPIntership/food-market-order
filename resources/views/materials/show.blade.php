@extends('layouts.master')
@section('main-header')
    <h1>{{ __('DETAIL MATERIAL PAGE') }}
        <small></small>
        <a href="{{ route('materials.index') }}" class="pull-right"><span
                    class="fa fa-arrow-left btn btn-primary"></span></a>
    </h1>
@endsection
@section('main-content')
    <div class="container bootstrap snippet">
        <div class="panel-body inf-content">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-circle img-thumbnail" src="{{ $material->image }}" data-original-title="Usuario">
                </div>
                <div class="col-md-6 h4">
                    <h2>{{ __('Material Information') }}</h2>
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
                                    {{ $material->id }}
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
                                    {{ $material->name }}
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
                                    {{ $material->category->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                        {{ __('Supplier') }}
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    {{ $material->supplier->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-usd text-primary"></span>
                                    {{ __('Price') }}
                                </td>
                                <td class="text-primary">
                                    {{ $material->price }}
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
                                    {{ $material->description }}
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
                                    <a href="{{ route('materials.edit', $material->id) }}"><span
                                                class="btn btn-primary">{{ __('Edit') }}</span></a>
                                    <a href="{{ route('materials.index') }}"><span
                                                class="btn btn-danger">{{ __('Cancel') }}</span></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
