@extends('layouts.master')

@section('main-content')

    @include('flash::message')

    @if(!isset($listUsers))
        <h1>Nothing to show</h1>
    @else
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Data Table With Full Features</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-xl pull-right glyphicon glyphicon-plus"> Add new user</a>
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
                                    <th style="width: 1em">ID</th>
                                    <th style="width: 10em">Full Name</th>
                                    <th style="width: 10em">E-Mail</th>
                                    <th style="width: 5em">Birthday</th>
                                    <th style="width: 2em">Gender</th>
                                    <th>Address</th>
                                    <th style="width: 1em">Status</th>
                                    <th style="width: 6em">Detail-Edit</th>
                                    <th style="width: 1em">Delele</th>
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
                                                        class="glyphicon glyphicon-zoom-in">detail</span></a> - <a
                                                    href="{{ route('users.edit', $user->id) }}"><span
                                                        class="glyphicon glyphicon-pencil">edit</span></a></td>
                                        <td>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button class="btn btn-danger btn-xs" onclick="return confirm('Are you really want to delete this user?');" type="submit">Delete</button>
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
    @endif
@endsection