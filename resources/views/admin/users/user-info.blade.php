@extends('admin.layouts.master')
@section('main-content')
    <div class="container bootstrap snippet">
        <div class="panel-body inf-content">
            <div class="row">
                <div class="col-md-4">
                    <img alt="" style="width:600px;" title="" class="img-circle img-thumbnail isTooltip"
                         src="https://bootdey.com/img/Content/user-453533-fdadfd.png" data-original-title="Usuario">
                    <ul title="Ratings" class="list-inline ratings text-center">
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-star"></span></a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <strong>Information</strong><br>
                    <div class="table-responsive">
                        <table class="table table-condensed table-responsive table-user-information">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-asterisk text-primary"></span>
                                        Identificacion
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    123456789
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-user  text-primary"></span>
                                        Full Name
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    Bootdey
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-bookmark text-primary"></span>
                                        Gender
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    Male
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-eye-open text-primary"></span>
                                        Role
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    User
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-envelope text-primary"></span>
                                        Email
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    noreply@email.com
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        Birthday
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    20 jul 20014
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-home text-primary"></span>
                                        Address
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    K82 Nguyen Luong Bang
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-phone text-primary"></span>
                                        Phone Number
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    0123456789
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        created
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    20 jul 20014
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-calendar text-primary"></span>
                                        Updated
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    20 jul 20014 20:00:00
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>
                                        <span class="glyphicon glyphicon-shopping-cart text-primary"></span>
                                        Total Ordered
                                    </strong>
                                </td>
                                <td class="text-primary">
                                    4
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-11">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Order History</h3>

                                <div class="box-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="table_search" class="form-control pull-right"
                                               placeholder="Search">

                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>ID</th>
                                        <th>Ordered at</th>
                                        <th>Status</th>
                                        <th>Custom Address</th>
                                        <th>Payment</th>
                                    </tr>
                                    <tr>
                                        <td>183</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-success">Approved</span></td>
                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                        <td>$55.4</td>
                                    </tr>
                                    <tr>
                                        <td>219</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-warning">Pending</span></td>
                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                        <td>$69</td>
                                    </tr>
                                    <tr>
                                        <td>657</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-success">Approved</span></td>
                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                        <td>$96</td>
                                    </tr>
                                    <tr>
                                        <td>175</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-danger">Canceled</span></td>
                                        <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                                        <td>$35</td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection