<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Food-market-order</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset("/admin-lte/bootstrap/css/bootstrap.min.css") }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset("/admin-lte/dist/css/AdminLTE.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/admin-lte/dist/css/skins/skin-blue.min.css") }}">
    <link rel="stylesheet" href="{{ asset("/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    @include('admin.includes.header')
    <!-- Left side column. contains the logo and sidebar -->
    @include('admin.includes.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.includes.main-header')

        <!-- Main content -->
        <section class="content">

            <!-- Your Page Content Here -->
            @yield('main-content')

        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('admin.includes.footer')

    @include('admin.includes.header-control')
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset("/admin-lte/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset("/admin-lte/bootstrap/js/bootstrap.min.js") }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/admin-lte/dist/js/app.min.js") }}"></script>

<script src="{{ asset("/admin-lte/plugins/datatables/dataTables.bootstrap.min.js") }}"></script>

<script src="{{ asset("/admin-lte/plugins/datatables/jquery.dataTables.min.js") }}"></script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable();
    $('#example3').DataTable();
  });
</script>

</body>
</html>
