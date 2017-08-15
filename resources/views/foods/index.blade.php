@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST FOODS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('List Food') }}</h3>
            <a href="{{ route('foods.create') }}" class="btn btn-primary btn-xl pull-right">
                <i class=" fa fa-plus"></i>
            </a>
        </div>
        @include('flash::message')
        @if(isset($foods))
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-responsive table-striped dataTable table-hover"
                               role="grid">
                            <thead>
                            <tr role="row">
                                <th class="col-md-1">{{ __('ID') }}</th>
                                <th class="col-md-2">{{ __('Name') }}</th>
                                <th class="col-md-2">{{ __('Category') }}</th>
                                <th class="col-md-1">{{ __('Price') }}</th>
                                <th class="col-md-4">{{ __('Description') }}</th>
                                <th class="col-md-2">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($foods as $food)
                                <tr>
                                    <td>{{ $food->id }}</td>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->category->name }}</td>
                                    <td>{{ $food->price }}</td>
                                    <td>{{ $food->description }}</td>
                                    <td><a class="btn btn-info btn-xs " href="{{ route('foods.show', $food->id) }}" alt="{{ __('Detail') }}">
                                            <i class="fa fa-search-plus" ></i>
                                        </a>
                                        <a class="btn btn-success btn-xs " href="{{ route('foods.edit', $food->id) }}" alt="{{ __('Edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('foods.destroy', $food->id) }}" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <button class="btn-xs btn-danger btn btn-confirm"
                                                    data-confirm="{{ __('Are you sure delete food?') }}"
                                                    data-title="Delete Food">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{ $foods->links() }}
        </div>
        @else
        <h1>{{ __('NO DATA') }}</h1>
        @endif
    </div>
    @include('layouts.partials.modal')
@endsection
