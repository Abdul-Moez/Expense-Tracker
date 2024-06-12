<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Accounts - Expense Tracker</title>

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
                    <h3 class="page-title">Bank Accounts</h3>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_bank_account"><i class="fa fa-plus"></i> Add Bank Accounts</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="stats-info">
                    <h6>High Balance Account</h6>
                    <h4>{{ $bankAccountNameDesc == '' ? '(N/A)' : $bankAccountNameDesc }}</h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stats-info">
                    <h6>Low Balance Account</h6>
                    <h4>{{ $bankAccountNameAsc == '' ? '(N/A)' : $bankAccountNameAsc }}</h4>
                </div>
            </div>
            {{-- <div class="col-md-3">
            <div class="stats-info">
                <h6>Unplanned Leaves</h6>
                <h4>0 <span>Today</span></h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-info">
                <h6>Pending Requests</h6>
                <h4>12</h4>
            </div>
        </div> --}}
        </div>

        {{-- <form class="row filter-row" action="javascript:void(0);">
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="filter_account_name" name="filter_account_name">
                <label class="focus-label">Bank Account Name</label>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="filter_account_number" name="filter_account_number">
                <label class="focus-label">Bank Account Number</label>
            </div>
        </div>
        <div class="row col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="col-xxl-6 col-xl-12 mb-3 p-0">
                <div class="form-floating">
                    <select class="form-select" id="filter_account_type" name="filter_account_type">
                        <option value="">Select Account Type</option>
                        <option value="Personal">Personal</option>
                        <option value="Savings">Savings</option>
                        <option value="Business">Business</option>
                        <option value="Cash Wallet">Cash Wallet</option>
                    </select>
                    <label class="focus-label">Bank Account Type</label>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-12 mb-3 p-0">
                <div class="form-floating">
                    <select class="form-select" id="filter_account_active" name="filter_account_active">
                        <option value="">Select Active</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label class="focus-label">Active</label>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
            <button class="btn btn-success btn-block w-100 h-100" name="filter_account_btn" id="filter_account_btn" type="submit"> Search </button>
        </div>
    </form> --}}
        <form class="d-flex justify-content-around align-items-center text-center gap-4 flex-xxl-nowrap flex-xl-nowrap flex-lg-nowrap flex-md-wrap flex-wrap mb-3" action="javascript:void(0);">
            <div class="w-100">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filter_account_name" name="filter_account_name">
                    <label class="focus-label">Bank Account Name</label>
                </div>
            </div>
            <div class="w-100">
                <div class="form-floating">
                    <input type="text" class="form-control" id="filter_account_number" name="filter_account_number">
                    <label class="focus-label">Bank Account Number</label>
                </div>
            </div>
            <div class="w-100">
                <div class="form-floating">
                    <select class="form-select" id="filter_account_type" name="filter_account_type">
                        <option value="">Select Account Type</option>
                        <option value="Personal">Personal</option>
                        <option value="Savings">Savings</option>
                        <option value="Business">Business</option>
                        <option value="Cash Wallet">Cash Wallet</option>
                    </select>
                    <label class="focus-label">Bank Account Type</label>
                </div>
            </div>
            <div class="w-100">
                <div class="form-floating">
                    <select class="form-select" id="filter_account_active" name="filter_account_active">
                        <option value="">Select Active</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                    <label class="focus-label">Active</label>
                </div>
            </div>
            <div class="w-100">
                <button class="btn btn-success btn-block w-100 h-100 py-3" name="filter_account_btn" id="filter_account_btn" type="submit"> Search </button>
            </div>
        </form>

        <div class="row bank_accounts_body">
            @include('ajax/ajax_bank_account_body')
        </div>
    </div>

    <div class="dashboard-iframe content container-fluid d-none" style="margin:0px;padding:0px;overflow:hidden;">
        <iframe class="rounded-0" name="dashboard-iframe" frameborder="0" style="padding-top: 3.7rem !important;overflow:hidden;overflow-x:hidden;overflow-y:hidden;height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
    </div>

    @include('includes/dynamic_sidebar_footer')


    <div id="add_bank_account" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Bank Account</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="add_bank_account_name" name="add_bank_account_name" required>
                            <label>Account Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="add_bank_account_type" name="add_bank_account_type" required>
                                <option value="">Select Account Type</option>
                                <option value="Personal">Personal</option>
                                <option value="Savings">Savings</option>
                                <option value="Business">Business</option>
                                <option value="Cash Wallet">Cash Wallet</option>
                            </select>
                            <label class="focus-label">Select Account Type <span class="text-danger">*</span></label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="add_bank_account_number" name="add_bank_account_number" required>
                            <label>Account Number <span class="text-danger">*</span></label>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <button class="btn btn-primary submit-btn" id="add_bank_account_btn">Add Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="edit_bank_account" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Bank Account</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit_bank_account_body">
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
    <!-- Bank Account JavaScript -->
    <script src="{{ URL('/assets/js/bankAcc.js') }}"></script>
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