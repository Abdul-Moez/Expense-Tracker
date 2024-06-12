<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Reset Password - Expense Tracker</title>

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
    <?php

        $url = request()->url();
        $lastSegment = substr($url, strrpos($url, '/') + 1);

    ?>

    <div class="main-wrapper">
        <div class="account-content">
            <div class="container-fluid">

                <div class="account-logo">
                    <a href="{{ URL('/') }}"><img src="{{ URL('assets/img/logo.png') }}" alt="Expense Tracker Logo" class="img-fluid"></a>
                </div>

                <div class="account-box">
                    <div class="account-wrapper">
                        <h3 class="account-title text-dark">Reset Password</h3>
                        <p class="account-subtitle">Fill the fileds below to reset your password</p>

                        <form action="javascript.void(0);">
                            <div class="form-group">
                                <input class="form-control" type="text" id="resetNewPassword" name="resetNewPassword" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" id="resetConfirmNewPassword" name="resetConfirmNewPassword" placeholder="Confirm New Password">
                            </div>
                            <input type="text" name="url_email" id="url_email" value="{{ $lastSegment }}" class="d-none">

                            <div id="resetPass-loader" class="my-2 d-none loader-body">
                                <img src="{{ URL('assets/img/custom_loader.svg') }}" class="loader-img" alt="">
                            </div>
                            <div id="resetPass-success" class="alert alert-success mt-2 d-none">Your password has been reset please <a href="/">login</a>.</div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" id="resetPassBtn" name="resetPassBtn" type="submit">Reset Password</button>
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
