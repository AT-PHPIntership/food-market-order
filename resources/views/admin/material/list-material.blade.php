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
                                <th style="width: 7em">material Name</th>
                                <th style="width: 7em">Category Name</th>
                                <th style="width: 5em">From</th>
                                <th>Description</th>
                                <th style="width: 3em">Price</th>
                                <th style="width: 8em">Detail - Edit</th>
                                <th style="width: 1em">Delele</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i < 10;)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $materialName = 'fish-fish-fish '.$i }}</td>
                                    <td>{{ $categoryName = 'canh cá '.$i  }}</td>
                                    <td>{{ $from = 'đà lạt '.$i }}</td>
                                    <td>this is description</td>
                                    <td>{{ 10.000 }}</td>
                                    <td><a href="{{ route('detail-material') }}"><span class="glyphicon glyphicon-zoom-in">detail</span></a> - <a
                                                href="{{ route('edit-material') }}"><span class="glyphicon glyphicon-pencil">edit</span></a></td>
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
