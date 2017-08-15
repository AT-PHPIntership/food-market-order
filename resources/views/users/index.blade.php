@extends('layouts.master')
@section('main-header')
    <h1>
        {{ __('List Users page') }}
        <small></small>
    </h1>
@endsection
@section('main-content')

    @include('flash::message')

    @if(isset($users))
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ __("User's Table Data") }}</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary pull-right">
                    <i class=" fa fa-plus"></i>
                </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="table_wrapper" class="table-responsive form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table" class=" table table-striped dataTable table-hover"
                                   role="grid"
                                   aria-describedby="table_info">
                                <thead>
                                <tr>
                                    <th class="col-md-1">{{ __('id') }}</th>
                                    <th class="col-md-3">{{ __('Name') }}</th>
                                    <th class="col-md-3">{{ __('Email') }}</th>
                                    <th class="col-md-1">{{ __('Gender') }}</th>
                                    <th class="col-md-1">{{ __('Admin') }}</th>
                                    <th class="col-md-1">{{ __('Active') }}</th>
                                    <th class="col-md-2">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->gender == 1) ? __('Male') : __('Female')}}</td>
                                        <td><i class="fa fa-certificate {{ ($user->is_admin == 1) ? 'admin':'normal' }}"></i>
                                        </td>
                                        <td><i class="fa fa-check {{ ($user->is_active == 1) ? 'active-user':'gray' }}"></i>
                                        </td>
                                        <td><a href="{{ route('users.show', $user->id) }}" class="btn btn-xs btn-info"><i
                                                        class="fa fa-search-plus"></i></a>
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-xs btn-success"><i
                                                        class="fa fa-edit"></i></a>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                  class="inline delete-item">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button class="btn btn-danger btn-xs btn-confirm"
                                                        data-confirm="{{ __('Are you sure to delete this user?') }}"
                                                        data-title="{{ __('Delete User') }}" type="submit">
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
