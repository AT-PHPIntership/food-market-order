@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST SUPPLIERS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{ __('List Suppliers') }}</h3>
            <a id="btn-add-supplier" class="btn btn-primary pull-right" href="{{ route('suppliers.create') }}"
               title="{{ __('Add Supplier') }}">
                <i class="fa fa-plus"></i>
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
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable table-hover"
                               role="grid"
                               aria-describedby="list-suppliers-info">
                            <thead>
                            <tr role="row">
                                <th class = "col-md-1">{{ __('ID') }}</th>
                                <th class = "col-md-3">{{ __('Name') }}</th>
                                <th class = "col-md-7">{{ __('Description') }}</th>
                                <th class = "col-md-1">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td>{{ $supplier->name  }}</td>
                                    <td>{{ $supplier->description }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success btn-edit-item"
                                           href="{{ route('suppliers.edit', $supplier->id) }}"
                                           title="{{ __('Edit Supplier') }}">
                                            <i class=" fa fa-edit"></i>
                                        </a>
                                        <form role="form" class="delete-item inline"
                                              action="{{  route('suppliers.destroy', $supplier->id) }}"
                                              method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn-sm btn-danger btn btn-confirm"
                                                    data-confirm="{{ __('Are you want delete it?') }}"
                                                    data-title="{{ __('Delete Supplier') }}"
                                                    title="{{ __('Delete Supplier') }}">
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
            {{ $suppliers->links() }}
        </div>
    </div>
    @include('layouts.partials.modal')
@endsection
