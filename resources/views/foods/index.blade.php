@extends('layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ trans('foods/listfoods.title') }}</h3>
            <a href="{{ route('foods.create') }}" class="btn btn-primary btn-xl pull-right fa fa-plus"> {{ trans('foods/listfoods.add-food') }}</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable table-hover"
                               role="grid"
                               aria-describedby="example1_info">
                            <thead>
                            <tr role="row">
                                <th style="width: 1em">{{ trans('foods/listfoods.id') }}</th>
                                <th style="width: 7em">{{ trans('foods/listfoods.name') }}</th>
                                <th style="width: 7em">{{ trans('foods/listfoods.category') }}</th>
                                <th style="width: 3em">{{ trans('foods/listfoods.price') }}</th>
                                <th >{{ trans('foods/listfoods.description') }}</th>
                                <th style="width: 5em">{{ trans('foods/listfoods.image') }}</th>
                                <th style="width: 4em">{{ trans('foods/listfoods.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php ($i = 1)
                            @foreach($foods as $food)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->category_name }}</td>
                                    <td>{{ $food->price }}</td>
                                    <td>{{ $food->description }}</td>
                                    <td><image src="images/foods/{{ $food->image }}"></td>
                                    <td><a href="{{ route('foods.show', $food->id) }}" alt="detail"><span
                                                    class="glyphicon glyphicon-zoom-in btn btn-default btn-xs pull-left" ></span>
                                        </a>
                                        <a href="{{ route('foods.edit', $food->id) }}" alt="edit"><span
                                                    class="glyphicon glyphicon-pencil btn btn-default btn-xs pull-left"></span>
                                        </a>
                                        <form method="POST" action="{{ route('foods.destroy', $food->id) }}" class="inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="user_id" value="{{ $food->id }}">
                                            <button class="btn-xs btn-danger btn btn-delete-item fa fa-trash                                             pull-right" type="submit"></button>
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
