@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
            <button class="btn btn-primary" style="float: right" title="Add Category">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="list_category_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="list_category" class="table table-bordered table-striped dataTable table-hover" role="grid"
                               aria-describedby="list_category_info">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">ID</th>
                                <th style="width: 7em">Name</th>
                                <th>Description</th>
                                <th style="width: 8em">Detail - Edit</th>
                                <th style="width: 1em">Delele</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name  }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-success" href="/categories/{{$category->id}}">
                                            <span class="glyphicon glyphicon-zoom-in"></span>
                                        </a> -
                                        <a class="btn btn-xs btn-warning" href="categories/{{$category->id}}/edit">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <form role="form" action="{{ route('categories.destroy', ['id' => $category->id])}}" method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button class="btn-xs btn-danger btn">
                                                <span class="glyphicon glyphicon-remove"></span>
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
    </div>
@endsection
