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
                        <th class="text-center col-xs-4">
                            {{ _('Category') }}
                        </th>
                        <th class="text-center col-xs-4">
                            {{ _('Food') }}
                        </th>
                        <th class="text-center col-xs-4">
                            {{ _('Quantity') }}
                        </th>
                    </tr>
                    </thead>
                    <form id="create-menu" method="POST" action="{{ route('daily-menus.store') }}">
                        {{ csrf_field() }}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session()->has('message.level'))
                            <div class="alert alert-{{ session('message.level') }}">
                                {!! session('message.content') !!}
                            </div>
                        @endif
                        <div class="form-group col-xs-4">
                            <label for="chooser-date">{{ _('Choose Date') }}: </label>
                            @if(empty($date))
                                <input type="date" class="form-control" id="chooser-date" name="date">
                        </div>
                        @else
                            <input type="date" class="form-control" id="chooser-date" name="date" value="{{ $date }}">
            </div>
            <a href="{{ route('daily-menus.show', $date) }}" class="pull-right">
                <span class="btn-xl btn-primary btn">{{ _('Show Menu') }}</span>
            </a>
            @endif
            <tbody id='myBody'>
            <tr>
                <td>
                    <select class="form-control" id="select-category">
                        <option>{{ __('Choose category') }}</option>
                        @foreach ($listCategory as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <p class="form-control" id="choose-food"
                       data-text="{{ _('Click here to choose food') }}">{{ _('Click here to choose food') }}</p>
                    <select class="form-control" id="select-food" name="food_id" form="create-menu" size="5">
                    </select>
                </td>
                <td id="quantityselect">
                    <input type="number" class="form-control" name="quantity"/>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-md-offset-3 col-md-4">
            <a href="{{ route('daily-menus.index') }}"><span class="btn-xl btn-danger btn">{{ __('Cancel') }}</span></a>
        </div>
        <div class="col-md-offset-1 col-md-4">
            <input type="submit" id="add-row" class="btn btn-primary"
                   value="{{ __('Add To Menu') }}">
        </div>
        </form>
    </div>
@endsection
