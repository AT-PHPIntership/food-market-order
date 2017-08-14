@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('List Food') }}</h3>
            <a href="{{ route('foods.create') }}" class="btn btn-primary btn-xl pull-right"> {{ __('Add Food') }}</a>
        </div>
        @include('flash::message')
        @if(isset($foods))
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover"
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
                                    <td><a class="btn btn-info btn-sm"
                                           href="{{ route('foods.show', $food->id) }}" alt="{{ __('Detail') }}">
                                            <span class="glyphicon glyphicon-zoom-in" ></span>
                                        </a>
                                        <a class="btn btn-success btn-sm"
                                           href="{{ route('foods.edit', $food->id) }}" alt="{{ __('Edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('foods.destroy', $food->id) }}" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <button class="btn-sm btn-danger btn btn-confirm-delete"
                                                data-confirm="{{ __('Are you sure delete food?') }}">
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
@endsection
