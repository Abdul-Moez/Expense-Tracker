<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Dashboard - Expense Tracker</title>

    <!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL('assets/img/fav_icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL('assets/bootstrap/bootstrap.min.css') }}">
    <!-- Cutom CSS -->
    <link rel="stylesheet" href="{{ URL('assets/css/style.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ URL('assets/css/animate.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/fontawesome/all.min.css') }}">
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ URL('assets/sweet_alert/sweetalert2.min.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="{{ URL('assets/slick_slider/css/slick.css') }}">


    <!-- Template Assets Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <!-- Template Assets Fontawesome All CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Template Assets Line Awesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/line-awesome.min.css') }}">
    <!-- Template Assets Material CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/material.css') }}">
    <!-- Template Assets Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/font-awesome.min.css') }}">
    <!-- Template Assets Moris CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets//plugins/morris/morris.css') }}">
    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/style.css') }}">
</head>

  <body>

    <div class="main-wrapper">

      <div class="header">

        <div class="header-left">
          <a href="admin-dashboard.html" class="logo">
            <img src="assets/img/logo.png" width="40" height="40" alt="">
          </a>
          <a href="admin-dashboard.html" class="logo2">
            <img src="assets/img/logo.png" width="40" height="40" alt="">
          </a>
        </div>

        <a id="toggle_btn" href="javascript:void(0);">
          <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </a>

        <div class="page-title-box">
          <h3>Expense Tracker</h3>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

        <ul class="nav user-menu">

            <li class="nav-item dropdown has-arrow main-drop">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        <img src="{{ URL('assets/img/user_image.jpg') }}" alt="">
                        <span class="status online"></span>
                    </span>
                    <span>Admin</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="settings.html">Settings</a>
                    <a class="dropdown-item" href="{{ URL('/') }}">Logout</a>
                </div>
            </li>
        </ul>


        <div class="dropdown mobile-user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="index.html">Logout</a>
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
              {{-- <li class="submenu">
                <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                <ul style="display: none;">
                  <li><a class="active" href="{{ URL('/dashboard') }}">Dashboard</a></li>
                </ul>
              </li> --}}
              <li class="active">
                <a href="{{ URL('/dashboard') }}"><i class="fas fa-dashboard fa-xl"></i> <span>Dashboard</span></a>
              </li>
              <li class="">
                <a href="{{ URL('/income') }}"><i class="fas fa-money-bill-trend-up fa-xl"></i> <span>Income</span></a>
              </li>
              <li class="">
                <a href="{{ URL('/expense') }}"><i class="fas fa-money-bill-transfer fa-xl"></i> <span>Expense</span></a>
              </li>
              <li class="">
                <a href="{{ URL('/bank_accounts') }}"><i class="fas fa-building-columns fa-xl"></i> <span>Bank Accounts</span></a>
              </li>
              <li class="">
                <a href="{{ URL('/category') }}"><i class="fas fa-shapes fa-xl"></i> <span>Category</span></a>
              </li>
            </ul>
          </div>
        </div>
      </div>


      <div class="page-wrapper">

        <div class="content container-fluid">

          <div class="page-header">
            <div class="row">
              <div class="col-sm-12">
                <h3 class="page-title">Welcome Admin!</h3>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
              <div class="card dash-widget">
                <div class="card-body">
                  <span class="dash-widget-icon"><i class="fa fa-coins"></i></span>
                  <div class="dash-widget-info">
                    <h3>44</h3>
                    <span>Total Balance</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
              <div class="card dash-widget">
                <div class="card-body">
                  <span class="dash-widget-icon text-danger"><i class="fas fa-angles-down"></i></span>
                  <div class="dash-widget-info">
                    <h3>112</h3>
                    <span>Monthly Expense</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
              <div class="card dash-widget">
                <div class="card-body">
                  <span class="dash-widget-icon text-success"><i class="fa fa-angles-up"></i></span>
                  <div class="dash-widget-info">
                    <h3>37</h3>
                    <span>Monthly Income</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
              <div class="card dash-widget">
                <div class="card-body">
                  <span class="dash-widget-icon"><i class="fa fa-wallet"></i></span>
                  <div class="dash-widget-info">
                    <h3>218</h3>
                    <span>Cash On Hand</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 d-flex">
              <div class="card card-table flex-fill">
                <div class="card-header">
                  <h3 class="card-title mb-0">Recent Expense</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-nowrap custom-table mb-0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Account</th>
                          <th>Category</th>
                          <th>Amount</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0001</a></td>
                          <td>
                            <h2><a href="#">Global Technologies</a></h2>
                          </td>
                          <td>11 Mar 2019</td>
                          <td>$380</td>
                          <td>
                            <span class="badge bg-inverse-warning">Partially Paid</span>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0002</a></td>
                          <td>
                            <h2><a href="#">Delta Infotech</a></h2>
                          </td>
                          <td>8 Feb 2019</td>
                          <td>$500</td>
                          <td>
                            <span class="badge bg-inverse-success">Paid</span>
                          </td>
                        </tr>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0003</a></td>
                          <td>
                            <h2><a href="#">Cream Inc</a></h2>
                          </td>
                          <td>23 Jan 2019</td>
                          <td>$60</td>
                          <td>
                            <span class="badge bg-inverse-danger">Unpaid</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 d-flex">
              <div class="card card-table flex-fill">
                <div class="card-header">
                  <h3 class="card-title mb-0">Recent Income</h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table custom-table table-nowrap mb-0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Account</th>
                          <th>Source</th>
                          <th>Amount</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0001</a></td>
                          <td>
                            <h2><a href="#">Global Technologies</a></h2>
                          </td>
                          <td>Paypal</td>
                          <td>11 Mar 2019</td>
                          <td>$380</td>
                        </tr>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0002</a></td>
                          <td>
                            <h2><a href="#">Delta Infotech</a></h2>
                          </td>
                          <td>Paypal</td>
                          <td>8 Feb 2019</td>
                          <td>$500</td>
                        </tr>
                        <tr>
                          <td><a href="invoice-view.html">#INV-0003</a></td>
                          <td>
                            <h2><a href="#">Cream Inc</a></h2>
                          </td>
                          <td>Paypal</td>
                          <td>23 Jan 2019</td>
                          <td>$60</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="{{ URL('/assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- Font Awesome JS -->
    <script src="{{ URL('/assets/fontawesome/all.min.js') }}"></script>
    <!-- jQuery File -->
    <script src="{{ URL('/assets/js/jquery_3.6.3.min.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ URL('/assets/js/script.js') }}"></script>
    <!-- Sweet Alert Js -->
    <script src="{{ URL('/assets/sweet_alert/sweetalert2.min.js') }}"></script>
    <!-- Slick Slider Js -->
    <script src="{{ URL('/assets/slick_slider/js/slick.min.js') }}"></script>


    <!-- Template Assets Layout Js -->
    <script src="{{ URL('assets/template_assets/js/layout.js') }}"></script>
    <!-- Template Assets Theme Settings Js -->
    <script src="{{ URL('assets/template_assets/js/theme-settings.js') }}"></script>
    <!-- Template Assets Slim Scroll Js -->
    <script src="{{ URL('assets/template_assets/js/jquery.slimscroll.min.js') }}"></script>
    <!-- Template Assets Greedy Nav Js -->
    <script src="{{ URL('assets/template_assets/js/greedynav.js') }}"></script>
    <!-- Template Assets Morris Js -->
    <script src="{{ URL('assets/template_assets/plugins/morris/morris.min.js') }}"></script>
    <!-- Template Assets Raphael Js -->
    <script src="{{ URL('assets/template_assets/plugins/raphael/raphael.min.js') }}"></script>
    <!-- Template Assets Chart Js -->
    <script src="{{ URL('assets/template_assets/js/chart.js') }}"></script>
    <!-- Template Assets App Js -->
    <script src="{{ URL('assets/template_assets/js/app.js') }}"></script>

  </body>

</html>