@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST FOODS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')
    @if(isset($foods))
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{ __('List Food') }}</h3>
            <a href="{{ route('foods.create') }}" class="btn btn-primary btn-xl pull-right">
                <i class=" fa fa-plus"></i>
            </a>
            <div class="col-md-12">
                <div class="col-md-5">
                    <form action="">
                        <div class="col-md 9 pull-left">
                            <div class="form-group">
                                <input class="form-control" type="search" name="search" value="{{ request('search') }}" placeholder="type here for search">
                            </div>
                        </div>
                        <div class="col-md-3 pull-left">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable table-hover"
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
                                    <td><a class="btn btn-info btn-sm " href="{{ route('foods.show', $food->id) }}" alt="{{ __('Detail') }}">
                                            <i class="fa fa-search-plus" ></i>
                                        </a>
                                        <a class="btn btn-success btn-sm " href="{{ route('foods.edit', $food->id) }}" alt="{{ __('Edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('foods.destroy', $food->id) }}" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <button class="btn-sm btn-danger btn btn-confirm"
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
