@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST CATEGORIES PAGE') }}
    <small></small>
    </h1>
@endsection
@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{__("Category's Table Data")}}</h3>
            <a id="btn-add-category" class="btn btn-primary pull-right" href="{{ route('categories.create') }}"
               title="{{__('Add Category')}}">
                <i class="fa fa-plus "></i>
            </a>
        </div>
        @include('flash::message')
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-responsive table-striped dataTable table-hover"
                               role="grid"
                               aria-describedby="list-category-info">
                            <thead>
                                <tr role="row">
                                    <th class="col-md-1">{{__('ID')}}</th>
                                    <th class="col-md-2">{{__('Name')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th class="col-md-2">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name  }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-success btn-edit-item " href="{{ route('categories.edit', $category->id)}}"
                                           title="{{__('Edit Category')}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form role="form" class="delete-item inline" action="{{ route('categories.destroy', $category->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button class="btn-xs btn-danger btn btn-confirm"
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
            {{ $categories->links() }}
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
