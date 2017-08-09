@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{__('List Suppliers')}}</h3>
            <a id="btn-add-supplier" class="btn btn-primary pull-right" href="{{ route('suppliers.create') }}"
               title="{{__('Add Suppliers')}}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover"
                               role="grid"
                               aria-describedby="list-suppliers-info">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">{{__('ID')}}</th>
                                <th style="width: 7em">{{__('Name')}}</th>
                                <th>{{__('Description')}}</th>
                                <th style="width: 5em">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name  }}</td>
                                    <td>{{ $supplier->description }}</td>
                                    <td>
                                        <a class="btn btn-xs btn-success btn-edit-item"
                                           href="{{ route('suppliers.edit', $supplier->id)}}"
                                           title="{{__('Edit supplier')}}">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a> -
                                        <form role="form" class="delete-item pull-left"
                                              action="{{ route('suppliers.destroy', $supplier->id)}}"
                                              method="post">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        </form>
                                        <button class="btn-xs btn-danger btn btn-confirm-delete"
                                                data-confirm="{{__('Are you want delete it?')}}"
                                                title="{{__('Delete supplier')}}">
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
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
