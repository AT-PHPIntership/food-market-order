@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST CATEGORIES PAGE') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{__("Category's Table Data")}}</h3>
            <a id="btn-add-category" class="btn btn-primary pull-right" href="{{ route('categories.create') }}"
               title="{{__('Add Category')}}">
                <i class="fa fa-plus "></i>
            </a>
            <div class="col-md-12">
                <div class="col-md-5">
                    <form action="">
                        <div class="col-md 9 pull-left">
                            <div class="form-group">
                                <input class="form-control" type="search" name="search" value="{{ request('search') }}">
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
        <!-- /.box-header -->
        <div class="box-body">
            <div class=" table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable table-hover"
                               role="grid"
                               aria-describedby="list-category-info">
                            <thead>
                            <tr role="row">
                                <th class="col-md-1">{{__('ID')}}</th>
                                <th class="col-md-2">{{__('Name')}}</th>
                                <th class="col-md-8">{{__('Description')}}</th>
                                <th class="col-md-1">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name  }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-edit-item "
                                           href="{{ route('categories.edit', $category->id)}}"
                                           title="{{__('Edit Category')}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form role="form" class="delete-item inline"
                                              action="{{ route('categories.destroy', $category->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button class="btn-sm btn-danger btn btn-confirm"
                                                    data-confirm="{{__('Are you want delete it?')}}"
                                                    data-title="{{__('Delete Category')}}">
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
        </div>
        <div class="box-footer">
            {{ $categories->links() }}
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
