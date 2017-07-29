@extends('admin.layouts.master')

@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable table-hover" role="grid"
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
                            @for($i = 0; $i < 10;)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $fullName = 'Dung Van '.$i }}</td>
                                    <td>{{ $email = 'abc@example.com' }}</td>
                                    <td>{{ $birthDay = '25/12/1994'  }}</td>
                                    <td>{{ $gender = (1 == 1) ? 'Male' : 'Female'}}</td>
                                    <td>{{ $address = str_random(20) }}</td>
                                    <td><span class="glyphicon glyphicon-ok" style="color: {{ $isActive = (1 == 1) ? '#00ff00':'gray' }}"></span></td>
                                    <td><a href="{{ route('detail-user') }}"><span class="glyphicon glyphicon-zoom-in">detail</span></a> - <a
                                                href="{{ route('update-user') }}"><span class="glyphicon glyphicon-pencil">edit</span></a></td>
                                    <td><button class="btn-xs btn-danger btn">delete</button></td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
