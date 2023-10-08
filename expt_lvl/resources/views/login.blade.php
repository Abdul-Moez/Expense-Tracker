<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login - Expense Tracker</title>

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


    <!-- Template Assets Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/bootstrap.min.css') }}">
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
    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ URL('assets/template_assets/css/style.css') }}">
</head>

<body class="account-page">

    <div class="main-wrapper">
      <div class="account-content">
        <div class="container">

          <div class="account-logo">
            <a href="{{ URL('/') }}"><img src="{{ URL('assets/img/logo.png') }}" alt="Expense Tracker"></a>
          </div>

          <div class="account-box">
            <div class="account-wrapper">
              <h3 class="account-title text-dark">Login</h3>
              <p class="account-subtitle">Access to your account</p>

              <form action="javascript.void(0);">
                <div class="form-group">
                  <label>Email Address</label>
                  <input class="form-control" type="email" value="" id="user-email">
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col">
                      <label>Password</label>
                    </div>
                    {{-- <div class="col-auto">
                      <a class="text-muted" href="forgot-password.html">
                        Forgot password?
                      </a>
                    </div> --}}
                  </div>
                  <div class="position-relative">
                    <input class="form-control" type="password" value="" id="user-password">
                    <span class="fa fa-eye-slash" id="toggle-password"></span>
                  </div>
                </div>
                <div class="form-group text-center">
                  <button class="btn btn-primary account-btn" type="submit" id="user-login-btn">Login</button>
                </div>
                <div class="account-footer">
                  <p>Don't have an account yet? <a href="{{ URL('/register') }}">Register</a></p>
                </div>
              </form>

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

    <!-- Template Assets Jquery -->
    <script src="{{ URL('assets/template_assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Template Assets Bootstrap Js -->
    <script src="{{ URL('assets/template_assets/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Template Assets Layout Js -->
    <script src="{{ URL('assets/template_assets/js/layout.js') }}"></script>
    <!-- Template Assets Theme Settings Js -->
    <script src="{{ URL('assets/template_assets/js/theme-settings.js') }}"></script>
    <!-- Template Assets Greedy Nav Js -->
    <script src="{{ URL('assets/template_assets/js/greedynav.js') }}"></script>
    <!-- Template Assets App Js -->
    <script src="{{ URL('assets/template_assets/js/app.js') }}"></script>
</body>
</html>
