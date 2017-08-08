@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('foods/listfoods.title') }}</h3>
            <a href="{{ route('foods.create') }}" class="btn btn-primary btn-xl pull-right fa fa-plus"> {{ trans('foods/listfoods.add-food') }}</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable table-hover"
                               role="grid">
                            <thead>
                            <tr role="row">
                                <th class="col-md-1">{{ trans('foods/listfoods.id') }}</th>
                                <th class="col-md-2">{{ trans('foods/listfoods.name') }}</th>
                                <th class="col-md-2">{{ trans('foods/listfoods.category') }}</th>
                                <th class="col-md-1">{{ trans('foods/listfoods.price') }}</th>
                                <th class="col-md-4">{{ trans('foods/listfoods.description') }}</th>
                                <th class="col-md-2">{{ trans('foods/listfoods.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php ($i = 1)
                            @foreach($foods as $food)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->categories->name }}</td>
                                    <td>{{ $food->price }}</td>
                                    <td>{{ $food->description }}</td>
                                    <td><a href="{{ route('foods.show', $food->id) }}" alt="detail"><span
                                                    class="glyphicon glyphicon-zoom-in btn btn-default btn-xs pull-left" ></span>
                                        </a>
                                        <a href="{{ route('foods.edit', $food->id) }}" alt="edit"><span
                                                    class="glyphicon glyphicon-pencil btn btn-default btn-xs pull-left"></span>
                                        </a>
                                        <form method="POST" action="{{ route('foods.destroy', $food->id) }}" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="food_id" value="{{ $food->id }}">
                                            <button class="btn-xs btn-danger btn btn-confirm-delete"
                                                data-confirm="{{ trans('foods/list.data_confirm') }}">
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
            {{ $foods->links() }}
        </div>
    </div>
@endsection
