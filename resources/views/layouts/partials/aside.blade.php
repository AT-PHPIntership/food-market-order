<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if(Auth::guest())
                    {{ route('login') }}
                @else
                    <p>{{ Auth::user()->full_name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                @endif
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Users Management</a></li>
                    <li><a href="{{ route('categories.index') }}"><i class="fa fa-circle-o"></i> Categories Management</a></li>
                    <li><a href="{{ route('orders.index') }}"><i class="fa fa-circle-o"></i> Orders Management</a></li>
                    <li><a href="{{ route('dailymenus.index') }}"><i class="fa fa-circle-o"></i> Daily Menu Management</a></li>
                    <li><a href="{{ route('foods.index') }}"><i class="fa fa-circle-o"></i> Food Management</a></li>
                    <li><a href="{{ route('materials.index') }}"><i class="fa fa-circle-o"></i> Material Management</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>Statistical</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
