<?php use Illuminate\Support\Facades\Session; ?>
<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Dashboard - Expense Tracker</title>

    <!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <!-- Cutom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/all.min.css') }}">
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ asset('assets/sweet_alert/sweetalert2.min.css') }}">

    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/style.css') }}">
</head>

<body>

    <div id="big_loader" class="my-2 justify-content-center align-items-center loader-body w-100 h-100 position-fixed m-0 top-0 mt-0" style="z-index: 999999">
        {{-- <img src="{{ asset('assets/img/loader_new.gif') }}" class="img-fluid" alt=""> --}}
        <img src="{{ asset('assets/img/custom_loader.svg') }}" class="img-fluid" alt="" style="width:8%;">
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
                        <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit_prof_data">Edit Profile</a>
                        <a class="dropdown-item logout-btn" href="javascript:void(0)">Logout</a>
                    </div>
                </li>
            </ul>


            <div class="dropdown mobile-user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit_prof_data">Edit Profile</a>
                    {{-- <a class="dropdown-item" href="#" disabled>{{ session::get('normalUserName') }}</a> --}}
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

            <div class="dashboard-content container-fluid">

                <div class="page-header my-3">
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
											<h3>Rs {{ $totalBalance < 0 ? 0 : number_format($totalBalance, 2, ".", ",") }}</h3>
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
											<h3>Rs {{ number_format($totalMonthlyIncomeValue, 2, ".", ",") }}</h3>
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
											<h3>Rs {{ number_format($totalMonthlyExpenseValue, 2, ".", ",") }}</h3>
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
                                                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsRecentExpense->account_name, Session::get('normalUserEncryptKey')) }}</td>
                                                        <td>{{ $rsRecentExpense->category_name }}</td>
                                                        <td>Rs {{ number_format(\App\ASPLibraries\CustomFunctions::customDecrypt($rsRecentExpense->amount, Session::get('normalUserEncryptKey')), 2, ".", ",") }}</td>
                                                        <td>{{ $rsRecentExpense->date }}</td>
                                                    </tr>
                                                    <?php $expenseId++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="py-3 text-center">No Data To Show.</div>
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
                                                    <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsRecentIncome->account_name, Session::get('normalUserEncryptKey')) }}</td>
                                                    <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsRecentIncome->source, Session::get('normalUserEncryptKey')) }}</td>
                                                    <td>Rs {{ number_format(\App\ASPLibraries\CustomFunctions::customDecrypt($rsRecentIncome->amount, Session::get('normalUserEncryptKey')), 2, ".", ",") }}</td>
                                                    <td>{{ $rsRecentIncome->date }}</td>
                                                    </tr>
                                                    <?php $incomeId++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="py-3 text-center">No Data To Show.</div>
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

            <div id="edit_prof_data" class="modal custom-modal fade" data-bs-backdrop="static" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit your profile</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" title="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form action="javascript:void(0);">
                                <div class="row mx-auto p-0 m-0">
                                    <div class="col-lg-6 col-md-12 p-0 pe-xxl-2 pe-xl-2 pe-lg-2 pe-md-0">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Your name" id="edit_prof_name" name="edit_prof_name" value="{{ session::get('normalUserName') }}">
                                            <label class="focus-label" for="edit_prof_name">Your name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 p-0 ps-xxl-2 ps-xl-2 ps-lg-2 ps-md-0">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" placeholder="Your email" id="edit_prof_email" name="edit_prof_email" value="{{ session::get('normalUserEmail') }}">
                                            <label class="focus-label" for="edit_prof_email">Your email</label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4 class="m-0">Update Password</h4>
                                <small class="fs-14">note: Leave password fields empty if not changing.</small>
                                <br>
                                <br>
                                <div class="row mx-auto p-0 m-0">
                                    <div class="col-12 p-0">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" placeholder="Enter current password" id="edit_prof_curr_pass" name="edit_prof_curr_pass">
                                            <span class="fa fa-eye-slash" id="edit-prof-toggle-cur-password"></span>
                                            <label class="focus-label" for="edit_prof_curr_pass">Enter current password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 p-0 pe-xxl-2 pe-xl-2 pe-lg-2 pe-md-0">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" placeholder="Enter new password" id="edit_prof_new_pass" name="edit_prof_new_pass">
                                            <span class="fa fa-eye-slash" id="edit-prof-toggle-new-password"></span>
                                            <label class="focus-label" for="edit_prof_new_pass">Enter new password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12 p-0 ps-xxl-2 ps-xl-2 ps-lg-2 ps-md-0">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" placeholder="Confirm new password" id="edit_prof_cnfrm_new_pass" name="edit_prof_cnfrm_new_pass">
                                            <span class="fa fa-eye-slash" id="edit-prof-toggle-cnfrm-new-password"></span>
                                            <label class="focus-label" for="edit_prof_cnfrm_new_pass">Confirm new password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success" id="update_prof_info" name="update_prof_info">Update</button>
                                </div>
                            </form>
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
    <!-- Dashboard JavaScript -->
    <script src="{{ URL('/assets/js/dash.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ URL('/assets/js/script.js') }}"></script>
    <!-- Sweet Alert Js -->
    <script src="{{ URL('/assets/sweet_alert/sweetalert2.min.js') }}"></script>

    <!-- Template Assets App Js -->
    <script src="{{ asset('assets/template_assets/js/app.js') }}"></script>
</body>
</html>