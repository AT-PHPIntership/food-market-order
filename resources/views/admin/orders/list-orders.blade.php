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
                                <th style="width: 4em">User Name</th>
                                <th style="width: 4em">Create</th>
                                <th style="width: 4em">Update</th>
                                <th style="width: 4em">Transport</th>
                                <th>Address</th>
                                <th style="width: 3em">Payment</th>
                                <th style="width: 1em">Detail</th>
                                <th style="width: 6em">Confirm-Delele</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < 10;)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $userName = 'dungvan '.$i }}</td>
                                    <td>{{ $createAt = '25/07/2017' }}</td>
                                    <td>{{ $updateAt = '25/07/2017' }}</td>
                                    <td>{{ $createAt = '26/07/2017' }}</td>
                                    <td>{{ $address = '23-tran phu-Hoi An' }}</td>
                                    <td>{{ $payment = '25.000' }}</td>
                                    <td><a href="{{ route('detail-order') }}"><span class="glyphicon glyphicon-zoom-in">detail</span></a></td>
                                    <td><button class="btn-xs btn-primary btn">confirm</button><button class="btn-xs btn-danger btn">delete</button></td>
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
