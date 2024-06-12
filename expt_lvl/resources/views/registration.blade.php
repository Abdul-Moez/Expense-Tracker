<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Register - Expense Tracker</title>

    <!-- FavIcon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <!-- Cutom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ URL('assets/fontawesome/all.min.css') }}">
    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="{{ asset('assets/sweet_alert/sweetalert2.min.css') }}">

    <!-- Template Assets Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/template_assets/css/style.css') }}">
</head>
<body class="account-page">
    <div class="main-wrapper">
        <div class="account-content">
            <div class="container">
                <div class="account-logo">
                    <a href="{{ URL('/') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="Expense Tracker"></a>
                </div>
                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title text-dark">Welcome,</h3>
                        <p class="account-subtitle">Please Register!</p>
                        <form action="javascript:void(0)">
                            <div class="form-group">
                                <input class="form-control" type="text" id="user-register-name" placeholder="Name*">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email" id="user-register-email" placeholder="Email*">
                            </div>
                            <div class="form-group">
                                <div class="position-relative">
									<input class="form-control" type="password" id="user-register-pass" placeholder="Password*">
                                    <span class="fa fa-eye-slash" id="toggle-password-register"></span>
                                </div>
                            </div>
                            <div class="form-group">
								<div class="position-relative">
									<input class="form-control" type="password" id="user-register-repass" placeholder="Repeat Password*">
									<span class="fa fa-eye-slash" id="toggle-rep-password-register"></span>
								</div>
                            </div>
                            <div id="register-loader" class="my-2 d-none loader-body">
                                <img src="{{ asset('assets/img/custom_loader.svg') }}" class="loader-img" alt="">
                            </div>
                            <div id="register-success" class="alert alert-success mt-2 d-none">Registration Successfull redirecting</div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" id="user-register-btn" type="submit">Register</button>
                            </div>
                            <div class="account-footer">
                                <p>Already have an account? <a href="{{ URL('/') }}">Login!</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- Font Awesome JS -->
    <script src="{{ URL('/assets/fontawesome/all.min.js') }}"></script>
    <!-- jQuery File -->
    <script src="{{ asset('assets/js/jquery_3.6.3.min.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/js/authHandler.js') }}"></script>
    <!-- Sweet Alert Js -->
    <script src="{{ asset('assets/sweet_alert/sweetalert2.min.js') }}"></script>

    <!-- Template Assets App Js -->
    <script src="{{ asset('assets/template_assets/js/app.js') }}"></script>
</body>

</html>