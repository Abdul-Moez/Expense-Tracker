<?php use Illuminate\Support\Facades\Session; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Dashboard - Expense Tracker</title>

    <!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/fav_icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <!-- Cutom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ asset('assets/sweet_alert/sweetalert2.min.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="{{ asset('assets/slick_slider/css/slick.css') }}">


    <!-- Template Assets Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <!-- Template Assets Fontawesome All CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Template Assets Line Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/line-awesome.min.css') }}">
    <!-- Template Assets Material CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/material.css') }}">
    <!-- Template Assets Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/font-awesome.min.css') }}">
    <!-- Template Assets Moris CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets//plugins/morris/morris.css') }}">
    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/style.css') }}">
</head>

<body>

    <div id="big_loader" class="d-none my-2 justify-content-center align-items-center loader-body w-100 h-100 position-fixed m-0 top-0 mt-0" style="z-index: 999999">
        <img src="{{ asset('assets/img/loader.gif') }}" class="img-fluid" alt="">
    </div>

    <div class="main-wrapper">

        <div class="header">

            <div class="header-left">
                <a href="{{ URL('/dashboard') }}" class="logo">
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

			{{-- <div class="page-title-box">
                <h3>Expense Tracker</h3>
            </div> --}}

            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

            <ul class="nav user-menu">

                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{ asset('assets/img/user_image.jpg') }}" alt="">
                            <span class="status online"></span>
                        </span>
                        {{-- <span>Admin</span> --}}
                        <span>{{ session::get('normalUserName') }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <!-- <a class="dropdown-item" href="profile.html">My Profile</a> -->
                        <a class="dropdown-item logout-btn" href="javascript:void(0)">Logout</a>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    {{-- <a class="dropdown-item" href="profile.html">My Profile</a> --}}
                    {{-- <a class="dropdown-item" href="profile.html">{{ session::get('normalUserName') }}</a> --}}
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
                        {{-- <li class="submenu">
                            <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a><ul style="display: none;"><li><a class="active" href="{{ URL('/dashboard') }}">Dashboard</a></li></ul>
                        </li> --}}
                        <li class="active">
                            <a href="{{ URL('/dashboard') }}"><i class="fas fa-dashboard fa-xl"></i><span>Dashboard</span></a>
                        </li>
                        <li class="">
                            <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/income?dsh=1') }}"><i class="fas fa-money-bill-trend-up fa-xl"></i> <span>Income</span></a>
                        </li>
                        <li class="">
                            <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/expense?dsh=1') }}"><i class="fas fa-money-bill-transfer fa-lg"></i> <span>Expense</span></a>
                        </li>
                        <li class="">
                            <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/bank_accounts?dsh=1') }}"><i class="fas fa-building-columns fa-xl"></i><span>Bank Accounts</span></a>
                        </li>
                        <li class="">
                            <a class="dashboard-iframe-links" target="dashboard-iframe" href="{{ URL('/dashboard/category?dsh=1') }}"><i class="fas fa-shapes fa-xl"></i><span>Category</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="page-wrapper">

            <div class="dashboard-content content container-fluid">

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome{{ Session::get('normalUserFsLgin') == 1 ? '' : ' back, ' }} {{ session::get('normalUserName') }}!</h3>
                        </div>
                    </div>
                </div>

				<div class="row">
					<div class="col-12">
						<div class="row">
							<div class="col-xxl-6 col-xl-4 col-lg-12 col-md-12 col-sm-12">
								<div class="card dash-widget">
									<div class="card-body">
										<span class="dash-widget-icon"><i class="fas fa-coins"></i></span>
										<div class="dash-widget-info">
											<h3>{{ $totalBalance < 0 ? 0 : $totalBalance }}</h3>
											<span>Total Balance</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
								<div class="card dash-widget">
									<div class="card-body">
										<span class="dash-widget-icon text-success"><i class="fas fa-angles-up"></i></span>
										<div class="dash-widget-info">
											<h3>{{ $totalMonthlyIncomeValue }}</h3>
											<span>Monthly Income</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6">
								<div class="card dash-widget">
									<div class="card-body">
										<span class="dash-widget-icon text-danger"><i class="fas fa-angles-down"></i></span>
										<div class="dash-widget-info">
											<h3>{{ $totalMonthlyExpenseValue }}</h3>
											<span>Monthly Expense</span>
										</div>
									</div>
								</div>
							</div>
							{{-- <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
								<div class="card dash-widget">
									<div class="card-body">
										<span class="dash-widget-icon"><i class="fa fa-wallet"></i></span>
										<div class="dash-widget-info">
											<h3>218</h3>
											<span>Cash On Hand</span>
										</div>
									</div>
								</div>
							</div> --}}
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-12 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Recent Expense's</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if (count($recentExpense) > 0)
                                        <table class="table table-nowrap custom-table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Account Name</th>
                                                    <th>Category Name</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $expenseId = 1; ?>
                                                @foreach ($recentExpense as $rsRecentExpense)
                                                    <tr>
                                                        <td>{{ $expenseId }}</td>
                                                        <td>{{ \App\ASPLibraries\CustomFunctions::decrypt( $rsRecentExpense->account_name ) }}</td>
                                                        <td>{{ $rsRecentExpense->category_name }}</td>
                                                        <td>{{ \App\ASPLibraries\CustomFunctions::decrypt( $rsRecentExpense->amount ) }} Rs</td>
                                                        <td>{{ $rsRecentExpense->date }}</td>
                                                    </tr>
                                                    <?php $expenseId++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="pt-3 text-center">No Data To Show.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Recent Income's</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    @if (count($recentIncome) > 0)
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
                                                <?php $incomeId = 1; ?>
                                                @foreach ($recentIncome as $rsRecentIncome)
                                                    <tr>
                                                    <td>{{ $incomeId }}</td>
                                                    <td>{{ \App\ASPLibraries\CustomFunctions::decrypt( $rsRecentIncome->account_name ) }}</td>
                                                    <td>{{ \App\ASPLibraries\CustomFunctions::decrypt( $rsRecentIncome->source ) }}</td>
                                                    <td>{{ \App\ASPLibraries\CustomFunctions::decrypt( $rsRecentIncome->amount ) }} Rs</td>
                                                    <td>{{ $rsRecentIncome->date }}</td>
                                                    </tr>
                                                    <?php $incomeId++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="pt-3 text-center">No Data To Show.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="dashboard-iframe content container-fluid d-none" style="margin:0px;padding:0px;overflow:hidden;">
                <iframe class="rounded-0" name="dashboard-iframe" frameborder="0" style="padding-top: 3.7rem !important;overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
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
    <script src="{{ asset('assets/template_assets/js/layout.js') }}"></script>
    <!-- Template Assets Theme Settings Js -->
    <script src="{{ asset('assets/template_assets/js/theme-settings.js') }}"></script>
    <!-- Template Assets Slim Scroll Js -->
    <script src="{{ asset('assets/template_assets/js/jquery.slimscroll.min.js') }}"></script>
    <!-- Template Assets Greedy Nav Js -->
    <script src="{{ asset('assets/template_assets/js/greedynav.js') }}"></script>
    <!-- Template Assets Morris Js -->
    <script src="{{ asset('assets/template_assets/plugins/morris/morris.min.js') }}"></script>
    <!-- Template Assets Raphael Js -->
    <script src="{{ asset('assets/template_assets/plugins/raphael/raphael.min.js') }}"></script>
    <!-- Template Assets Chart Js -->
    <script src="{{ asset('assets/template_assets/js/chart.js') }}"></script>
    <!-- Template Assets App Js -->
    <script src="{{ asset('assets/template_assets/js/app.js') }}"></script>

    <script>
        $(document).on('click', "#sidebar-menu > ul > li", function() {
            var firstLi = $(this);
            var firstLiAnchor = firstLi.find("a");
            if (firstLiAnchor.find("span.menu-arrow").length == 0) {
                firstLi.addClass("active").siblings().removeClass("active");
                firstLi.prev().removeClass("active");
            }
            if ($(firstLi).hasClass('submenu')) {

            } else {
                $('.dashboard-content').addClass('d-none');
                $('.dashboard-iframe').removeClass('d-none');
            }
        });

        $(document).on('click', ".dashboard-iframe-links", function() {
            var urlLink = $(this).attr('href');
            var lastIndex = urlLink.lastIndexOf("?");
            var newUrl = urlLink.substring(0, lastIndex);

            window.history.pushState('', '', newUrl)
        });

        // $(document).on('click', ".submenu ul li a", function () {
        //   var $this = $(this);
        //   var $parentLi = $this.parent("li");
        //   var $siblingsLi = $parentLi.siblings("li");

        //   $('.dashboard-content').addClass('d-none');
        //   $('.dashboard-iframe').removeClass('d-none');

        //   // Check if the clicked element's siblings have active class
        //   if ($siblingsLi.children("a").hasClass("active")) {
        //     // Remove active class from all siblings
        //     $siblingsLi.children("a").removeClass("active");
        //   }

        //   // Check if the clicked element's siblings have active class
        //   if ($('#sidebar-menu > ul > li').hasClass("active")) {
        //     // Remove active class from all siblings
        //     $('#sidebar-menu > ul > li').removeClass("active");
        //   }

        //   // Check if the clicked element's parent has active class
        //   if ($('.submenu').each(function () {
        //     $('.submenu ul li a').hasClass("active")
        //   })) {
        //     // Remove active class from parent
        //     $('.submenu').each(function () {
        //       $('.submenu ul li a').removeClass("active")
        //     });
        //   }

        //   // Add active class to clicked element
        //   $this.addClass("active");
        // });

    </script>

</body>

</html>
