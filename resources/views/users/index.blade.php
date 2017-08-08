@extends('layouts.master')

@section('main-content')

    @include('flash::message')

    @if(!isset($listUsers))
        <h1>{{ trans('user.no_data') }}</h1>
    @else
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ trans('user.data-table') }}</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary pull-right fa fa-plus"> Add new user</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table" class="table table-bordered table-striped dataTable table-hover"
                                   role="grid"
                                   aria-describedby="table_info">
                                <thead>
                                <tr role="row">
                                    <th style="width: 1em">{{ trans('user.id') }}</th>
                                    <th style="width: 10em">{{ trans('user.name') }}</th>
                                    <th style="width: 10em">{{ trans('user.email') }}</th>
                                    <th style="width: 5em">{{ trans('user.birthday') }}</th>
                                    <th style="width: 2em">{{ trans('user.gender') }}</th>
                                    <th>{{ trans('user.address') }}</th>
                                    <th style="width: 1em">{{ trans('user.status') }}</th>
                                    <th style="width: 4em">{{ trans('user.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listUsers as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->birthday }}</td>
                                        <td>{{ ($user->gender == 1) ? 'Male' : 'Female'}}</td>
                                        <td>{{ $user->address }}</td>
                                        <td><span class="glyphicon glyphicon-ok"
                                                  style="color: {{ ($user->is_active == 1) ? '#00ff00':'gray' }}"></span>
                                        </td>
                                        <td><a href="{{ route('users.show', $user->id) }}"><span
                                                        class="glyphicon glyphicon-zoom-in btn btn-xs btn-default pull-left"></span></a>  <a
                                                    href="{{ route('users.edit', $user->id) }}"><span
                                                        class="fa fa-edit btn btn-xs btn-default pull-left"></span></a>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button class="btn btn-danger btn-xs pull-right fa fa-trash" onclick="return confirm('Are you really want to delete this user?');" type="submit"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $listUsers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection