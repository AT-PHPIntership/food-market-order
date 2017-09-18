@extends('layouts.master')
@section('main-header')
    <h1>{{ __('DETAIL MATERIAL PAGE') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    @if(isset($material))
        <div class="panel-body inf-content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">{{ __('Material Information') }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-4 text-center">
                                <img alt="" title="" class="img-circle img-thumbnail isTooltip"
                                     src="{{ $material->image }}"
                                     data-original-title="Usuario">
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-responsive table-user-information has-description">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                                    {{ __('Identification') }}
                                                </strong>
                                            </td>
                                            <td class="text-primary">
                                                {{ $material->id }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>
                                                    <span class="glyphicon glyphicon-user  text-primary"></span>
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
                                                <a href="{{ route('categories.edit', $material->category->id) }}">
                                                    {{ $material->category->name }}
                                                </a>
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
                                                <a href="{{ route('suppliers.edit', $material->supplier->id) }}">
                                                    {{ $material->supplier->name }}
                                                </a>
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
                                                            class="btn btn-sm btn-primary">{{ __('Edit') }}</span></a>
                                                <a href="{{ route('materials.index') }}"><span
                                                            class="btn btn-sm btn-danger">{{ __('Go to List') }}</span></a>
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
    @else
        <h1>{{ __('Nothing to show!') }}</h1>
    @endif
@endsection
