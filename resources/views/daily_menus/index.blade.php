@extends('layouts.master')
@section('main-content')
    <div class="box">
        <div class="box-header">
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <h3 class="box-title"><strong>Daily Menu List</strong></h3>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <a href="{{ route('dailymenu.create') }}" class="btn btn-xl btn-primary" style="float: right">
                            Create New Daily Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable table-hover text-center" role="grid"
                               >
                            <thead>
                            <tr role="row">
                                <th style="width: 8em">Date</th>
                                <th style="width: 1em">Detail</th>
                                <th style="width: 1em">Edit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($listDailyMenu as $dailyMenu)
                                <tr>
                                    <td><h4>{{ $dailyMenu->date }}</h4></td>
                                    <td>
                                        <a href="{{ route('dailymenu.show', ['date' => $dailyMenu->date]) }}"><span class="btn-xl btn-success btn">Detail</span></a>
                                    </td>
                                    <td>
                                        <a href="{{ route('dailymenu.edit', ['date' => $dailyMenu->date]) }}"><span class="btn-xl btn-warning btn">Edit</span></a>
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
