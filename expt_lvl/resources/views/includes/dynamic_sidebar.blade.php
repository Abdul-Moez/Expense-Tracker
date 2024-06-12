

@if (app('request')->input('dsh') == null)

<div class="main-wrapper">

    <div class="header">

        <div class="header-left">
            <a href="{{ URL('/dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" width="40" height="40" alt="">
            </a>
        </div>

        <a id="toggle_btn" href="javascript:void(0);">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

        <ul class="nav user-menu">

            <li class="nav-item dropdown has-arrow main-drop">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img src="{{ asset('assets/img/user_image.jpg') }}" alt="">
                        <span class="status online"></span>
                    </span>
                    <span>{{ session::get('normalUserName') }}</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item logout-btn" href="javascript:void(0)">Logout</a>
                </div>
            </li>
        </ul>


        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item logout-btn" href="javascript:void(0)">Logout</a>
            </div>
        </div>

    </div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul class="sidebar-vertical">
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="{{ request()->getPathInfo() == '/dashboard' ? 'active' : '' }}">
                        <a href="{{ URL('/dashboard') }}"><i class="fas fa-dashboard fa-xl"></i><span>Dashboard</span></a>
                    </li>
                    <li class="{{ request()->getPathInfo() == '/dashboard/income' ? 'active' : '' }}">
                        <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/income?dsh=1') }}"><i class="fas fa-money-bill-trend-up fa-xl"></i> <span>Income</span></a>
                    </li>
                    <li class="{{ request()->getPathInfo() == '/dashboard/expense' ? 'active' : '' }}">
                        <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/expense?dsh=1') }}"><i class="fas fa-money-bill-transfer fa-lg"></i> <span>Expense</span></a>
                    </li>
                    <li class="{{ request()->getPathInfo() == '/dashboard/bank_accounts' ? 'active' : '' }}">
                        <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/bank_accounts?dsh=1') }}"><i class="fas fa-building-columns fa-xl"></i><span>Bank Accounts</span></a>
                    </li>
                    <li class="{{ request()->getPathInfo() == '/dashboard/category' ? 'active' : '' }}">
                        <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/category?dsh=1') }}"><i class="fas fa-shapes fa-xl"></i><span>Category</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="page-wrapper">

@endif