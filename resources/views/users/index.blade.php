@extends('layouts.master')

@section('main-content')

    @include('flash::message')

    @if(isset($users))
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ __("User's Table Data") }}</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary pull-right fa fa-plus">{{ __('Add new user') }}</a>
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
                                    <th style="width: 1em">{{ __('id') }}</th>
                                    <th style="width: 10em">{{ __('Full Name') }}</th>
                                    <th style="width: 10em">{{ __('Email') }}</th>
                                    <th style="width: 5em">{{ __('Birthday') }}</th>
                                    <th style="width: 2em">{{ __('Gender') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th style="width: 1em">{{ __('Status') }}</th>
                                    <th style="width: 4em">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->birthday }}</td>
                                        <td>{{ ($user->gender == 1) ? __('Male') : __('Female')}}</td>
                                        <td>{{ $user->address }}</td>
                                        <td><span class="glyphicon glyphicon-ok"
                                                  style="color: {{ ($user->is_active == 1) ? '#00ff00':'gray' }}"></span>
                                        </td>
                                        <td><a href="{{ route('users.show', $user->id) }}"><span
                                                        class="glyphicon glyphicon-zoom-in btn btn-xs btn-default pull-left"></span></a>
                                            <a href="{{ route('users.edit', $user->id) }}"><span
                                                        class="fa fa-edit btn btn-xs btn-default pull-left"></span></a>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline delete-item">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button class="btn btn-danger btn-xs pull-right fa fa-trash btn-confirm-delete" data-confirm="{{ __('Are you sure to delete this user?') }}" type="submit"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h1>{{ __('Nothing to show!') }}</h1>
    @endif
@endsection
