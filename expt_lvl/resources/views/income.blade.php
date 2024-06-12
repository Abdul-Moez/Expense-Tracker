<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Income - Expense Tracker</title>

    <!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL('assets/img/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL('assets/bootstrap/bootstrap.min.css') }}">
    <!-- Cutom CSS -->
    <link rel="stylesheet" href="{{ URL('assets/css/style.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/fontawesome/all.min.css') }}">
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ URL('assets/sweet_alert/sweetalert2.min.css') }}">

    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/style.css') }}">
    <!-- Template Assets Bootstrap Datatables CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/dataTables.bootstrap4.min.css') }}">
</head>

<body>

    <div id="big_loader" class="my-2 justify-content-center align-items-center loader-body w-100 h-100 position-fixed m-0 top-0 mt-0" style="z-index: 999999">
        {{-- <img src="{{ asset('assets/img/loader_new.gif') }}" class="img-fluid" alt=""> --}}
        <img src="{{ asset('assets/img/custom_loader.svg') }}" class="img-fluid" alt="" style="width:8%;">
    </div>

    @include('includes/dynamic_sidebar')

    <div class="dashboard-content container-fluid">

        <div class="page-header my-3">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Income</h3>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_income"><i class="fa fa-plus"></i> Add Income</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Recent Income</h6>
                    @if (count($incomeList) > 0)
                        @foreach ($incomeList as $rsIncomeList)
                            <h4><span>Rs </span>{{ number_format(\App\ASPLibraries\CustomFunctions::customDecrypt($rsIncomeList->amount, Session::get('normalUserEncryptKey')), 2, ".", ",") }}</h4>
                            <?php break; ?>
                        @endforeach
                    @else
                        <h4><span>Rs </span> 0</h4>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Total Current Month Income</h6>
                    <h4><span>Rs </span>{{ number_format($currentMonthsTotalIncome, 2, ".", ",") }}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-info">
                    <h6>Total Income</h6>
                    <h4><span>Rs </span>{{ number_format($totalIncome, 2, ".", ",") }}</h4>
                </div>
            </div>
        </div>

        <form class="row filter-row" action="javascript:void(0);">
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="filter_income_account" name="filter_income_account">
                        <option value="">Select Bank Account</option>
                        @foreach ($bankAccountsName as $rsBankAccountsName)
                            <option value="{{ $rsBankAccountsName->id }}">{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsName->account_name, Session::get('normalUserEncryptKey')) }}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Select Bank Account</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="filter_income_month" name="filter_income_month">
                        <option value="">Select Income Month</option>
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">May</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Aug</option>
                        <option value="9">Sep</option>
                        <option value="10">Oct</option>
                        <option value="11">Nov</option>
                        <option value="12">Dec</option>
                    </select>
                    <label class="focus-label">Select Income Month</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-3 col-12 mb-3">
                <div class="form-floating">
                    <select class="form-select" id="filter_income_year" name="filter_income_year">
                        <option value="">Select Income Year</option>
                        <?php
                        $current_year = date('Y');
                        for ($i = 0; $i <= 10; $i++) {
                            $year = $current_year - $i;
                    ?>
                        <option value="{{ $year }}">{{ $year }}</option>
                        <?php
                        }
                    ?>
                    </select>
                    <label class="focus-label">Select Income Year</label>
                </div>
            </div>
            {{-- <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12 mb-3">
                <div class="form-floating">
                <input class="form-control" placeholder="Search Income Source" type="test" id="filter_income_source" name="filter_income_source">
                <label class="focus-label">Search Income Source</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-2 col-12 mb-3">
                <div class="form-floating">
                <input class="form-control" placeholder="Search Income Amount" type="text" id="filter_income_amount" name="filter_income_amount">
                <label class="focus-label">Search Income Amount</label>
                </div>
            </div> --}}
            <div class="col-sm-6 col-md-3 col-lg-3 col-xl-23col-12 mb-3">
                <button class="btn btn-success h-100 w-100" id="filter_income_btn" name="filter_income_btn"> Search </button>
            </div>
        </form>

        <div class="row income_body">
            @include('ajax/ajax_income_body')
        </div>
    </div>

    <div class="dashboard-iframe content container-fluid d-none" style="margin:0px;padding:0px;overflow:hidden;">
        <iframe class="rounded-0" name="dashboard-iframe" frameborder="0" style="padding-top: 3.7rem !important;overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
    </div>

    @include('includes/dynamic_sidebar_footer')


    <div id="add_income" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Income</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0);">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="add_income_account" name="add_income_account">
                                <option value="">Select Bank Account</option>
                                @foreach ($bankAccountsName as $rsBankAccountsName)
                                    <option value="{{ $rsBankAccountsName->id }}">{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsName->account_name, Session::get('normalUserEncryptKey')) }}</option>
                                @endforeach
                            </select>
                            <label class="focus-label">Select Bank Account</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Enter Income Source" id="add_income_source" name="add_income_source">
                            <label class="focus-label">Enter Income Source</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="Enter Income Amount" id="add_income_amount" name="add_income_amount">
                            <label class="focus-label">Enter Income Amount</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea id="add_income_description" name="add_income_description" cols="30" rows="5" class="form-control h-auto" placeholder="Enter Income Description"></textarea>
                            <label class="focus-label">Enter Income Description</label>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary submit-btn" id="add_income_btn" name="add_income_btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="edit_income" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Income</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body income_body_edit">
                </div>
            </div>
        </div>
    </div>


    <div class="modal custom-modal fade" id="delete_approve" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Leave</h3>
                        <p>Are you sure want to delete this leave?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
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
    <!-- Income JavaScript -->
    <script src="{{ URL('/assets/js/inc.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ URL('/assets/js/script.js') }}"></script>
    <!-- Sweet Alert Js -->
    <script src="{{ URL('/assets/sweet_alert/sweetalert2.min.js') }}"></script>

    <!-- Template Assets App Js -->
    <script src="{{ URL('assets/template_assets/js/app.js') }}"></script>
    <!-- Template Assets Jquery Datatables Js -->
    <script src="{{ URL('assets/template_assets/js/jquery.dataTables.min.js') }}"></script>
    <!-- Template Assets Bootstrap Datatables Js -->
    <script src="{{ URL('assets/template_assets/js/dataTables.bootstrap4.min.js') }}"></script>
</body>
</html>