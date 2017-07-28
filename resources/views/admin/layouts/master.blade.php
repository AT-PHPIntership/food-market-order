<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Food-market-order</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('admin.includes.style')

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

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

@include('admin.includes.script')

</body>
</html>
