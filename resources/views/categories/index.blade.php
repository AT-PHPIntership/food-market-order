@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List Categories</h3>
            <button id="btn-add-category" class="btn btn-primary" href="{{ route('categories.create') }}" style="float: right" title="Add Category">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="list-category-wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="list-category" class="table table-bordered table-striped dataTable table-hover" role="grid"
                               aria-describedby="list-category-info">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">ID</th>
                                <th style="width: 7em">Name</th>
                                <th>Description</th>
                                <th style="width: 8em">Edit</th>
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
                                        <a id="btn-edit-category" class="btn btn-xs btn-success" href="{{ route('categories.edit', ['id' => $category->id])}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <form role="form" action="{{ route('categories.destroy', ['id' => $category->id])}}"
                                              method="post" onsubmit="return confirmDelete()">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button class="btn-xs btn-danger btn" id="btn-delete-category">
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
    <script>
        function confirmDelete()
        {
            var x = confirm("Are you sure you want to delete?");
            if (x)
                return true;
            else
                return false;
        }

    </script>
@endsection
