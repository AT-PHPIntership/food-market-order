@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{__('List Categories')}}</h3>
            <a id="btn-add-category" class="btn btn-primary pull-right" href="{{ route('categories.create') }}"
               title="{{__('Add Category')}}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        @include('flash::message')
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover"
                               role="grid"
                               aria-describedby="list-category-info">
                            <thead>
                                <tr role="row">
                                    <th style="width: 1em">{{__('ID')}}</th>
                                    <th style="width: 7em">{{__('Name')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th style="width: 5em">{{__('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name  }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-success btn-edit-item"
                                           href="{{ route('categories.edit', $category->id)}}"
                                           title="{{__('Edit Category')}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a> -
                                        <form role="form" class="delete-item pull-left"
                                              action="{{ route('categories.destroy', $category->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        </form>
                                        <button class="btn-xs btn-danger btn btn-confirm-delete"
                                                data-confirm="{{__('Are you want delete it?')}}"
                                                title="{{__('Delete Category')}}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
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
@endsection
