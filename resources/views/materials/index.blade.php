@extends('layouts.master')
@section('main-header')
    <h1>{{ __('LIST MATERIALS') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')
    @if(isset($materials))
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">{{ __('List Materials') }}</h3>
            <a href="{{ route('materials.create') }}" class="btn btn-primary btn-xl pull-right">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-tools">
                        <form action="" class="pull-left">
                            <div class="input-group input-group-sm search-group">
                                <input class="form-control" type="search" name="search" value="{{ request('search') }}"
                                       placeholder="type here for search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        {{ $materials->links() }}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="table-responsive dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered dataTable table-hover"
                               role="grid" id="table-list-materials">
                            <thead>
                            <tr role="row">
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Supplier') }}</th>
                                <th>{{ __('Price') }}</th>
                                <th>{{ __('Description') }}</th>
                                <th class="col-md-2">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($materials as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->category->name }}</td>
                                    <td>{{ $material->supplier->name }}</td>
                                    <td>{{ $material->price }}</td>
                                    <td>{{ $material->description }}</td>
                                    <td><a class="btn btn-info btn-sm"
                                           href="{{ route('materials.show', $material->id) }}" alt="{{ __('Detail') }}">
                                            <span class="glyphicon glyphicon-zoom-in" ></span>
                                        </a>
                                        <a class="btn btn-success btn-sm"
                                           href="{{ route('materials.edit', $material->id) }}" alt="{{ __('Edit') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('materials.destroy', $material->id) }}" class="inline">
                                            {!! csrf_field() !!}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="material_id" value="{{ $material->id }}">
                                            <button class="btn-sm btn-danger btn btn-confirm"
                                                    data-confirm="{{ __('Are you sure delete Material?') }}"
                                                    data-title="{{ __('Delete Material') }}">
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
    </div>
    @else
        <h1>{{ __('NOTHINH TO SHOW') }}</h1>
    @endif

    @include('layouts.partials.modal')
@endsection
