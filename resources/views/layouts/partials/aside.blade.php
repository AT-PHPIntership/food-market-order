<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->image }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                @if(Auth::guest())
                    {{ route('login') }}
                @else
                    <p>{{ Auth::user()->full_name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ __('Online') }}</a>
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
            <li class="header">{{ __('MAIN NAVIGATION') }}</li>
            <li class="active">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>{{ __('Dashboard') }}</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
            <li class="treeview @if(!Request::is('dashboard')) active @endif">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>{{ __('Management') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="@if(Request::is('users', 'users/*')) active @endif"><a href="{{ route('users.index') }}"><i class="fa fa-users"></i>{{ __('Users Management') }}</a></li>
                    <li class="@if(Request::is('categories', 'categories/*')) active @endif"><a href="{{ route('categories.index') }}"><i class="fa fa-shoping-backet"></i>{{ __('Categories Management') }}</a></li>
                    <li class="@if(Request::is('suppliers', 'suppliers/*')) active @endif"><a href="{{ route('suppliers.index') }}"><i class="fa fa-circle-o"></i>{{ __('Suppliers Management') }}</a></li>
                    <li class="@if(Request::is('orders', 'orders/*')) active @endif"><a href="{{ route('orders.index') }}"><i class="fa fa-circle-o"></i>{{ __('Orders Management') }}</a></li>
                    <li class="@if(Request::is('daily-menus', 'daily-menus/*')) active @endif"><a href="{{ route('daily-menus.index') }}"><i class="fa fa-circle-o"></i>{{ __('Daily Menu Management') }}</a></li>
                    <li class="@if(Request::is('foods', 'foods/*')) active @endif"><a href="{{ route('foods.index') }}"><i class="fa fa-circle-o"></i>{{ __('Food Management') }}</a></li>
                    <li class="@if(Request::is('materials', 'materials/*')) active @endif"><a href="{{ route('materials.index') }}"><i class="fa fa-circle-o"></i>{{ __('Material Management') }}</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#">
                    <i class="fa fa-pie-chart"></i> <span>{{ __('Statistical') }}</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
