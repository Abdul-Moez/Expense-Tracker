<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Category - Expense Tracker</title>

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
    <!-- Template Assets Bootstrap Datatables CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/dataTables.bootstrap4.min.css') }}">
    <!-- Template Assets Select 2 CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/select2.min.css') }}">
    <!-- Template Assets Bootstrap DateTimePicker CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/bootstrap-datetimepicker.min.css') }}">
</head>
<body>

    <div id="big_loader" class="d-none my-2 justify-content-center align-items-center loader-body w-100 h-100 position-fixed m-0 top-0 mt-0" style="z-index: 999999">
      <img src="{{ URL("assets/img/loader.gif") }}" class="img-fluid" alt="">
    </div>     
      
    <div class="content container-fluid">

      <div class="page-header my-3">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="page-title">Category</h3>
          </div>
          <div class="col-auto float-end ms-auto">
            <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_category"><i class="fa fa-plus"></i> Add Category</a>
          </div>
        </div>
      </div>


      {{-- <div class="row">
        <div class="col-md-4">
          <div class="stats-info">
            <h6>Recent Category</h6>
            <h4>12 / 60</h4>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stats-info">
            <h6>Monthly Income</h6>
            <h4>8 <span>Today</span></h4>
          </div>
        </div>
        <div class="col-md-4">
          <div class="stats-info">
            <h6>Total Income</h6>
            <h4>8 <span>Today</span></h4>
          </div>
        </div>
        <div class="col-md-3">
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
        </div>
      </div> --}}


      <form class="row" action="javascript:void(0)">
        <div class="col-sm-4 col-12 mb-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="filter_category_name">
            <label class="focus-label">Category Name</label>
          </div>
        </div>
        <div class="col-sm-4 col-12 mb-3">
          <div class="form-floating">
            <select class="form-select" id="filter_category_active" name="filter_category_active">
                <option value="">Select Active</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <label class="focus-label">Active</label>
          </div>
        </div>
        <div class="col-sm-4 col-12 mb-3">
          <button class="btn btn-success h-100 w-100" id="filter_category_btn" type="submit"> Search </button>
        </div>
      </form>

      <div class="row category_filter_body">
        @include('ajax/ajax_category_body')
      </div>
    </div>


    <div id="add_category" class="modal custom-modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Category</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="category-name">Categpry Name <span class="text-danger">*</span></label>
                <input class="form-control" type="text" id="category-name">
              </div>
              <div class="w-100 d-flex justify-content-center">
                <button class="btn btn-primary submit-btn" id="category-add">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div id="edit_category" class="modal custom-modal fade" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Leave</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body edit_category_body">
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
<!-- Template Assets Select 2 Js -->
<script src="{{ URL('assets/template_assets/js/select2.min.js') }}"></script>
<!-- Template Assets Jquery Datatables Js -->
<script src="{{ URL('assets/template_assets/js/jquery.dataTables.min.js') }}"></script>
<!-- Template Assets Bootstrap Datatables Js -->
<script src="{{ URL('assets/template_assets/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Template Assets Moment Js -->
<script src="{{ URL('assets/template_assets/js/moment.min.js') }}"></script>
<!-- Template Assets Bootstrap Datetimepicker Js -->
<script src="{{ URL('assets/template_assets/js/bootstrap-datetimepicker.min.js') }}"></script>

</body>
</html>