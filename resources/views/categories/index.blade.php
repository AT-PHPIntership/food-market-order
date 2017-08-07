@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{trans('category.header-list')}}</h3>
            <a id="btn-add-category" class="btn btn-primary pull-right" href="{{ route('categories.create') }}"
               title="Add Category">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="list-category-wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="list-category" class="table table-bordered table-striped dataTable table-hover"
                               role="grid"
                               aria-describedby="list-category-info">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">{{trans('category.columns_id')}}</th>
                                <th style="width: 7em">{{trans('category.columns_name')}}</th>
                                <th>{{trans('category.columns_description')}}</th>
                                <th style="width: 5em">{{trans('category.columns_action')}}</th>
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
                                           href="{{ route('categories.edit', $category->id)}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a> -
                                        <form role="form" class="delete-item pull-left"
                                              action="{{ route('categories.destroy', $category->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        </form>
                                        <button class="btn-xs btn-danger btn btn-delete-item">
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
        </div>
    </div>
@endsection
@section('custom-js')
    <script src="{{ asset("/js/common.js") }}"></script>
@endsection
