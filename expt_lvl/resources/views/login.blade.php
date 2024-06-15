<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login - Expense Tracker</title>

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
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="container-fluid">

                <div class="account-logo">
                    <a href="{{ URL('/') }}"><img src="{{ URL('assets/img/logo.png') }}" alt="Expense Tracker Logo" class="img-fluid"></a>
                </div>

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title text-dark">Welcome,</h3>
                        <p class="account-subtitle">Please Login!</p>

                        <form action="javascript.void(0);">
                            <div class="form-group">
                                <input class="form-control" type="email" value="" id="user-email" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <div class="position-relative">
                                    <input class="form-control" type="password" value="" id="user-password" placeholder="Password">
                                    <span class="fa fa-eye-slash" id="toggle-password"></span>
                                </div>
                                <div class="text-end mt-1">
                                    <a href="{{ URL('/forgot_password.htm') }}">
                                        Forgot your password?
                                    </a>
                                </div>
                            </div>
                            <div id="login-loader" class="my-2 d-none loader-body">
                                <img src="{{ URL('assets/img/custom_loader.svg') }}" class="img-fluid">
                            </div>
                            <div id="login-success" class="alert alert-success mt-2 d-none">Login Successfull redirecting</div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit" id="user-login-btn">Login</button>
                            </div>
                            <div class="account-footer">
                                <p>Don't have an account yet? <a href="{{ URL('/register') }}">Register Now!</a></p>
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
    <script src="{{ URL('/assets/js/authHandler.js') }}"></script>
    <!-- Sweet Alert Js -->
    <script src="{{ URL('/assets/sweet_alert/sweetalert2.min.js') }}"></script>

    <!-- Template Assets App Js -->
    <script src="{{ URL('assets/template_assets/js/app.js') }}"></script>
</body>
</html>