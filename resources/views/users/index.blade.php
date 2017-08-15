@extends('layouts.master')

@section('main-content')

    @include('flash::message')

    @if(isset($users))
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ __("User's Table Data") }}</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary pull-right">
                    {{ __('Add new user') }}
                </a>
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
                                <tr>
                                    <th class="col-md-1">{{ __('id') }}</th>
                                    <th class="col-md-2">{{ __('Full Name') }}</th>
                                    <th class="col-md-2">{{ __('Email') }}</th>
                                    <th class="col-md-2">{{ __('Birthday') }}</th>
                                    <th class="col-md-1">{{ __('Gender') }}</th>
                                    <th class="col-md-2">{{ __('Address') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th class="col-md-2">{{ __('Action') }}</th>
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
                                        <td><a href="{{ route('users.show', $user->id) }}"
                                               class="btn btn-sm btn-info">
                                                <span class="glyphicon glyphicon-zoom-in"></span>
                                            </a>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                               class="btn btn-sm btn-success">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline delete-item">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button class="btn btn-danger btn-sm btn-confirm"
                                                        data-confirm="{{ __('Are you sure to delete this user?') }}"
                                                        data-title="{{ __('Delete User') }}"
                                                        type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
    @include('layouts.partials.modal')
@endsection
