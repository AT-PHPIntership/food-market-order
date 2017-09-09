@extends('layouts.master')

@section('main-content')
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">
                @if((!empty($date))||(session()->has('date')))
                    {{ _('Add Item For') }} {{ $date }}{!! session('date') !!}
                @else
                    {{ _('Create New Menu Item')}}
                @endif
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="tab_logic">
                    <thead>
                    <tr>
                        <th class="text-center col-xs-5">
                            {{ __('Category') }}
                        </th>
                        <th class="text-center col-xs-5">
                            {{ __('Food') }}
                        </th>
                        <th class="text-center col-xs-1">
                            {{ __('Quantity') }}
                        </th>
                        <th class="text-center col-xs-1">
                        </th>
                    </tr>
                    </thead>
                    <form id="create-menu" method="POST" action="{{ route('daily-menus.store') }}" data-title="{{ __('Create New Menu') }}" data-error="{{ __('Has error during create menu item, Are you sure that fill valid value into box?') }}">
                        {{ csrf_field() }}
                        <div class="form-group col-xs-4">
                            <label for="chooser-date">{{ _('Choose Date') }}: </label>
                            @if(empty($date))
                                <input type="date" class="form-control" id="chooser-date" name="date" required>
                        </div>
                        @else
                            <input type="date" class="form-control" id="chooser-date" name="date" value="{{ $date }}">
            </div>
            <a href="{{ route('daily-menus.show', $date) }}" class="pull-right">
                <span class="btn-xl btn-primary btn">{{ _('Show Menu') }}</span>
            </a>
            @endif
            <tbody id="create-menu-table">
            <tr>
                <td>
                    <select class="form-control select-category required" id="select-category" required>
                        <option value=''>{{ __('Choose category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control select-food required" name="food_id[]" id="select-food" placeholder="{{ __('Choose Food') }}" form="create-menu" required>
                        <option value=''>{{ __('Choose food') }}</option>
					</select>
                </td>
                <td class="text-center">
                    <input type="number" class="form-control text-center" name="quantity[]" form="create-menu" min="1" required>
                </td>
                <td class="text-center">
                    <span class="btn-xs btn btn-success" id="disable-row" data-title="{{ __('Add New Row')}}" data-message="{{ __('Please fill in all elements') }}"><i class = "glyphicon glyphicon-ok"></i></span>
                    <span class="btn-xs btn btn-primary" id="add-row" data-title="{{ __('Add New Row') }}" data-message="{{ __('Please finish your choose') }}"><i class = "glyphicon glyphicon-plus"></i></span>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-3 col-md-4">
            <span class="btn-xl btn-danger btn" id="clear-input"> {{ __('Cancel') }}</span>
        </div>
        <div class="col-md-offset-1 col-md-4">
            <input type="submit" id="add-row" class="btn btn-primary"
                   value="{{ __('Add To Menu') }}">
        </div>
    </div>
    </form>
@endsection
@include('layouts.partials.modal')
