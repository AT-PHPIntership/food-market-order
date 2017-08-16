@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('List Materials') }}</h3>
            <a href="{{ route('materials.create') }}" class="btn btn-primary btn-xl pull-right"> {{ __('Add Material') }}</a>
        </div>
        @include('flash::message')
        @if(isset($materials))
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover"
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
            {{ $materials->links() }}
        </div>
        @else
        <h1>{{ __('NOTHINH TO SHOW') }}</h1>
        @endif
    </div>
    @include('layouts.partials.modal')
@endsection
